<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SSN = $_POST['SSN'];

    // Retrieve the patient's information from tbl_patient
    $query = "SELECT * FROM tbl_supervisor WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $SSN);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Move the patient's information to tbl_disabled
        $insertQuery = "INSERT INTO tbl_disabled (SSN, F_name, L_name, P_Address, DOB, Email, Phone, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("isssssis", $row['SSN'], $row['F_name'], $row['L_name'], $row['P_Address'], $row['DOB'], $row['Email'], $row['Phone'], $row['Password']);
        $insertStmt->execute();
        $insertStmt->close();

        // Delete the patient's information from tbl_patient
        $deleteQuery = "DELETE FROM tbl_pharmcom WHERE SSN = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $SSN);
        $deleteStmt->execute();
        $deleteStmt->close();

        // Provide feedback to the user
        echo "<h2>Account Disabled</h2>";
        echo "<p>Your account has been disabled successfully.</p>";
        echo "<p>Please proceed to <a href='login.html'>login</a> page.</p>";

        // Close the database connection
        $stmt->close();
        $conn->close();
        exit;
    }
}

// Redirect to login.html if cancellation or confirmation is not submitted
header("Location: login.html");
exit;
?>
