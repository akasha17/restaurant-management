<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the POST request
    $item_id = $_POST['item_id'];
    $restaurant_name = $_POST['restaurant_name'];
    $user_name = $_POST['user_name'];

    // Check if the item is already in the user's cart
    $check_query = "SELECT * FROM menu_cart WHERE user_name = '$user_name' AND rest_name = '$restaurant_name' AND item_id = '$item_id'";
    $check_result = mysqli_query($con, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // Item already in the cart
        echo 'exists';
    } else {
        // Item not in the cart
        echo 'not_exists';
    }
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method.";
}
?> 
