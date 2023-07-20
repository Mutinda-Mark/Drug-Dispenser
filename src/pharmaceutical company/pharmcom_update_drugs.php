<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve drug's ID and updated information from the submitted form
    $D_ID = $_POST['D_ID'];
    $D_Name = $_POST['D_Name'];
    $D_Type = $_POST['D_Type'];
    $D_Strength = $_POST['D_Strength'];
    $D_Qty = $_POST['D_Qty'];

    // Update the drug's information in the database
    $query = "UPDATE tbl_drugs SET D_Type = ?, D_Strength = ?, D_Qty = ? ,D_Name = ? WHERE D_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisi", $D_Type, $D_Strength, $D_Qty, $D_Name, $D_ID);
    $stmt->execute();

    // Redirect back to the main page
    header("Location: pharmcom_view_drugs.php");
    exit;
}
?>