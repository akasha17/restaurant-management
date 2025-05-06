<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check if the session variable exists and contains the order details
if (isset($_SESSION['order_details'])) {
    // Retrieve the order details from the session
    $order_details = $_SESSION['order_details'];

    // Assign item_id to a variable for easier access
    $itemId = $order_details['item_id'];
    $itemPrice = $order_details['price']; // Example, replace with your actual item price
    $restaurantName = $order_details['restaurant_name']; // Example, replace with your actual restaurant name
    $quantity = $order_details['quantity']; // Example, replace with your actual quantity
    $totalAmount = $order_details['total_amount']; // Example, replace with your actual total amount

    // Fetch the item name from the 'menu' table using the item_id
    $item_query = "SELECT name FROM menu WHERE item_id = '" . mysqli_real_escape_string($con, $itemId) . "'";
    $item_result = mysqli_query($con, $item_query);

    if ($item_result && mysqli_num_rows($item_result) > 0) {
        $item_row = mysqli_fetch_assoc($item_result);
        $itemName = $item_row['name']; // Store the item name
    } else {
        $itemName = "Item not found"; // Handle the case where the item is not found
    }

    // You can now use $itemName in your further processing
    echo "Item Name: $itemName"; // Debugging line to show the item name
} else {
    echo "No order details found in session."; // Handle the case where session variable is not set
}

// Close the database connection
mysqli_close($con);
?>


<!-- Rest of your HTML code -->







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
    <title>Online Restaurant Management System</title>
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
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout about_page">
    <!-- loader  -->
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
    
   
<div class="footer" style="margin-top:-30px;">
 <div class="container-fluid">
                <div class="row" style="margin-left:170px;">
                  <div class=" col-md-12">
                    <h2>Payment Page</h2>
                  </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                      
                        <form class="main_form" method="POST" action="pay_new.php">
                            <div class="row">
                                
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="cname">Customer Name:</label>
    <input class="form-control" placeholder="Name" type="text" name="cname" id="cname" value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') : ''; ?>">
</div>



<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="name">Item Name:</label>
    <input class="form-control" placeholder="Item Name" type="text" name="name" id="name" value="<?php echo $itemName; ?>">
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="price">Item Price:</label>
   <input class="form-control" placeholder="Item Price" type="text" name="price" id="price" value="<?php echo $itemPrice; ?>">
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="rname">Restaurant Name:</label>
    <input class="form-control" placeholder="Restaurant Name" type="text" name="rname" id="rname" value="<?php echo $restaurantName; ?>">
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="qnty">Quantity:</label>
    <input class="form-control" placeholder="Quantity" type="text" name="qnty" id="qnty" value="<?php echo $quantity; ?>">
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="amount">Total Amount:</label>
    <input class="form-control" placeholder="Total Amount" type="text" name="amount" id="amount" value="<?php echo $totalAmount; ?>">
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="num">Card Number:</label>
    <input class="form-control" placeholder="Card Number" type="text" name="num" id="num" pattern="[0-9]{16}" title="Please enter a valid 16-digit card number">
</div>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="expiry">Card Expiry:</label>
    <input class="form-control" placeholder="MM/YY" type="text" name="expiry" id="expiry" pattern="(0[1-9]|1[0-2])\/[0-9]{4}" title="Please enter a valid expiry date in MM/YY format">
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <label for="num">CVV:</label>
    <input class="form-control" placeholder="CVV" type="password" name="cvv" id="cvv" pattern="[0-9]{3,4}" title="Please enter a valid 3 or 4-digit CVV">
</div>






                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <button type="submit" name="submit" class="send">Pay Now</button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    
                </div>
                
            </div>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
     <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    
     <script src="js/jquery-3.0.0.min.js"></script>
   <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

</body>

</html>