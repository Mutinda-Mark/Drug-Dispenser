<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
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

        // Retrieve the admin's first name and last name from the database
        $SSN = $_SESSION['name'];

        $query = "SELECT F_name, L_name FROM tbl_admin WHERE SSN = ?";
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
            echo "<h2>Welcome, Admin</h2>";
        }

        $conn->close();
        ?>

        <h3>Actions:</h3>

        <form action="view_patients.php" method="POST">
            <input type="submit" value="Patients">
        </form>

        <form action="view_doctors.php" method="POST">
            <input type="submit" value="Doctors">
        </form>

        <form action="view_drugs.php" method="POST">
            <input type="submit" value="Drugs">
        </form>

        <form action="view_pharmacists.php" method="POST">
            <input type="submit" value="Pharmacists">
        </form>

        <form action="view_pharmcoms.php" method="POST">
            <input type="submit" value="Pharmaceutical Companies">
        </form>

        <form action="view_supervisors.php" method="POST">
            <input type="submit" value="Supervisors">
        </form>

        <form id="logoutForm">
            <input type="button" value="Log Out" onclick="goBack()">
        </form>

    </center>

    <script>
        function goBack() {
            //window.history.back();
            window.location.href = "login.html";
        }
    </script>
</body>
</html>
