<?php
session_start();

// Assuming $_SESSION['user_id'] contains the ID of the currently logged-in user
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Retrieve user details from your database based on the user ID
// Note: You need to modify this query based on your database schema
$con = mysqli_connect("localhost", "root", "", "restaurant");
$userQuery = "SELECT * FROM customer WHERE customerid = $user_id";
$userResult = mysqli_query($con, $userQuery);
$userRow = mysqli_fetch_assoc($userResult);

// Fetch items from the cart table
$cartQuery = "SELECT * FROM cart WHERE user_id = $user_id";
$cartResult = mysqli_query($con, $cartQuery);

// Initialize total amount
$totalAmount = 0;

// Insert order details into the orders table
$insertOrderQuery = "INSERT INTO orders (customer_id, item_id, quantity, subtotal, order_date, order_time, orderstatus, assigned_staff_id) VALUES (?, ?, ?, ?, CURDATE(), CURTIME(), ?, ?)";
$stmtInsertOrder = mysqli_prepare($con, $insertOrderQuery);

function getAvailableStaff($con) {
    $position = 'server';

    // Select an available staff member
    $staffQuery = "SELECT staffid FROM staff WHERE staff_position = ? LIMIT 1";
    $stmtGetStaff = mysqli_prepare($con, $staffQuery);
    mysqli_stmt_bind_param($stmtGetStaff, "s", $position);
    mysqli_stmt_execute($stmtGetStaff);
    mysqli_stmt_bind_result($stmtGetStaff, $staffId);

    // Fetch the result
    mysqli_stmt_fetch($stmtGetStaff);

    // Close the statement
    mysqli_stmt_close($stmtGetStaff);

    return $staffId;
}

// Usage
$staffId = getAvailableStaff($con);

if ($staffId !== null) {
    echo "Available staff member found: Staff ID - $staffId";

    while ($cartRow = mysqli_fetch_assoc($cartResult)) {
        $item_id = $cartRow['item_id'];
        $itemName = $cartRow['name'];
        $itemPrice = $cartRow['price'];
        $quantity = isset($_POST['quantity'][$item_id]) ? intval($_POST['quantity'][$item_id]) : 1;

        // Check if the item is already in the order
        $checkOrderQuery = "SELECT COUNT(*) FROM orders WHERE customer_id = ? AND item_id = ?";
        $checkStmt = mysqli_prepare($con, $checkOrderQuery);
        mysqli_stmt_bind_param($checkStmt, "ii", $user_id, $item_id);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_bind_result($checkStmt, $itemCount);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);

        $itemTotal = $itemPrice * $quantity;
        $totalAmount += $itemTotal;

        $orderstatus = 'confirmed';

        // Bind parameters with the correct order inside the loop
        mysqli_stmt_bind_param($stmtInsertOrder, "iiidis", $user_id, $item_id, $quantity, $itemTotal, $orderstatus, $staffId);

        // Execute the statement inside the loop
        mysqli_stmt_execute($stmtInsertOrder);
    }
} else {
    echo "No available staff member found";
    // Handle this case, for example, redirecting the user back to the cart
    // header("Location: cart.php");
}

// Close the database connection
mysqli_close($con);

$_SESSION['order_details'] = [
    'user_id' => $user_id,
    'total_amount' => $totalAmount,
    // Add more details as needed
];

echo "<script>alert('Order Confirmed!!'); window.location.href = 'payment.php';</script>";
?>
