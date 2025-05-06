<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_POST['table_id'])) {
    $tableId = $_POST['table_id'];
    $user_name = $_SESSION['user_name'];

    // Perform the item removal from the cart based on the table ID
    $remove_query = "DELETE FROM menu_cart WHERE user_name = '$user_name' AND id = '$tableId'";
    $remove_result = mysqli_query($con, $remove_query);

    if ($remove_result) {
        echo 'Item removed successfully';
    } else {
        echo 'Error removing item: ' . mysqli_error($con);
    }
} else {
    echo 'Invalid request';
}

mysqli_close($con);
?>
