<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve drug's ID from the submitted form
    $D_Name = $_POST['D_Name'];

    // Retrieve the drug's information from the database
    $query = "SELECT * FROM tbl_drugs WHERE D_Name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $D_Name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Display a form to edit the drug's information
    /**<label for="D_Name">Drug Name:</label>
            <input type="text" name="D_Name" value="<?php echo $row['D_Name']; ?>"><br> */
    if ($row) {
        ?>
        <form action="update_drugs.php" method="POST">
            <input type="hidden" name="D_Name" value="<?php echo $row['D_Name']; ?>">
            
            <label for="D_Type">Drug Type:</label>
            <input type="text" name="D_Type" value="<?php echo $row['D_Type']; ?>"><br>
            <label for="D_Strength">Drug Strength:</label>
            <input type="text" name="D_Strength" value="<?php echo $row['D_Strength']; ?>"><br>
            <label for="D_Qty">Drug Quantity:</label>
            <input type="text" name="D_Qty" value="<?php echo $row['D_Qty']; ?>"><br>
            <input type="submit" value="Update">
        </form>
        <?php
    } else {
        echo "Drug not found.";
    }
}
?>
