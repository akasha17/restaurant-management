<!-- order.php -->
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your head content here -->
    <!-- Example: Title, meta tags, stylesheets, etc. -->
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Add any other stylesheets or meta tags as needed -->
</head>

<body>
    <div class="container">
        <h2>Order Confirmation</h2>
        
        <h3>Customer Details</h3>
        <p><strong>Name:</strong> <?php echo $userRow['fname']; ?></p>
        <p><strong>Contact No.:</strong> <?php echo $userRow['phone']; ?></p>
        <p><strong>Address:</strong> <?php echo $userRow['address']; ?></p>
        <!-- Add more user details as needed -->

        <h3>Ordered Items</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalAmount = 0;

                while ($cartRow = mysqli_fetch_assoc($cartResult)) {
                    $itemName = $cartRow['name'];
                    $itemPrice = $cartRow['price'];
                    $quantity = isset($_POST['quantity'][$cartRow['item_id']]) ? intval($_POST['quantity'][$cartRow['item_id']]) : 1;

                    $itemTotal = $itemPrice * $quantity;
                    $totalAmount += $itemTotal;
                ?>
                    <tr>
                        <td><?php echo $itemName; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $itemTotal; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Total Amount: <?php echo $totalAmount; ?></h3>

        <p><strong>Ordering Date and Time:</strong> <span id="orderDateTime"></span></p>

        <!-- Additional form fields for address, phone, etc. -->
        <form method="post" action="order-confirm.php">
            <!-- Add form fields for address, phone, etc. -->
            <button type="submit" name="confirm_order" class="btn btn-primary">Confirm Order</button>
        </form>
    </div>

    <!-- Include your scripts here if needed -->
    <script>
    // Get current date and time in the user's local timezone
    var currentDateTime = new Date();
    
    // Format the date and time as desired
    var formattedDateTime = currentDateTime.getFullYear() + '-' + (currentDateTime.getMonth() + 1) + '-' + currentDateTime.getDate() + ' ' + currentDateTime.getHours() + ':' + currentDateTime.getMinutes() + ':' + currentDateTime.getSeconds();
    
    // Display the formatted date and time in the specified element
    document.getElementById('orderDateTime').textContent = formattedDateTime;
</script>

</body>

</html>
