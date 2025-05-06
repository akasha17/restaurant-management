<?php
session_start();

// Retrieve order details from sessions
$order_details = isset($_SESSION['order_details']) ? $_SESSION['order_details'] : [];

// Check if the order details are available
if (empty($order_details)) {
    // Redirect the user back to the order page or handle as needed
    header("Location: order-confirm.php");
    exit;
}

// Assuming $_SESSION['user_id'] contains the ID of the currently logged-in user
$user_id = $order_details['user_id'];

// Retrieve user details from your database based on the user ID
$con = mysqli_connect("localhost", "root", "", "restaurant");
$userQuery = "SELECT * FROM customer WHERE customerid = $user_id";
$userResult = mysqli_query($con, $userQuery);
$userRow = mysqli_fetch_assoc($userResult);

// Extract the first name from the full name
$fullName = $userRow['fname'] . ' ' . $userRow['lname'];
$firstName = explode(' ', $fullName)[0];

// Fetch additional order details from the database
$orderQuery = "SELECT * FROM orders WHERE customer_id = $user_id ORDER BY order_date DESC, order_time DESC LIMIT 1";
$orderResult = mysqli_query($con, $orderQuery);
$orderRow = mysqli_fetch_assoc($orderResult);

$productQuery = "SELECT name FROM menu WHERE item_id = " . $orderRow['item_id'];
$productResult = mysqli_query($con, $productQuery);
$productRow = mysqli_fetch_assoc($productResult);

