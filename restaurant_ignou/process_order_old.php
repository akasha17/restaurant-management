<?php
// Include your database connection file
session_start();
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set the timezone to India
date_default_timezone_set('Asia/Kolkata');

// Initialize variables
$orderDetails = array();
$totalAmount = 0;

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the logged-in user ID
    $customer_id = $_POST['customer_id'];

    // Get the selected items
    $selectedItems = $_POST['selectedItems'];
    $restaurantIds = $_POST['restaurant_id'];

    // Get the current date and time in India
    $orderDate = date('Y-m-d'); // Format: YYYY-MM-DD
    $orderTime = date('H:i:s'); // Format: HH:MM:SS

    // Iterate through selected items to calculate the total amount
    foreach ($selectedItems as $key => $selectedItem) {
        // Extract item details from the selected item value
        list($itemId, $restaurantId, $count) = explode('-', $selectedItem);

        // Get quantity and subtotal from hidden fields
        $quantity = $_POST['quantity'][$itemId][$restaurantId][$count];
        $subtotal = $_POST['subtotal'][$itemId][$restaurantId][$count];
        $totalAmount += $subtotal;  // Accumulate total amount
    }

    // Iterate through selected items again to insert order details
    foreach ($selectedItems as $key => $selectedItem) {
        // Extract item details from the selected item value
        list($itemId, $restaurantId, $count) = explode('-', $selectedItem);

        // Get quantity and subtotal from hidden fields
        $quantity = $_POST['quantity'][$itemId][$restaurantId][$count];
        $subtotal = $_POST['subtotal'][$itemId][$restaurantId][$count];

        // Get restaurant name and ID from the arrays
        $restaurantName = $_POST['restaurant_name'][$count];
        $restaurantId = $restaurantIds[$count]; // Get the corresponding restaurant ID

        // Fetch item details from the database based on item ID
        $getItemDetailsQuery = "SELECT name, price FROM menu WHERE item_id = '$itemId'";
        $itemDetailsResult = mysqli_query($con, $getItemDetailsQuery);
        $itemDetails = mysqli_fetch_assoc($itemDetailsResult);

        // Create an array with order details
        $orderDetails[] = array(
            'itemId' => $itemId,  // Add the item ID
            'itemName' => $itemDetails['name'],
            'price' => $itemDetails['price'],
            'quantity' => $quantity,
            'restaurantId' => $restaurantId,  // Add the restaurant ID
            'restaurantName' => $restaurantName,
            // Add more details as needed
        );

        // Insert order details into the orders table
        $insertOrderQuery = "INSERT INTO orders (customer_id, item_id, restaurant_id, rest_name, quantity, subtotal, total, orderstatus, payment_status, order_date, order_time)
                             VALUES ('$customer_id', '$itemId', '$restaurantId', '$restaurantName', '$quantity', '$subtotal', '$totalAmount', 'Confirmed', 'Pending', '$orderDate', '$orderTime')";
        mysqli_query($con, $insertOrderQuery);
    }

    // Set session variables before redirect
    $_SESSION['orderDetails'] = $orderDetails;
    $_SESSION['totalAmount'] = $totalAmount;

    // Redirect to the payment page
    header('Location: payment-page.php');
    exit();
}

// Close the database connection
mysqli_close($con);
?>
