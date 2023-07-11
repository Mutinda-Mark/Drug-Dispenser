<!DOCTYPE html>
<html>
<head>
    <title>Prescription History</title>
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
    <?php
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

    // Get the patient SSN from the previous page
    $patientSSN = $_POST['SSN'];

    // Retrieve the prescription history of the selected person
    $query = "SELECT * FROM tbl_prescription WHERE patient_SSN = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $patientSSN);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Prescription History</h2>";
        echo "<table>";
        echo "<tr>
                <th>Prescription ID</th>
                <th>Drug Name</th>
                <th>Quantity</th>
                <th>Start Date</th>
                <th>End Date</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['prescription_ID'] . "</td>
                    <td>" . $row['D_Name'] . "</td>
                    <td>" . $row['D_Qty'] . "</td>
                    <td>" . $row['start_date'] . "</td>
                    <td>" . $row['end_date'] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<h2>No Prescription History Found</h2>";
    }

    $stmt->close();
    $conn->close();
    ?>

    <br><br>
    <button onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
