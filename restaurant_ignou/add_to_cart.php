<?php
if (isset($_POST['add_to_cart'])) {
    // Retrieve item details from the form
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_image = $_POST['item_image'];

    // Perform database operations to insert the item into the cart table
    // Replace with your database connection code and SQL query
    $con = mysqli_connect("localhost", "root", "", "restaurant");

    // Check the connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the INSERT query
    $insertQuery = "INSERT INTO cart (item_id, name, price, image) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insertQuery);
   // Bind all four variables (item_id, item_name, item_price, item_image)
mysqli_stmt_bind_param($stmt, "isss", $item_id, $item_name, $item_price, $item_image);


    if (mysqli_stmt_execute($stmt)) {
        // Item added to cart successfully
        header("Location: cart.php"); // Redirect to the cart page
        exit();
    } else {
        echo "Error adding item to cart: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}
?>
