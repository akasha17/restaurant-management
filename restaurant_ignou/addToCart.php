<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the POST request
    $item_id = $_POST['item_id'];
    $restaurant_name = $_POST['restaurant_name'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_image = $_POST['item_image'];
    $user_name = $_POST['user_name'];

    // Insert the item into the menu_cart table
    $insert_query = "INSERT INTO menu_cart (item_id, rest_name, item_name, item_price, item_image, user_name) 
                     VALUES ('$item_id', '$restaurant_name', '$item_name', '$item_price', '$item_image', '$user_name')";
    $insert_result = mysqli_query($con, $insert_query);

    if ($insert_result) {
        // Item added successfully
        echo 'success';
    } else {
        // Error adding item
        echo 'error';
    }
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method.";
}
?>
