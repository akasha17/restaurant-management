<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_amount = $_POST['total_amount'];
    $user_id = $_POST['user_id'];
    $restaurant_id = $_POST['restaurant_id'];
    $restaurant_name = $_POST['restaurant_name'];
    $order_status = 'confirmed';
    $payment_status = 'pending';
    $order_date = date('Y-m-d');
    date_default_timezone_set('Asia/Kolkata'); // Set the timezone to Indian Standard Time
    $order_time = date('H:i:s'); // Get the current time

    $insert_query = "INSERT INTO orders (item_id, quantity, subtotal, total, order_date, order_time, customer_id, restaurant_id, rest_name, orderstatus, payment_status)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $insert_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'iiiissiisss', $item_id, $quantity, $price, $total_amount, $order_date, $order_time, $user_id, $restaurant_id, $restaurant_name, $order_status, $payment_status);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: payment.php');
            exit();
        } else {
            echo "Error executing statement: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
