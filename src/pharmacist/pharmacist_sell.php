<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "example";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prescriptionID = $_POST["prescriptionID"];
    $drugID = $_POST["drugID"];
    $drugName = $_POST["drugName"];
    $quantity = $_POST["quantity"];
    $patientSSN = $_POST["patientSSN"];
    $doctorSSN = $_POST["doctorSSN"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Check if the price is set
    if (isset($_POST["price"])) {
        $price = $_POST["price"];
    } else {
        $price = 0;
    }

    // Calculate the total price
    $totalPrice = $price * $quantity;

    // Confirm the sale with the calculated total price
    if (isset($_POST["confirm"]) && $_POST["confirm"] === "true") {
        // Move the prescription to tbl_prescription_sold
        $moveQuery = "INSERT INTO tbl_prescription_sold (prescription_ID, D_ID, D_Name, D_Qty, patient_SSN, doctor_SSN, start_date, end_date, total_price) SELECT prescription_ID, D_ID, D_Name, D_Qty, patient_SSN, doctor_SSN, start_date, end_date, ? FROM tbl_prescription WHERE prescription_ID = ?";
        $moveStmt = mysqli_prepare($conn, $moveQuery);
        mysqli_stmt_bind_param($moveStmt, "di", $totalPrice, $prescriptionID);

        // Reduce the D_Qty in tbl_drugs
        $updateQuery = "UPDATE tbl_drugs SET D_Qty = D_Qty - ? WHERE D_ID = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "ii", $quantity, $drugID);

        // Execute the queries within a transaction
        mysqli_begin_transaction($conn);

        try {
            // Move prescription to tbl_prescription_sold
            mysqli_stmt_execute($moveStmt);

            // Reduce D_Qty in tbl_drugs
            mysqli_stmt_execute($updateStmt);

            // Commit the transaction
            mysqli_commit($conn);

            // Delete the moved prescription from tbl_prescription
            $deleteQuery = "DELETE FROM tbl_prescription WHERE prescription_ID = ?";
            $deleteStmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStmt, "i", $prescriptionID);
            mysqli_stmt_execute($deleteStmt);
            echo "Prescription sold successfully.";
            echo "<br><br> Total price: " . $totalPrice;
            echo '<br><br><button onclick="goBack()">Back</button>';
            
        } catch (Exception $e) {
            // Rollback the transaction on error
            mysqli_rollback($conn);
            echo "Error: " . $e->getMessage();
            echo '<br><button onclick="goBack()">Back</button>';
        }

        mysqli_stmt_close($moveStmt);
        mysqli_stmt_close($updateStmt);
        mysqli_stmt_close($deleteStmt);
    } else {
        // Ask the user to confirm the sale
        echo "Please confirm the sale with the following details:";
        echo "<br>Prescription ID: " . $prescriptionID;
        echo "<br>Drug Name: " . $drugName;
        echo "<br>Quantity: " . $quantity;
        echo "<br>Total Price: " . $totalPrice;
        echo '<br><br><form action="pharmacist_sell.php" method="POST">';
        echo '<input type="hidden" name="prescriptionID" value="' . $prescriptionID . '">';
        echo '<input type="hidden" name="drugID" value="' . $drugID . '">';
        echo '<input type="hidden" name="drugName" value="' . $drugName . '">';
        echo '<input type="hidden" name="quantity" value="' . $quantity . '">';
        echo '<input type="hidden" name="patientSSN" value="' . $patientSSN . '">';
        echo '<input type="hidden" name="doctorSSN" value="' . $doctorSSN . '">';
        echo '<input type="hidden" name="startDate" value="' . $startDate . '">';
        echo '<input type="hidden" name="endDate" value="' . $endDate . '">';
        echo 'Price of each: <input type="number" name="price" required><br>';
        echo '<input type="hidden" name="confirm" value="true">';
        echo '<input type="submit" value="Confirm Sale">';
        echo '</form>';
        echo '<br><button onclick="goBack()">Cancel</button>';
    }
}

mysqli_close($conn);
?>

<script>
    function goBack() {
        window.location.href = "pharmacist_view_prescription.php";
    }
</script>
