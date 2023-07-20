<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

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
                    <form action="pharmacist_edit_drugs.php" method="POST">
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

    <h2>Add Drug</h2>
    <form action="pharmacist_add_drugs.php" method="POST">
        <label for="id">ID:</label>
        <input type="number" name="id" required><br><br>
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>
        <label for="type">Type:</label>
        <input type="text" name="type" required><br><br>
        <label for="strength">Strength:</label>
        <input type="text" name="strength" required><br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br><br>
        <input type="submit" value="Add Drug">
    </form>

    <button onclick="goBack()">Back</button>

    <script>
        function goBack() {
            window.location.href = "pharmacist.php";
        }
    </script>
</body>
</html>
