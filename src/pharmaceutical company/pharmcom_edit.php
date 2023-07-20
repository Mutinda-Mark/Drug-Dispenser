<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

// Create a new connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the logged-in user's SSN
    $loggedInSSN = $_SESSION['name'];

    // Retrieve the user's information from the database
    $query = "SELECT * FROM tbl_pharmcom WHERE SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $loggedInSSN);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Display a form to edit the user's information
    if ($row) {
        ?>
        <form action="pharmcom_update.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $row['SSN']; ?>">
            <label for="F_name">First Name:</label>
            <input type="text" name="F_name" value="<?php echo $row['F_name']; ?>"><br>
            <label for="L_name">Last Name:</label>
            <input type="text" name="L_name" value="<?php echo $row['L_name']; ?>"><br>
            <label for="P_Address">Postal Address:</label>
            <input type="text" name="P_Address" value="<?php echo $row['P_Address']; ?>"><br>
            <label for="DOB">DOB:</label>
            <input type="date" name="DOB" value="<?php echo $row['DOB']; ?>"><br>
            <label for="Email">Email:</label>
            <input type="email" name="Email" value="<?php echo $row['Email']; ?>"><br>
            <label for="Phone">Phone:</label>
            <input type="text" name="Phone" value="<?php echo $row['Phone']; ?>"><br>
            <label for="Password">Password:</label>
            <input type="password" name="Password" value="<?php echo $row['Password']; ?>"><br>
            <input type="submit" value="Update">
        </form>
        <?php
    } else {
        echo "User not found.";
    }
}

// Close the database connection
mysqli_close($conn);
?>