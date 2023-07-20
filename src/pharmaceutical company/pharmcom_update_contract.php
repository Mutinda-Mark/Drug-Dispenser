<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve drug's ID and updated information from the submitted form
    $contract_ID = $_POST['contract_ID'];
    $pharmcom_SSN = $_POST['pharmcom_SSN'];
    $supervisor_ID = $_POST['supervisor_ID'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Update the drug's information in the database
    $query = "UPDATE tbl_contract SET pharmcom_SSN = ?, supervisor_ID = ?, start_date = ? , end_date = ? WHERE contract_ID = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iissi", $pharmcom_SSN, $supervisor_ID, $start_date, $end_date, $contract_ID);
    $stmt->execute();

    // Redirect back to the main page
    header("Location: pharmcom_view_contract.php");
    exit;
}
?>