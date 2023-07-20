<!DOCTYPE html>
<html>
<head>
    <title>Pharmcom Contract</title>
</head>
<body>
    <h2>Pharmcom Contract</h2>

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
        $pharmcomSSN = $_SESSION['name'];
        $supervisorID = $_POST['supervisorID'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        // Validate and sanitize input fields here
        // ...

        // Insert the contract into the database
        $query = "INSERT INTO tbl_contract (pharmcom_SSN, supervisor_ID, start_date, end_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $pharmcomSSN, $supervisorID, $startDate, $endDate);

       /* if ($stmt->execute()) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo "Contract created successfully.";
            echo '<br><button onclick="goBack()">Back</button>';
            exit();
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo "Failed to create the contract. Please try again later.";
            echo '<br><button onclick="goBack()">Back</button>';
            exit();
        }*/

        if ($stmt->execute()) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: pharmcom_view_supervisor.php?success=true");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: pharmcom_view_supervisor.php?success=false&error=" . urlencode("Failed to add the prescription. Please try again later."));
            exit();
        }



        $stmt->close();
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="supervisorID" value="<?php echo isset($_POST['SSN']) ? $_POST['SSN'] : ''; ?>">
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" required><br><br>

        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" required><br><br>

        <input type="submit" name="submit" value="Create Contract">
    </form>

    <button onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.location.href = "pharmcom_view_supervisor.php";
        }
    </script>
</body>
</html>
