<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the logged-in doctor's SSN
$loggedInSSN = $_SESSION['name'];

// Retrieve the logged-in doctor's information
$sql = "SELECT * FROM tbl_pharmcom WHERE SSN = '$loggedInSSN'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>View Pharmaceutical Companies</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid black;
            }

            th, td {
                border: 1px solid black;
                padding: 8px;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <th>SSN</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Postal Address</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>

            <tr>
                <td><?php echo $row['SSN']; ?></td>
                <td><?php echo $row['F_name']; ?></td>
                <td><?php echo $row['L_name']; ?></td>
                <td><?php echo $row['P_Address']; ?></td>
                <td><?php echo $row['DOB']; ?></td>
                <td><?php echo $row['Email']; ?></td>
                <td><?php echo $row['Phone']; ?></td>
                <td><?php echo $row['Password']; ?></td>
                <td>
                    <form action="pharmcom_edit.php" method="POST">
                        <input type="hidden" name="SSN" value="<?php echo $row['SSN']; ?>">
                        <input type="submit" value="Edit">
                    </form>
                    <!--<form action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                        <input type="hidden" name="SSN" value="<?//php echo $row['SSN']; ?>">
                        <input type="submit" value="Delete">
                    </form>-->
                </td>
            </tr>
        </table>

        <button onclick="goBack()">Back</button>

        <script>
            function goBack() {
                window.location.href = "pharmaceutical_company.php";
            }
        </script>
    </body>
    </html>
    <?php
} else {
    echo "<p>No pharmaceutical company found.</p>";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>View Pharmaceutical Company</title>
    </head>
    <body>
        <button onclick="goBack()">Back</button>

        <script>
            function goBack() {
                window.location.href = "pharmaceutical_company.php";
            }
        </script>
    </body>
    </html>
    <?php
}

// Close the database connection
$conn->close();
?>