<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $customerName = mysqli_real_escape_string($con, $_POST['cname']);
    $itemName = mysqli_real_escape_string($con, $_POST['name']);
    $itemPrice = mysqli_real_escape_string($con, $_POST['price']);
    $restaurantName = mysqli_real_escape_string($con, $_POST['rname']);
    $quantity = mysqli_real_escape_string($con, $_POST['qnty']);
    $totalAmount = mysqli_real_escape_string($con, $_POST['amount']);
    
    // Fetch customer ID from the customers table
    $customer_query = "SELECT customerid FROM customer WHERE fname = '$customerName'";
    $customer_result = mysqli_query($con, $customer_query);
    $customer_id = null;

    if ($customer_result && mysqli_num_rows($customer_result) > 0) {
        $customer_row = mysqli_fetch_assoc($customer_result);
        $customer_id = $customer_row['customerid'];
    } else {
        die("Customer not found.");
    }

    // Fetch item ID from the menu table
    $item_query = "SELECT item_id FROM menu WHERE name = '$itemName'";
    $item_result = mysqli_query($con, $item_query);
    $item_id = null;

    if ($item_result && mysqli_num_rows($item_result) > 0) {
        $item_row = mysqli_fetch_assoc($item_result);
        $item_id = $item_row['item_id'];
    } else {
        die("Item not found.");
    }

    // Fetch restaurant ID from the restaurants table
    $restaurant_query = "SELECT id FROM restaurants WHERE name = '$restaurantName'";
    $restaurant_result = mysqli_query($con, $restaurant_query);
    $restaurant_id = null;

    if ($restaurant_result && mysqli_num_rows($restaurant_result) > 0) {
        $restaurant_row = mysqli_fetch_assoc($restaurant_result);
        $restaurant_id = $restaurant_row['id'];
    } else {
        die("Restaurant not found.");
    }

    // Insert payment details into the payment table
    $currentDate = date('Y-m-d'); // Get current date
    $insert_query = "INSERT INTO payment (item_id, item_name, qnty, tot_amount, customer_id, customer_name, restaurant_name, status, paid_date) 
                     VALUES ('$item_id', '$itemName', '$quantity', '$totalAmount', '$customer_id', '$customerName', '$restaurantName', 'Paid', '$currentDate')";
    
    if (mysqli_query($con, $insert_query)) {
    // Update the orders table to set payment status as Paid
    $update_order_query = "UPDATE orders SET payment_status = 'Paid'
                           WHERE item_id = '$item_id' AND customer_id = '$customer_id' AND order_date = '$currentDate' AND total = '$totalAmount'";
    if (mysqli_query($con, $update_order_query)) {
        // Show alert and redirect to thank you page with restaurant name and ID
        echo "<script>alert('Payment successful!'); window.location.href='thank_you.php?restaurant_name=" . urlencode($restaurantName) . "&restaurant_id=" . urlencode($restaurant_id) . "';</script>";
    } else {
        echo "ERROR: Could not update orders table. " . mysqli_error($con);
    }
} else {
    echo "ERROR: Could not execute $insert_query. " . mysqli_error($con);
}

}

// Close the database connection
mysqli_close($con);
?>
