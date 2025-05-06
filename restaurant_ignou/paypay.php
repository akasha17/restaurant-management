<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check if the required parameters are set
if (isset($_GET['item_id'], $_GET['restaurant_id'], $_GET['user_id'], $_GET['quantity'], $_GET['total_amount'], $_GET['status'], $_GET['item_price'], $_GET['restaurant_name'])) {
    $item_id = $_GET['item_id'];
    $restaurant_name = $_GET['restaurant_name'];
    $user_id = $_GET['user_id'];
    $quantity = $_GET['quantity'];
    $total_amount = $_GET['total_amount'];
    $status = $_GET['status'];
    $item_price = $_GET['item_price'];  // Added item price parameter

    // Get restaurant ID from the database using restaurant name
    $restaurant_query = "SELECT id FROM restaurants WHERE name = ?";
    $stmt = mysqli_prepare($con, $restaurant_query);
    mysqli_stmt_bind_param($stmt, "s", $restaurant_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $restaurant_id = $row['id'];

        date_default_timezone_set('Asia/Kolkata');

        // Get current date and time
        $order_date = date("Y-m-d");  // Get the current date in "YYYY-MM-DD" format
        $order_time = date("H:i:s");  // Get the current time in "HH:MM:SS" format
        $payment_status = "pending";  // Set payment status as pending

        // Insert order details into the database
        $insert_query = "INSERT INTO orders (item_id, restaurant_id, rest_name, customer_id, quantity, total, order_date, order_time, orderstatus, subtotal, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);

        mysqli_stmt_bind_param($stmt, "iisiiisssds", $item_id, $restaurant_id, $restaurant_name, $user_id, $quantity, $total_amount, $order_date, $order_time, $status, $item_price, $payment_status);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $response = array('success' => true, 'order_id' => mysqli_insert_id($con));
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Error inserting order details into the database.');
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'Error fetching restaurant ID from the database.');
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Missing parameters.');
    echo json_encode($response);
}

mysqli_close($con);
?>
