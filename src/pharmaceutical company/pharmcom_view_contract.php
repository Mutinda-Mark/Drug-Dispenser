<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";



$conn = mysqli_connect($servername,$username,$password,$database);

// Pagination variables
$recordsPerPage = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Retrieve total number of records
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM tbl_contract";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

// Calculate total number of pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Retrieve limited records for the current page
$sql = "SELECT * FROM tbl_contract LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Contracts</title>
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
            <th>Contract ID</th>
            <th>Pharmcom SSN</th>
            <th>Supervisor ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['contract_ID']; ?></td>
                <td><?php echo $row['pharmcom_SSN']; ?></td>
                <td><?php echo $row['supervisor_ID']; ?></td>
                <td><?php echo $row['start_date']; ?></td>
                <td><?php echo $row['end_date']; ?></td>
                <td>
                    <form action="pharmcom_edit_contract.php" method="POST">
                        <input type="hidden" name="contract_ID" value="<?php echo $row['contract_ID']; ?>">
                        <input type="submit" value="Edit">
                    </form>
                    <!--<form action="pharmcom_update_contract.php" method="POST">
                        <input type="hidden" name="contract_ID" value="<?php echo $row['contract_ID']; ?>">
                        <input type="submit" value="Update">
                    </form>-->
                    
                </td>
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

    <button onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.location.href = "pharmaceutical_company.php";
        }
    </script>
</body>
</html>