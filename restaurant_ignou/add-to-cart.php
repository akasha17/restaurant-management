<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "restaurant");

if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_POST['add_to_cart'])) {
    $item_name = mysqli_real_escape_string($con, $_POST['item_name']);
    $restaurant_name = mysqli_real_escape_string($con, $_POST['restaurant_name']);
    $user_name = mysqli_real_escape_string($con, $_SESSION['user_name']);

    // Fetch item details
    $item_query = "SELECT item_id, price, image FROM menu WHERE name = '$item_name' LIMIT 1";
    $item_result = mysqli_query($con, $item_query);

    if (!$item_result) {
        die("ERROR: Could not execute $item_query. " . mysqli_error($con));
    }

    if (mysqli_num_rows($item_result) > 0) {
        $item_row = mysqli_fetch_assoc($item_result);
        $item_id = $item_row['item_id'];
        $item_price = $item_row['price'];
        $item_image = $item_row['image'];
    } else {
        echo "<script>alert('Item not found!');</script>";
        echo "<script>window.location.href = 'recipe.php';</script>";
        exit;
    }

    // Fetch restaurant details
    $restaurant_query = "SELECT id FROM restaurants WHERE name = '$restaurant_name' LIMIT 1";
    $restaurant_result = mysqli_query($con, $restaurant_query);

    if (!$restaurant_result) {
        die("ERROR: Could not execute $restaurant_query. " . mysqli_error($con));
    }

    if (mysqli_num_rows($restaurant_result) > 0) {
        $restaurant_row = mysqli_fetch_assoc($restaurant_result);
        $restaurant_id = $restaurant_row['id'];
    } else {
        echo "<script>alert('Restaurant not found!');</script>";
        echo "<script>window.location.href = 'recipe.php';</script>";
        exit;
    }

    // Check if the item already exists in the cart for the logged-in user
    $check_query = "SELECT * FROM menu_cart WHERE item_id = '$item_id' AND user_name = '$user_name' AND rest_id = '$restaurant_id'";
    $check_result = mysqli_query($con, $check_query);

    if (!$check_result) {
        die("ERROR: Could not execute $check_query. " . mysqli_error($con));
    }

    if (mysqli_num_rows($check_result) > 0) {
        // Item already exists in the cart, show alert and redirect to cart page
        echo "<script>alert('Item is already in the cart!');</script>";
        echo "<script>window.location.href = 'cart.php';</script>";
        exit;
    } else {
        // Item doesn't exist in the cart, add it to the cart table
        $insert_query = "INSERT INTO menu_cart (item_id, rest_id, user_name, price, img, item_name, rest_name) VALUES ('$item_id', '$restaurant_id', '$user_name', '$item_price', '$item_image', '$item_name', '$restaurant_name')";
        $insert_result = mysqli_query($con, $insert_query);

        if (!$insert_result) {
            die("ERROR: Could not execute $insert_query. " . mysqli_error($con));
        } else {
            // Item added to cart successfully, redirect to cart page
            echo "<script>window.location.href = 'cart.php';</script>";
            exit;
        }
    }
}
?>
