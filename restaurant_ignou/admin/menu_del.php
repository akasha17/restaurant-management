<?php
$con = mysqli_connect("localhost", "root", "", "restaurant");
 
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$UID=$_REQUEST['item_id'];
$query = "DELETE FROM menu WHERE item_id=$UID"; 
$result = mysqli_query($con,$query) or die ( mysqli_error());
header("Location: food_items_display.php"); 
?>