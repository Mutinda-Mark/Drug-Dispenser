<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";



$conn = mysqli_connect($servername,$username,$password,$database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user's SSN and updated information from the submitted form
    $SSN = $_POST['SSN'];
    $F_name = $_POST['F_name'];
    $L_name = $_POST['L_name'];
    $P_Address = $_POST['P_Address'];
    $DOB = $_POST['DOB'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $Password = $_POST['Password'];


    // Update the user's information in the database
    $query = "UPDATE tbl_supervisor SET F_name = ?, L_name = ?, P_Address = ?, DOB = ?, Email = ?, Phone = ?, Password = ? WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssisi", $F_name, $L_name, $P_Address, $DOB, $Email, $Phone, $Password, $SSN);
    $stmt->execute();

    // Redirect back to the main page
    header("Location: supervisor_view.php");
    exit;
}
?>