<?php
$con = mysqli_connect("localhost", "root", "", "restaurant");
 
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$UID=$_REQUEST['id'];
$query = "DELETE FROM restaurants WHERE id=$UID"; 
$result = mysqli_query($con,$query) or die ( mysqli_error());
header("Location: view_restaurants.php"); 
?>