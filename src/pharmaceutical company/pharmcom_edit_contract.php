<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve drug's ID from the submitted form
    $D_ID = $_POST['contract_ID'];

    // Retrieve the drug's information from the database
    $query = "SELECT * FROM tbl_contract WHERE contract_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $D_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Display a form to edit the drug's information
    /** */
    if ($row) {
        ?>
        <form action="pharmcom_update_contract.php" method="POST">
            <input type="hidden" name="contract_ID" value="<?php echo $row['contract_ID']; ?>">
            <label for="pharmcom_SSN">Pharmcom SSN:</label>
            <input type="text" name="pharmcom_SSN" value="<?php echo $row['pharmcom_SSN']; ?>"><br>
            <label for="supervisor_ID">Supervisor ID:</label>
            <input type="text" name="supervisor_ID" value="<?php echo $row['supervisor_ID']; ?>"><br>
            <label for="start_date">Start Date:</label>
            <input type="text" name="start_date" value="<?php echo $row['start_date']; ?>"><br>
            <label for="end_date">End Date:</label>
            <input type="text" name="end_date" value="<?php echo $row['end_date']; ?>"><br>
            <input type="submit" value="Update">
        </form>
        <?php
    } else {
        echo "Contract not found.";
    }
}
?>