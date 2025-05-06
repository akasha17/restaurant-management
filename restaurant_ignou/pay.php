<?php
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


function get_item_name_from_database($con, $item_id) {
    // Implement the database query to retrieve the item name based on $item_id
    $item_id = mysqli_real_escape_string($con, $item_id); // For security
    $query = "SELECT name FROM cart WHERE item_id = $item_id";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['name'];
    }
    
    return 'Item Not Found'; // Handle cases where the item is not found
}

// Define a similar function for retrieving item prices
function get_price_from_database($con, $item_id) {
    // Implement the database query to retrieve the item price based on $item_id
    $item_id = mysqli_real_escape_string($con, $item_id); // For security
    $query = "SELECT price FROM cart WHERE item_id = $item_id";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['price'];
    }
    
    return 0; // Handle cases where the price is not found
}

if (isset($_POST['order'])) {
    $orderItems = $_POST['order'];
    $totalAmount = 0;

    echo '<h2>Ordered Items</h2>';
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Item Name</th>';
    echo '<th>Price</th>';
    echo '<th>Quantity</th>';
    echo '<th>Subtotal</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($orderItems as $item_id) {
        $quantity = $_POST['quantity'][$item_id]; // Get the quantity for the item

        // Retrieve the item name and price based on item_id (implement these functions)
        $item_name = get_item_name_from_database($con, $item_id);
        $item_price = get_price_from_database($con, $item_id);

        // Check if $item_price is a valid number
        if (is_numeric($item_price)) {
            $item_price = floatval($item_price);
        } else {
            echo "Invalid price for item with ID $item_id";
            continue;
        }

        // Check if $quantity is a valid number
        $quantity = filter_var($quantity, FILTER_VALIDATE_INT);

        if ($quantity === false) {
            echo "Invalid quantity for item with ID $item_id";
            continue;
        }

        $item_subtotal = $item_price * $quantity;
        $totalAmount += $item_subtotal;

        // Output a row for each item
        echo '<tr>';
        echo '<td>' . $item_name . '</td>';
        echo '<td>' . $item_price . '</td>';
        echo '<td>' . $quantity . '</td>';
        echo '<td>' . $item_subtotal . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    echo '<h2>Total Amount: ' . $totalAmount . '</h2>';

    // Create a form for card details
    echo '<h2>Payment Details</h2>';
    echo '<form method="post" action="process_payment.php">';
    echo 'Card Number: <input type="text" name="cardNumber"><br>';
    echo 'Expiry: <input type="text" name="expiry"><br>';
    echo 'CVV: <input type="password" name="cvv"><br>';
    echo '<input type="hidden" name="totalAmount" value="' . $totalAmount . '">';
    echo '<button type="submit" name="submit" class="btn btn-primary">Confirm Payment</button>';
    echo '</form>';
} else {
    echo "Please select items and quantities.";
}
