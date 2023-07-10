<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve drug's name from the submitted form
    $D_Name = $_POST['D_Name'];

    // Delete the drug's information from the database
    $query = "DELETE FROM tbl_drugs WHERE D_Name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $D_Name);
    $stmt->execute();

    // Redirect back to the main page
    header("Location: view_drugs.php");
    exit;
}
?>
