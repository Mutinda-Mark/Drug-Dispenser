<!DOCTYPE html>
<html>
<head>
    <title>Prescription</title>
</head>
<body>
    <h2>Prescription Form</h2>

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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $doctorSSN = $_SESSION['name'];
        $patientSSN = $_POST['SSN'];
        $prescriptionID = $_POST['prescriptionID'];
        $dName = $_POST['dName'];
        $dQty = $_POST['dQty'];
        $dId = $_POST['dId'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        // Validate and sanitize input fields here
        // ...

        // Insert the prescription into the database
        $query = "INSERT INTO tbl_prescription (prescription_ID, D_Name, D_Qty, D_ID, doctor_SSN, patient_SSN, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ississss", $prescriptionID, $dName, $dQty, $dId, $doctorSSN, $patientSSN, $startDate, $endDate);

        if ($stmt->execute()) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: doctor_view_patient.php?success=true");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: doctor_view_patient.php?success=false&error=" . urlencode("Failed to add the prescription. Please try again later."));
            exit();
        }
        
        

        $stmt->close();
    }

    // Retrieve drug data for the dropdown list
    $drugQuery = "SELECT D_ID, D_Name FROM tbl_drugs";
    $drugResult = $conn->query($drugQuery);

    $conn->close();
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="SSN" value="<?php echo $_POST['SSN']; ?>">
        <label for="prescriptionID">Prescription ID:</label>
        <input type="text" name="prescriptionID" required><br><br>

        <label for="dId">Drug ID:</label>
        <select name="dId" required>
            <?php while ($row = $drugResult->fetch_assoc()) : ?>
                <option value="<?php echo $row['D_ID']; ?>"><?php echo $row['D_ID']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="dName">Drug Name:</label>
        <select name="dName" required>
            <?php
            // Reset the drugResult pointer to the beginning
            $drugResult->data_seek(0);
            while ($row = $drugResult->fetch_assoc()) : ?>
                <option value="<?php echo $row['D_Name']; ?>"><?php echo $row['D_Name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="dQty">Quantity:</label>
        <input type="number" name="dQty" required><br><br>

        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" required><br><br>

        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" required><br><br>

        <input type="submit" name="submit" value="Give Prescription">
    </form>

    <button onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.location.href = "doctor_view_patient.php";
        }
    </script>
</body>
</html>


