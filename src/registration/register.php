<?php
// Database connection details
/*$host = "localhost";
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
$ID = $_POST['id'];
$F_name = $_POST['fname'];
$L_name = $_POST['lname'];
$P_Address = $_POST['address'];
$Age = $_POST['age'];
$Email = $_POST['email'];
$Phone =  $_POST['phone'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

// Perform basic form validation
/*if (empty($ID) || empty($F_name)  || empty($L_name)|| empty($P_Address) || empty($Age) || empty($password) || empty($confirmPassword)) {
    echo "All fields are required.";
    exit;
}

if ($password !== $confirmPassword) {
    echo "Passwords do not match.";
    exit;
}

// Prepare and execute the SQL statement to insert data into the database
$stmt = $conn->prepare("INSERT INTO tbl_patient (id, fname, lname, address, age, password) VALUES (?,?, ?, ?, ?, ?)");
$stmt->bind_param("isssis", $ID, $F_name, $L_name, $P_Address, $Age, $password);
$stmt->execute();*/

/*if (empty($SSN) || empty($F_name) || empty($L_name) || empty($P_Address) || empty($Age) || empty($Email) || empty($Phone) || empty($password)) {
    echo "All fields are required.";
    exit;
}

// Prepare and execute the SQL statement to insert data into the database
$stmt = $conn->prepare("INSERT INTO tbl_patient (id, F_name, L_name, P_Address, Age, Email, Phone, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssisss", $ID, $F_name, $L_name, $P_Address, $Age, $Email, $Phone, $password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Registration successful!";
} else {
    echo "Error occurred. Please try again.";
}

if ($stmt->error) {
    echo "Error: " . $stmt->error;
    exit;
}


// Close the prepared statement and database connection
$stmt->close();
$conn->close();*/

/*
// Database connection details
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
$SSN = $_POST['SSN'];
$F_name = $_POST['fname'];
$L_name = $_POST['lname'];
$P_Address = $_POST['address'];
$Age = $_POST['age'];
$Email = $_POST['email'];
$Phone = $_POST['phone'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

// Perform basic form validation
if (empty($SSN) || empty($F_name) || empty($L_name) || empty($P_Address) || empty($Age) || empty($Email) || empty($Phone) || empty($password)) {
    echo "All fields are required.";
    exit;
}

if ($password !== $confirmPassword) {
    echo "Passwords do not match.";
    exit;
}

// Prepare and execute the SQL statement to insert data into the database
$stmt = $conn->prepare("INSERT INTO tbl_patient (SSN, F_name, L_name, P_Address, Age, Email, Phone, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssisss", $SSN, $F_name, $L_name, $P_Address, $Age, $Email, $Phone, $password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Registration successful!";
} else {
    echo "Error occurred. Please try again.";
}

if ($stmt->error) {
    echo "Error: " . $stmt->error;
    exit;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>

*/


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

// Retrieve user type from the query parameter
$userType = $_POST['userType'];

// Perform basic form validation
if (empty($userType)) {
    echo "Invalid user type.";
    exit;
}

// Retrieve form data
$SSN = $_POST['SSN'];
$F_name = $_POST['F_name'];
$L_name = $_POST['L_name'];
$P_Address = $_POST['Address'];
$Age = $_POST['Age'];
$Email = $_POST['Email'];
$Phone = $_POST['Phone'];
$Password = $_POST['Password'];
$confirmPassword = $_POST['Confirm_password'];

// Perform additional validation and database interactions here

// Determine the appropriate table based on the user type
$tableName = "";
switch ($userType) {
    case "admin":
        $tableName = "tbl_users";
        break;
    case "patient":
        $tableName = "tbl_patient";
        break;
    case "doctor":
        $tableName = "tbl_doctor";
        break;
    case "supervisor":
        $tableName = "tbl_supervisor";
        break;
    case "pharmacist":
        $tableName = "tbl_pharmacist";
        break;
    case "pharmaceutical_company":
        $tableName = "tbl_pharmcom";
        break;
    default:
        echo "Invalid user type.";
        exit;
}

// Prepare and execute the SQL statement to insert data into the appropriate table
$stmt = $conn->prepare("INSERT INTO $tableName (SSN, F_name, L_name, P_Address, Age, Email, Phone, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssisis", $SSN, $F_name, $L_name, $P_Address, $Age, $Email, $Phone, $Password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Registration successful as $userType!";
} else {
    echo "Error occurred. Please try again.";
}

if ($stmt->error) {
    echo "Error: " . $stmt->error;
    exit;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>

