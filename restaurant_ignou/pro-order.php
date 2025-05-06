<?php
session_start();

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set the timezone to India
date_default_timezone_set('Asia/Kolkata');

// Check if form is submitted
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug: Check if data is received
    var_dump($_POST);

    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_amount = $_POST['total_amount'];
    $order_date = $_POST['order_date'];
    $order_time = date('H:i:s'); // Fetch current time in "HH:MM:SS" format
    $customer_id = $_POST['customer_id'];
    $restaurant_name = $_POST['restaurant_name'];
    $order_status = $_POST['order_status'];
    $payment_status = $_POST['payment_status'];

    // Fetch restaurant ID based on restaurant name
    $restaurant_query = "SELECT id FROM restaurants WHERE name = '$restaurant_name' LIMIT 1";
    $restaurant_result = mysqli_query($con, $restaurant_query);
    if ($restaurant_result && mysqli_num_rows($restaurant_result) > 0) {
        $restaurant_row = mysqli_fetch_assoc($restaurant_result);
        $restaurant_id = $restaurant_row['id'];
    } else {
        echo "<script>alert('Restaurant not found!');</script>";
        echo "<script>window.location.href = 'item-order.php';</script>";
        exit;
    }

    // Insert order details into the orders table
    $insertOrderQuery = "INSERT INTO orders (customer_id, item_id, restaurant_id, rest_name, quantity, subtotal, total, orderstatus, payment_status, order_date, order_time)
                         VALUES ('$customer_id', '$item_id', '$restaurant_id', '$restaurant_name', '$quantity', '$price', '$total_amount', '$order_status', '$payment_status', '$order_date', '$order_time')";
     $_SESSION['order_details'] = array(
        'item_id' => $item_id,
        'quantity' => $quantity,
        'price' => $price,
        'total_amount' => $total_amount,
        'order_date' => $order_date,
        'order_time' => $order_time,
        'customer_id' => $customer_id,
        'restaurant_name' => $restaurant_name,
        'order_status' => $order_status,
        'payment_status' => $payment_status
    );

   
    
    if (mysqli_query($con, $insertOrderQuery)) {
        // Redirect to payment page
        header('Location: order-payment.php');
        exit();
    } else {
        echo "Error: " . $insertOrderQuery . "<br>" . mysqli_error($con);
    }
}


// Close the database connection
mysqli_close($con);
?>
