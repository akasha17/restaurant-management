<?php
session_start();

// Include your database connection file
$con = mysqli_connect("localhost", "root", "", "restaurant");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['payNow'])) {
    // Retrieve form data
    $cardNumber = mysqli_real_escape_string($con, $_POST['cardNumber']);
    $cvv = mysqli_real_escape_string($con, $_POST['cvv']);
    $itemIds = $_POST['itemId'];
    $itemNames = $_POST['itemName'];
    $itemPrices = $_POST['itemPrice'];
    $itemQuantities = $_POST['itemQuantity'];
    $restaurantNames = $_POST['restaurantName'];
    $itemTotals = $_POST['itemTotal'];
    $totalAmount = $_POST['totalAmount'];
    $paidDate = date('Y-m-d'); // Current date

    // You may want to perform validation on $cardNumber and $cvv

    // Get customer information from the session or other source
    $customerId = $_SESSION['user_id'];
    $customerName = $_SESSION['user_name'];

    // Initialize total amount
    $totalAmountFromForm = 0;

    $paidDateTime = date('Y-m-d H:i:s'); // Current date and time

// Loop through each item
foreach ($itemIds as $key => $itemId) {
    $itemName = $itemNames[$key];
    $quantity = $itemQuantities[$key];
    $price = $itemPrices[$key];
    $restaurantName = $restaurantNames[$key];
    $subtotal = $itemTotals[$key];
    $totalAmountFromForm += $subtotal;

    // Insert payment details into the payments table
    $insertPaymentQuery = "INSERT INTO payment (customer_id, customer_name, item_id, item_name, qnty, tot_amount, restaurant_name, status, paid_date)
                       VALUES ('$customerId', '$customerName', '$itemId', '$itemName', '$quantity', '$subtotal', '$restaurantName', 'Paid', '$paidDateTime')";
    $result = mysqli_query($con, $insertPaymentQuery);


    $updateOrderQuery = "UPDATE orders SET payment_status = 'Paid' WHERE item_id = '$itemId' AND customer_id = '$customerId'";
    $resultUpdateOrder = mysqli_query($con, $updateOrderQuery);

    if (!$resultUpdateOrder) {
        // Update failed, handle the error
        echo "Error updating payment status for item ID: $itemId";
        exit(); // Exit the script if an error occurs during update
    }

    if (!$result) {
        // Insertion failed, display the error message
        echo "Error: " . mysqli_error($con);
        exit(); // exit the script if an error occurs during insertion
    }
}


    // Update total amount in the payments table
    $updateTotalAmountQuery = "UPDATE payment SET tot_amount = '$totalAmountFromForm' WHERE customer_id = '$customerId' AND paid_date = '$paidDate'";
    $resultUpdate = mysqli_query($con, $updateTotalAmountQuery);

    if (!$resultUpdate) {
        // Update failed, display the error message
        echo "Error updating total amount: " . mysqli_error($con);
        exit();
    }

    // Validate that the total amount matches
    if ($totalAmountFromForm != $totalAmount) {
        echo "Error: Total amount mismatch";
        exit();
    }

    // Store order details in the session
   // Store order details in the session
$orderItems = array();
foreach ($itemIds as $key => $itemId) {
    $orderItems[] = array(
        'itemName' => $itemNames[$key],
        'restaurantName' => $restaurantNames[$key],
        'quantity' => $itemQuantities[$key],
        'price' => $itemPrices[$key],
        'subtotal' => $itemTotals[$key]
    );
}

$_SESSION['orderDetails'] = array(
    'items' => $orderItems,
    'totalAmount' => $totalAmountFromForm,
    'customerName' => $customerName
);


    // Redirect to the payment success page
    header("Location: payment-success.php");
    exit();

} else {
    // Redirect to the cart page if the form is not submitted
    header("Location: cart.php");
    exit();
}

mysqli_close($con);
?>
