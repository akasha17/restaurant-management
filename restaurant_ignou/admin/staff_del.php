<?php
$con = mysqli_connect("localhost", "root", "", "restaurant");
 
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$UID=$_REQUEST['staffid'];
$query = "DELETE FROM staff WHERE staffid=$UID"; 
$result = mysqli_query($con,$query) or die ( mysqli_error());
header("Location: staff_display.php"); 
?>