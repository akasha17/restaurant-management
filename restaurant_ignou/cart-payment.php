<?php
session_start();
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve order details from sessions
if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    // Fetch order details from the database
    $orderQuery = "SELECT * FROM orders WHERE order_id = '$orderId'";
    $orderResult = mysqli_query($con, $orderQuery);

    if ($orderResult) {
        $orderDetails = mysqli_fetch_assoc($orderResult);

        // Now you can access the order details
        $itemName = $orderDetails['item_name'];
        $quantity = $orderDetails['quantity'];
        $price = $orderDetails['subtotal'];
        $totalAmount = $orderDetails['subtotal'];
        $customerName = $orderDetails['customer_id'];

        // Display the order details
        echo "<script>alert('Order Confirmed!');</script>"; // Alert for order confirmation
    } else {
        echo "Error fetching order details: " . mysqli_error($con);
    }
} else {
    echo "Order ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <form id="payment-form" method="POST">
            <div class="section">
                <h2>Billing Information</h2>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $customerName; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $userRow['email']; ?>" required>
                </div>
            </div>

            <div class="section">
                <h2>Order Summary</h2>
                <!-- Display user's order details here -->
                <div class="order-details">
                    <p>Product: <?php echo $itemName; ?></p>
                    <p>Quantity: <?php echo $quantity; ?></p>
                    <p>Total: <?php echo $totalAmount; ?></p>
                </div>
            </div>

            <div class="section">
                <h2>Payment Information</h2>
                <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" name="card-number" required>
                </div>
                <div class="form-group">
                    <label for="expiry-date">Expiry Date</label>
                    <input type="text" id="expiry-date" name="expiry-date" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="password" id="cvv" name="cvv" required>
                </div>
            </div>

            <button type="submit" name="submit">Submit Payment</button>
        </form>
    </div>
</body>

</html>
