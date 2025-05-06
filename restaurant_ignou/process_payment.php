<?php
session_start();

// Include your database connection file
$con = mysqli_connect("localhost", "root", "", "restaurant");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the AJAX request is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data sent via POST
    $itemId = mysqli_real_escape_string($con, $_POST['itemId']);
    $itemName = mysqli_real_escape_string($con, $_POST['itemName']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $restaurantName = mysqli_real_escape_string($con, $_POST['restaurantName']);
    $customerId = $_SESSION['user_id']; // Assuming user_id is stored in the session
    
    // Calculate total amount
    $totalAmount = $price * $quantity;

    // Prepare and execute SQL query to insert data into orders table
    $insertQuery = "INSERT INTO orders (item_id, subtotal, quantity, total, order_date, order_time, customer_id, rest_name, orderstatus, payment_status) 
                    VALUES ('$itemId', '$price', '$quantity', '$totalAmount', CURDATE(), CURTIME(), '$customerId', '$restaurantName', 'Confirmed', 'Pending')";
    $result = mysqli_query($con, $insertQuery);

    if ($result) {
        // Order placed successfully
        echo json_encode(array("success" => true));
    } else {
        // Error occurred while inserting data
        echo json_encode(array("success" => false, "error" => "Error inserting data into orders table: " . mysqli_error($con)));
    }
} else {
    // If the request is not sent via POST method
    echo json_encode(array("success" => false, "error" => "Invalid request method"));
}

mysqli_close($con);
?>
