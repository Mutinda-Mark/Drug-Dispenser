<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";



$conn = mysqli_connect($servername,$username,$password,$database);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user's SSN from the submitted form
    $SSN = $_POST['SSN'];

    // Delete the user's information from the database
    $query = "DELETE FROM tbl_patient WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $SSN);
    $stmt->execute();

    // Redirect back to the main page
    header("Location: view_patients.php");
    exit;
}
?>