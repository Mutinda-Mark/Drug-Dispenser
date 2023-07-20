<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Pagination variables
$recordsPerPage = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Retrieve total number of records
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM tbl_prescription_sold";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

// Calculate total number of pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Retrieve limited records for the current page
$sql = "SELECT * FROM tbl_prescription_sold LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prescriptions Dispensed</title>
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
    <h1>Prescriptions Dispensed</h1>
    <table>
        <tr>
            <th>Prescription ID</th>
            <th>Drug ID</th>
            <th>Drug Name</th>
            <th>Quantity</th>
            <th>Patient SSN</th>
            <th>Doctor SSN</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Price Sold</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['prescription_ID']; ?></td>
                <td><?php echo $row['D_ID']; ?></td>
                <td><?php echo $row['D_Name']; ?></td>
                <td><?php echo $row['D_Qty']; ?></td>
                <td><?php echo $row['patient_SSN']; ?></td>
                <td><?php echo $row['doctor_SSN']; ?></td>
                <td><?php echo $row['start_date']; ?></td>
                <td><?php echo $row['end_date']; ?></td>
                <td><?php echo $row['total_price']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php if ($totalPages > 1): ?>
        <div>
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo ($page + 1); ?>">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <br><button onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
