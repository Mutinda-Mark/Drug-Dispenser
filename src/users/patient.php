<!DOCTYPE html>
<html>
<head>
    <title>Patient</title>
</head>
<body>
    <center>
        <?php
        session_start(); // Start the session

        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "example";

        // Create a new connection
        $conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the patient's first name and last name from the database
        $SSN = $_SESSION['name'];

        $query = "SELECT F_name, L_name FROM tbl_patient WHERE SSN = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $SSN);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $firstName = $row['F_name'];
            $lastName = $row['L_name'];

            echo "<h2>Welcome, $firstName $lastName</h2>";
        } else {
            echo "<h2>Welcome, Patient</h2>";
        }

        $conn->close();
        ?>

        <h3>Actions:</h3>

        <form action="add_update_patient_info.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Add/Update Patient Information">
        </form>

        <form action="view_patient_info.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Patient Information">
        </form>

        <form action="view_prescription.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Prescription Given">
        </form>

        <form action="prescription_refill.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Ask for Prescription Refill">
        </form>

        <form action="view_pharmacy_details.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Pharmacy Details">
        </form>

    </center>
</body>
</html>
