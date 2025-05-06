<?php
$con = mysqli_connect("localhost", "root", "", "restaurant");
 
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$UID=$_REQUEST['customerid'];
$query = "DELETE FROM customer WHERE customerid=$UID"; 
$result = mysqli_query($con,$query) or die ( mysqli_error());
header("Location: customer_display.php"); 
?>