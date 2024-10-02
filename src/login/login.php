<?php
session_start(); // Start the session

$host = "localhost";
$username = "root";
$password = "";
$dbname = "CAT1";

// Create a new connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$userType = $_POST['userType'];
$SSN = $_POST['SSN'];
$Password = $_POST['password'];

// Perform basic form validation
if (empty($userType) || empty($SSN) || empty($Password)) {
    echo "All fields are required.";
    exit;
}

// Determine the appropriate table based on the selected user type
$tableName = "";
$redirectPage = ""; // Variable to store the user-specific page to redirect to

switch ($userType) {
    case "patient":
        $tableName = "tbl_patient";
        $redirectPage = "/src/users/patient.php";
        break;
    case "doctor":
        $tableName = "tbl_doctor";
        $redirectPage = "/src/users/doctor.php";
        break;
    case "supervisor":
        $tableName = "tbl_supervisor";
        $redirectPage = "/src/users/supervisor.php";
        break;
    case "pharmacist":
        $tableName = "tbl_pharmacist";
        $redirectPage = "/src/users/pharmacist.php";
        break;
    case "pharmaceutical_company":
        $tableName = "tbl_pharmcom";
        $redirectPage = "/src/users/pharmaceutical_company.php";
        break;
    default:
        echo "Invalid user type.";
        exit;
}

// Prepare and execute the SQL statement to check user credentials
$query = "SELECT * FROM $tableName WHERE SSN = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $SSN, $Password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login successful
    // Set session variables
    $_SESSION['userType'] = $userType;
    $_SESSION['name'] = $SSN; // You can modify this to store the actual name of the user from the database if available
    
    // Redirect to the user-specific page
    header("Location: $redirectPage");
    exit;
} else {
    // Login failed
    echo "Invalid SSN or password for $userType.";
}


// Close the prepared statement and database connection

/*

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

// Retrieve form data
$userType = $_POST['userType'];
$SSN = $_POST['SSN'];
$Password = $_POST['password'];

// Perform basic form validation
if (empty($userType) || empty($SSN) || empty($Password)) {
    echo "All fields are required.";
    exit;
}

// Determine the appropriate table based on the selected user type
$tableName = "";
$redirectPage = ""; // Variable to store the user-specific page to redirect to

switch ($userType) {
    case "patient":
        $tableName = "tbl_patient";
        $redirectPage = "patient.php";
        break;
    case "doctor":
        $tableName = "tbl_doctor";
        $redirectPage = "doctor.php";
        break;
    case "supervisor":
        $tableName = "tbl_supervisor";
        $redirectPage = "supervisor.html";
        break;
    case "pharmacist":
        $tableName = "tbl_pharmacist";
        $redirectPage = "pharmacist.html";
        break;
    case "pharmaceutical_company":
        $tableName = "tbl_pharmcom";
        $redirectPage = "pharmaceutical_company.html";
        break;
    default:
        echo "Invalid user type.";
        exit;
}

// Prepare and execute the SQL statement to check user credentials
$query = "SELECT * FROM $tableName WHERE SSN = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $SSN, $Password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login successful
    // Redirect to the user-specific page
    $row = $result->fetch_assoc();
    $redirectPage = $userType.".php?SSN=" . $row['SSN'] . "&F_name=" . $row['F_name']. "&L_name=" . $row['L_name'];
    header("Location: $redirectPage");
    exit;
} else {
    // Login failed
    echo "Invalid SSN or password for $userType.";
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
*/
?>
