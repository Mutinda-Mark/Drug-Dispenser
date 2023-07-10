<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve drug's ID and updated information from the submitted form
    $D_Name = $_POST['D_Name'];
    $D_Type = $_POST['D_Type'];
    $D_Strength = $_POST['D_Strength'];
    $D_Qty = $_POST['D_Qty'];

    // Update the drug's information in the database
    $query = "UPDATE tbl_drugs SET D_Type = ?, D_Strength = ?, D_Qty = ? WHERE D_Name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssis", $D_Type, $D_Strength, $D_Qty, $D_Name);
    $stmt->execute();

    // Redirect back to the main page
    header("Location: view_drugs.php");
    exit;
}
?>
