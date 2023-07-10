<!DOCTYPE html>
<html>
<head>
    <title>Doctor</title>
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

        // Retrieve the doctor's first name and last name from the database
        $SSN = $_SESSION['name'];

        $query = "SELECT F_name, L_name FROM tbl_doctor WHERE SSN = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $SSN);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $firstName = $row['F_name'];
            $lastName = $row['L_name'];

            echo "<h2>Welcome, Dr. $firstName $lastName</h2>";
        } else {
            echo "<h2>Welcome, Doctor</h2>";
        }

        $conn->close();
        ?>

        <h3>Actions:</h3>

        <form action="add_update_doctor_info.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Add/Update Doctor Information">
        </form>

        <form action="view_patient_info.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Patient Information">
        </form>

        <form action="view_prescription_history.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Prescription History">
        </form>

        <form action="prescribe_medicine.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Prescribe Medicine for Patients">
        </form>

        <form action="view_pharmacy_info.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Pharmacy Information">
        </form>

    </center>
</body>
</html>
