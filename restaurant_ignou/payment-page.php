<?php
session_start();

// Include your database connection file
$con = mysqli_connect("localhost", "root", "", "restaurant");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
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
         <style>
        /* Add the table styles here */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            vertical-align: middle;
        }

        /* Add the form input fields styles here */
        form {
            max-width: 500px;
            margin: 0 auto;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
     
</head>
<!-- body -->

<body class="main-layout">
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
<!-- about -->
<div class="about">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <i><img src="images/title.png" alt="#"/></i>
                    <h2>Ordered Items</h2>
                </div>
                <?php


// Check if session variables are set
// Check if session variables are set
if (isset($_SESSION['orderDetails'])) {
    $orderDetails = $_SESSION['orderDetails'];

    // Initialize total amount
    $totalAmount = 0;

    // Display order details and dynamically calculate total amount
    echo '<h2 style="text-align: center;">Your Order Details</h2>';

    echo '<form action="process-payment.php" method="post" onsubmit="return showPaymentSuccessAlert()">';

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Sl No</th>"; // Add this line
    echo "<th>Item ID</th>";
    echo "<th>Item Name</th>";
    echo "<th>Price</th>";
    echo "<th>Restaurant Name</th>";
    echo "<th>Quantity</th>";
    echo "<th>Total Price</th>";

    echo "</tr>";

    foreach ($orderDetails as $index => $order) {
        echo "<tr>";
        echo "<td>" . ($index + 1) . "</td>"; // Add this line for "Sl No"
        echo "<td>" . $order['itemId'] . "</td>"; // Move this line for Item ID
        echo "<td>" . $order['itemName'] . "</td>";
        echo "<td>&#8377;" . $order['price'] . "</td>";
        echo "<td>" . $order['restaurantName'] . "</td>";
        echo "<td>" . $order['quantity'] . "</td>";

        // Calculate subtotal for the current item and add to total amount
        $subtotal = $order['quantity'] * $order['price'];
        echo "<td>&#8377;" . $subtotal . "</td>"; // Display subtotal

        // Add the subtotal to the total amount
        $totalAmount += $subtotal;

        // Hidden input fields for each item's details
        echo "<input type='hidden' name='itemId[]' value='" . $order['itemId'] . "'>";
        echo "<input type='hidden' name='itemName[]' value='" . $order['itemName'] . "'>";
        echo "<input type='hidden' name='itemPrice[]' value='" . $order['price'] . "'>";
        echo "<input type='hidden' name='itemQuantity[]' value='" . $order['quantity'] . "'>";
        echo "<input type='hidden' name='restaurantName[]' value='" . $order['restaurantName'] . "'>";
        echo "<input type='hidden' name='itemTotal[]' value='" . $subtotal . "'>";

        echo "</tr>";
    }

    echo "<tr>";
    echo "<td colspan='6'>Total Amount to be Paid:</td>";
    echo "<td>&#8377;" . $totalAmount . "</td>";

    echo "</tr>";

    echo "</table>";

    // Hidden input field for total amount
    echo "<input type='hidden' name='totalAmount' value='" . $totalAmount . "'>";

  // Form for entering card details
echo "<h2>Enter Card Details</h2>";
echo "Card Number: <input type='text' name='cardNumber' id='cardNumber' placeholder='1234 5678 9012 3456'  required><br>";
echo "Expiry (MM/YY): <input type='text' name='expiry' id='expiry' placeholder='MM/YY' pattern='(0[1-9]|1[0-2])\/?([0-9]{2})' required><br>";
echo "CVV: <input type='password' name='cvv' id='cvv' placeholder='123' maxlength='3' pattern='[0-9]{3}' required><br>";
echo "<input type='submit' name='payNow' value='Pay Now'>";
echo "</form>";

    // Clear the session variables
    unset($_SESSION['orderDetails']);
    unset($_SESSION['totalAmount']);
} else {
    // Redirect to the cart page if session variables are not set
    header("Location: cart.php");
    exit();
}

mysqli_close($con);
?>
            </div>
        </div>
    </div>
</div>

<!-- end about -->


    <!-- footer -->
    <fooetr>
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
    <script>
    function showPaymentSuccessAlert() {
        alert('Payment successful!');
        return true; // Allow the form submission to proceed
    }
</script>

</body>

</html>


<!--  -->