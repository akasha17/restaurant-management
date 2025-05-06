<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the order details from the session
    $order_details = $_SESSION['order_details'];

    // Assign variables from session data
    $itemId = $order_details['item_id'];
    $itemName = $_POST['name'];
    $restaurantName = $_POST['rname'];
    $customerName = $_POST['cname'];
    $quantity = $_POST['qnty'];
    $totalAmount = $_POST['amount'];
    $date = date("Y-m-d"); // Current date
    $status = "Paid"; // Payment status

    // Assume customer ID is stored in session
    $customerId = $_SESSION['customer_id'];

    // Fetch the restaurant ID from the restaurant table using the restaurant name
    $restaurant_query = "SELECT restaurant_id FROM restaurants WHERE name = '$restaurantName'";
    $restaurant_result = mysqli_query($con, $restaurant_query);
    
    if ($restaurant_result && mysqli_num_rows($restaurant_result) > 0) {
        $restaurant_row = mysqli_fetch_assoc($restaurant_result);
        $restaurantId = $restaurant_row['restaurant_id'];

        // Insert payment details into the 'payment' table
        $payment_query = "INSERT INTO payment (item_id, item_name, restaurant_name, customer_id, customer_name, qnty, tot_amount, status, paid_date)
                          VALUES ('$itemId', '$itemName', '$restaurantName', '$customerId', '$customerName', '$quantity', '$totalAmount', '$status', '$date')";

        if (mysqli_query($con, $payment_query)) {
            // Payment inserted successfully, now update the orders table
            $order_update_query = "UPDATE orders SET payment_status = 'Paid' 
                                   WHERE item_id = '$itemId' AND restaurant_id = '$restaurantId' AND customer_id = '$customerId' AND total = '$totalAmount' AND order_date = '$date'";
            
            if (mysqli_query($con, $order_update_query)) {
                // Payment successful, show alert and redirect to thank you page
                echo "<script>
                    alert('Payment successful! Order status updated.');
                    window.location.href = 'thankyou.php'; // Redirect to thank you page
                </script>";
            } else {
                echo "<script>alert('Payment inserted, but order status update failed.');</script>";
            }
        } else {
            echo "<script>alert('Payment failed. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Restaurant not found. Please check the restaurant name.');</script>";
    }
}

// Close the database connection
mysqli_close($con);
?>