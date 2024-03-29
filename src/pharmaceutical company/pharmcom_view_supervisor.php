<!DOCTYPE html>
<html>
<head>
    <title>View Supervisors</title>
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

    // Pagination variables
    $recordsPerPage = 3;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;

    // Retrieve total number of records
    $totalRecordsQuery = "SELECT COUNT(*) AS total FROM tbl_supervisor";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

    // Calculate total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Retrieve limited records for the current page, sorted by SSN in descending order
    $sql = "SELECT * FROM tbl_supervisor ORDER BY SSN DESC LIMIT $offset, $recordsPerPage";
    $result = $conn->query($sql);
    ?>

    <table>
        <tr>
            <th>SSN</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Postal Address</th>
            <th>Date of Birth</th>
            <th>Email</th>
            <th>Phone</th>
            
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['SSN']; ?></td>
                <td><?php echo $row['F_name']; ?></td>
                <td><?php echo $row['L_name']; ?></td>
                <td><?php echo $row['P_Address']; ?></td>
                <td><?php echo $row['DOB']; ?></td>
                <td><?php echo $row['Email']; ?></td>
                <td><?php echo $row['Phone']; ?></td>
                
                <td>
                    <form action="pharmcom_contract.php" method="POST">
                        <input type="hidden" name="SSN" value="<?php echo $row['SSN']; ?>">
                        <input type="submit" value="Contract">
                    </form>
                    <form action="pharmcom_view_supervisor_contract.php" method="POST">
                        <input type="hidden" name="SSN" value="<?php echo $row['SSN']; ?>">
                        <input type="submit" value="View Contract">
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

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
