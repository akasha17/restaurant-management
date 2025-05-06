<?php
session_start();

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if item_id is set in the POST data
if (isset($_POST['item_id'])) {
    $itemId = mysqli_real_escape_string($con, $_POST['item_id']);

    // Delete the item from the database
    $deleteQuery = "DELETE FROM cart WHERE item_id = $itemId";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        echo "Item deleted successfully from the database.";
    } else {
        echo "Error deleting item from the database: " . mysqli_error($con);
    }
} else {
    echo "Item ID not provided in the request.";
}

// Close the database connection
mysqli_close($con);
?>
