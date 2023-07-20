<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $type = $_POST["type"];
    $strength = $_POST["strength"];
    $quantity = $_POST["quantity"];

    $sql = "INSERT INTO tbl_drugs (D_ID,D_Name, D_Type, D_Strength, D_Qty) VALUES (?,?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssi", $id ,$name, $type, $strength, $quantity);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: pharmacist_view_drugs.php"); // Redirect to view_drugs.php
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
