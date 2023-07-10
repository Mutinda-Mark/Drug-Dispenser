<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist</title>
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

        // Retrieve the pharmacist's first name and last name from the database
        $SSN = $_SESSION['name'];

        $query = "SELECT F_name, L_name FROM tbl_pharmacist WHERE SSN = ?";
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
            echo "<h2>Welcome, Pharmacist</h2>";
        }

        $conn->close();
        ?>

        <h3>Actions:</h3>

        <form action="add_update_pharmacy_details.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Add/Update Pharmacy Details">
        </form>

        <form action="view_drug_details.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Drug Details">
        </form>

        <form action="sell_drugs.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Sell Drugs to Patient">
        </form>

        <form action="view_contract_details.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Contract Details">
        </form>

        <form action="add_update_contract_details.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Add/Update Contract Details">
        </form>

        <form action="view_prescriptions.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="View Prescriptions">
        </form>

        <form action="calculate_dosage.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Calculate Dosage">
        </form>

        <form action="dispense_medicine.php" method="POST">
            <input type="hidden" name="SSN" value="<?php echo $_SESSION['name']; ?>">
            <input type="submit" value="Dispense Medicine">
        </form>

    </center>
</body>
</html>