// Check if the payment button is clicked
if (isset($_POST['submit'])) {
    // Assign values to variables
    $customerId = $user_id;
    $customerName = $firstName; // Use only the first name
    $itemId = $orderRow['item_id'];
    $itemName = $productRow['name'];
    $quantity = $orderRow['quantity'];
    $totalAmount = $orderRow['total']; // Use subtotal as total amount
    $restaurantName = $orderRow['rest_name'];
    $paidDate = date('Y-m-d'); // Get the current date
    $status = 'paid';

    // Insert payment details into the payment table
    $insertPaymentQuery = "INSERT INTO payment (customer_id, customer_name, item_id, item_name, qnty, tot_amount, restaurant_name, paid_date, status)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($con, $insertPaymentQuery);
    mysqli_stmt_bind_param($stmt, "isisiisss", $customerId, $customerName, $itemId, $itemName, $quantity, $totalAmount, $restaurantName, $paidDate, $status);
    
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Update payment status in the orders table
    $updateOrderQuery = "UPDATE orders SET payment_status = 'paid' WHERE customer_id = ? AND order_date = ? AND item_id = ?";
    $stmt = mysqli_prepare($con, $updateOrderQuery);
    mysqli_stmt_bind_param($stmt, "iss", $customerId, $paidDate, $itemId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // Redirect or display a success message
    echo "<script>
            alert('Payment successful!');
            window.location.href = 'success.php?restaurant_id=$restaurantId&restaurant_name=' + encodeURIComponent('$restaurantName');
          </script>";
    exit;
}

// Close the database connection
mysqli_close($con);
?>




<!DOCTYPE html>
<html lang="en">

<head>
     <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Online Restaurant Management System </title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">
    <style type="text/css">
        .container {
    text-align: center;
}

.payment-form {
    width: 70%;
    margin: 0 auto;
}

.section {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
}

.order-details {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

.payment-form h2 {
    font-size: 24px;
}

.payment-form .form-group {
    margin-bottom: 20px;
}

.submit-button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.submit-button:hover {
    background-color: #45a049;
}

/* Container styles */
.container {
    text-align: center;
}

/* Form section styles */
.section {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
}

.section-title {
    font-size: 24px;
    margin-bottom: 10px;
}

/* Form field styles */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}



/* Submit button styles */
.submit-button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.submit-button:hover {
    background-color: #45a049;
}


    </style>
  
</head>

<body class="main-layout Recipes_page">
    <!-- loader -->
   <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="" /></div>
    </div>

    <div class="wrapper">
    <!-- end loader -->

     <div class="sidebar">
            <!-- Sidebar  -->
            <nav id="sidebar">

                <div id="dismiss">
                    <i class="fa fa-arrow-left"></i>
                </div>
              
               
    <ul class="list-unstyled components -->">
        <li>
            <a href="index.php">
                Home
            </a>
        </li>
        <li>
            <a href="about.php">About</a>
        </li>
        <li>
            <a href="restaurants_view.php">Restaurants</a>
        </li>
        <li>
            <a href="recipe.php">Recipe</a>
        </li>
        <li>
            <a href="cart.php">Cart</a>
        </li>
        <li>
            <a href="blog.php">Blog</a>
        </li>
        <li>
            <a href="profile_with_paid.php">Profile</a>
        </li>
        <li>
            <a href="contact.php">Contact Us</a>
        </li>
 </ul>

            </nav>
        </div>

    <div id="content">
    <!-- header -->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                   
                </div>
                <div class="col-md-9">
                    <div class="full">
                        <div class="right_header_info">
                            <ul>
                                <li class="dinone">Contact Us : <img style="margin-right: 15px;margin-left: 15px;" src="images/phone_icon.png" alt="#"><a href="#">987-654-3210</a></li>
                                <li class="dinone"><img style="margin-right: 15px;" src="images/mail_icon.png" alt="#"><a href="#">restaurant@gmail.com</a></li>
                                <li class="dinone"><img style="margin-right: 15px;height: 21px;position: relative;top: -2px;" src="images/location_icon.png" alt="#"><a href="#">Kerala , India</a></li>
                                <?php
                                if (isset($_SESSION['user_id'])) { ?>
                                    <li class="dinone">
    <a href="profile.php">
        <i class="fa fa-user-circle" aria-hidden="true"></i> <!-- Font Awesome user icon -->
        Welcome, <?php echo $_SESSION['user_name']; ?>!
    </a>
</li>

                                    <li class="dinone"><a href="logout.php">Logout</a></li>
                                <?php } else { ?>
                                
                                <li class="button_user"><a class="button" href="sign in.php">Login</a><a class="button" href="sign up.php">Register</a></li>
                                  <?php } ?>
                                
                                <li>
                                    <button type="button" id="sidebarCollapse">
                                        <img src="images/menu_icon.png" alt="#">
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
            <!-- end header -->

           <div class="yellow_bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h2>Payment Page</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container" style="margin-top:100px;">
    <form id="payment-form" method="POST" class="payment-form">
    <div class="section">
        <h2 class="section-title">Billing Information</h2>
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?php echo $userRow['fname'] . ' ' . $userRow['lname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $userRow['email']; ?>" required>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Order Summary</h2>
        <!-- Display user's order details here -->
        <div class="order-details">
            <p><strong><b>Product:</strong> </b><?php echo $productRow['name']; ?></p>
            <!-- <p>Price: $50.00</p> -->
            <p><strong><b>Quantity:</strong></b> <?php echo $orderRow['quantity']; ?></p>
            <p><strong><b>Restaurant:</strong> </b><?php echo $orderRow['rest_name']; ?></p> <!-- Add this line to display restaurant name -->
            <p><strong><b>Total:</strong></b> <?php echo $orderRow['total']; ?></p>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Payment Information</h2>
        <div class="form-group">
            <label for="card-number">Card Number</label>
            <input type="text" id="card-number" name="card-number"  required>
        </div>
        <div class="form-group">
            <label for="expiry-date">Expiry Date</label>
            <input type="text" id="expiry-date" name="expiry-date"  placeholder="MM/YY" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="password" id="cvv" name="cvv"  required>
        </div>
    </div>

    <button type="submit" name="submit" class="submit-button">Submit Payment</button>
</form>

</div>

     <fooetr>
                <div class="footer">
                    <div class="container-fluid">
                        
                           
                        </div>
                        <div class="row">
                            
                            <div class="col-md-12">
                        <ul class="lik">
                            <li> <a href="index.php">Home</a></li>
                            <li> <a href="about.php">About</a></li>
                            <li> <a href="restaurants_view.php">Restaurants</a></li>
                            <li> <a href="recipe.php">Recipe</a></li>
                            <li> <a href="cart.php">Cart</a></li>
                            <li> <a href="profile_with_paid.php">Profile</a></li>
                            <li> <a href="blog.php">blog</a></li>
                            
                        </ul>
                    </div>
                            
                        </div>
                    </div>
                    
                </div>
            </fooetr>
            <!-- end footer -->
        </div>
    </div>
    <div class="overlay"></div>
    <!-- Javascript files-->

    <script src="owlcarousel/jquery.min.js"></script>
    <script src="owlcarousel/owl.carousel.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
</body>

</html>
