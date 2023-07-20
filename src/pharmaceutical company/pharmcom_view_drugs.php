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
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM tbl_drugs";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

// Calculate total number of pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Retrieve limited records for the current page
$sql = "SELECT * FROM tbl_drugs LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Drugs</title>
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
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Strength</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['D_ID']; ?></td>
                <td><?php echo $row['D_Name']; ?></td>
                <td><?php echo $row['D_Type']; ?></td>
                <td><?php echo $row['D_Strength']; ?></td>
                <td><?php echo $row['D_Qty']; ?></td>
                <td>
                    <form action="pharmcom_edit_drugs.php" method="POST">
                        <input type="hidden" name="D_ID" value="<?php echo $row['D_ID']; ?>">
                        <input type="submit" value="Edit">
                    </form>
                    
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