<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve pharmacist's SSN from the submitted form
    $SSN = $_POST['SSN'];

    // Delete the pharmacist's information from the database
    $query = "DELETE FROM tbl_pharmacist WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $SSN);
    $stmt->execute();

    // Redirect back to the main page
    header("Location: pharmacists.php");
    exit;
}
?>
