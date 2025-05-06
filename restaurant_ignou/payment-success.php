<?php
session_start();

// Include your database connection file
$con = mysqli_connect("localhost", "root", "", "restaurant");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve order details from the session
$orderDetails = isset($_SESSION['orderDetails']) ? $_SESSION['orderDetails'] : null;

// Clear the session variable
unset($_SESSION['orderDetails']);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
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

            <div class="yellow_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title">
                                <h2>Payment Success</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- about -->
          <div class="about">
    <div class="container">
        <div class="row">
            <div style="text-align: center; padding: 30px; background-color: #4CAF50; color: #fff;">
                <h2>Thank you! <?php echo $orderDetails['customerName']; ?>, for your payment!</h2>
                
            </div>
            <div style="margin: 20px; padding: 20px; border: 1px solid #ccc;">
                <h3>Order Details</h3>
                <table border="1" style="width: 100%;">
                    <tr>
                        <th>Item Name</th>
                        <th>Restaurant Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php foreach ($orderDetails['items'] as $item) : ?>
                        <tr>
                            <td><?php echo $item['itemName']; ?></td>
                            <td><?php echo $item['restaurantName']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['subtotal']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" style="text-align: right;">Total Amount:</td>
                        <td><?php echo $orderDetails['totalAmount']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
 <div style="text-align: center; margin: 20px;">
        <a href='recipe.php' style='margin-right: 20px; padding: 10px 20px; background-color: #4CAF50; color: #fff; text-decoration: none;'>Continue Shopping</a>
        <a href='cart.php' style='margin-right: 20px; padding: 10px 20px; background-color: #4CAF50; color: #fff; text-decoration: none;'>Go to Cart Page</a>
        <a href='index.php' style='padding: 10px 20px; background-color: #4CAF50; color: #fff; text-decoration: none;'>Go Back to Home</a>
    </div>

            <!-- end about -->

            <!-- footer -->
            <footer>
                <div class="footer">
                    <div class="container-fluid">
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
            </footer>
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
