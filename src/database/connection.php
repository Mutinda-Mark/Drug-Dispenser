<?php
$servername = "20.164.22.232";
$username = "root";
$password = "";
$database = "CAT1";



$conn = mysqli_connect($servername,$username,$password,$database);
 
if(!$conn){
    die("Connection failed: " .mysqli_connect_error());
}
echo "Connected Successfully";

?>
