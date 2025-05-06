<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Ensure the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Handle the case where the user is not logged in
    // You can redirect to login page or show an error message
    echo 'User not logged in. Please <a href="login.php">login</a> to place an order.';
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
    <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">
  

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .order-details-container {
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Align items to the start */
            margin-right: 20px; /* Adjust the margin as needed */
        }

        .order-details-text {
            margin-left: 20px; /* Add some space between the image and text */
        }

        .total-amount-container {
            margin-top: 20px;
        }

        .item-details {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
        }

        .item-details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .item-details label {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<!-- body -->

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
                                <h2>Order Details</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

<section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if (isset($_GET['item_id']) && isset($_GET['restaurant_name'])) {
                                $item_id = $_GET['item_id'];
                                $restaurant_name = $_GET['restaurant_name'];

                                // Query to get item details
                                $query = "SELECT * FROM menu WHERE item_id = $item_id";
                                $result = mysqli_query($con, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $file_path = $row['image'];

                                    // Query to get restaurant ID based on the restaurant name
                                    $restaurant_query = "SELECT id FROM restaurants WHERE name = '$restaurant_name'";
                                    $restaurant_result = mysqli_query($con, $restaurant_query);
                                    $restaurant_row = mysqli_fetch_assoc($restaurant_result);
                                    $restaurant_id = $restaurant_row['id'];

                                    echo '<div class="order-details-container">';
                                    echo '<img src="admin/' . $file_path . '" alt="#" style="height: 300px; width: auto;" />';
                                    echo '<div class="order-details-text">';
                                    echo '<h2 style="text-decoration: underline;">' . $row['name'] . '</h2><br>';
                                    echo '<p><b>Price:</b> ₹' . $row['price'] . '</p><br>';
                                    echo '<p><b>Restaurant:</b> ' . $restaurant_name . '</p><br>';
                                    echo '<label for="quantity"><b>Quantity:</b></label>';
                                    echo '<input type="number" id="quantity" name="quantity" value="1" min="1" oninput="calculateTotalAmount()">
<br><br>';
                                    echo '<p id="totalAmountDisplay"><b>Total Amount:</b> ₹' . $row['price'] . '</p><br>';

                                    echo '<form id="orderForm" method="post" action="process_order.php">';
                                    echo '<input type="hidden" name="item_id" value="' . $item_id . '">';
                                    echo '<input type="hidden" name="item_name" value="' . $row['name'] . '">';
                                    echo '<input type="hidden" name="restaurant_id" value="' . $restaurant_id . '">';
                                    echo '<input type="hidden" name="restaurant_name" value="' . $restaurant_name . '">';
                                    echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
                                    echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
                                    echo '<input type="hidden" id="quantityHidden" name="quantity" value="1">';
                                    echo '<input type="hidden" id="totalAmountHidden" name="total_amount" value="' . $row['price'] . '">';
                                    echo '<button id="makePaymentBtn" type="button" style="background-color: green; width:150px;height:90px;" onclick="submitOrderForm()">Make Payment</button>';
                                    echo '</form>';

                                    echo '</div>';
                                    echo '</div>';
                                } else {
                                    echo '<p>No details found for the selected item.</p>';
                                }
                            } else {
                                echo '<p>Item ID and Restaurant Name are required.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>


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
 
  
     <script>
    function calculateTotalAmount() {
    var quantity = document.getElementById('quantity').value;
    var itemPrice = <?php echo $row['price']; ?>;
    var totalAmount = quantity * itemPrice;

    document.getElementById('totalAmountDisplay').innerText = 'Total Amount: ₹' + totalAmount.toFixed(2);
    document.getElementById('quantityHidden').value = quantity; // Update hidden quantity input
    document.getElementById('totalAmountHidden').value = totalAmount; // Update hidden total amount input
}


    function submitOrderForm() {
            document.getElementById('orderForm').submit();
        }
</script>


     <script>
$(document).ready(function () {
    $("#product-carousel").owlCarousel({
        loop: true, // Enable the loop
        margin: 10, // Space between items
        nav: false, // Disable the default navigation
        responsive: {
            0: {
                items: 1 // Number of items to show in different screen sizes
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    // Custom navigation buttons
    var customPrevBtn = $(".customPrevBtn");
    var customNextBtn = $(".customNextBtn");

    customPrevBtn.click(function () {
        $("#product-carousel").trigger("prev.owl.carousel");
    });

    customNextBtn.click(function () {
        $("#product-carousel").trigger("next.owl.carousel");
    });
});
</script>

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
         $(document).ready(function() {
           var owl = $('.owl-carousel');
           owl.owlCarousel({
             margin: 10,
             nav: true,
             loop: true,
             responsive: {
               0: {
                 items: 1
               },
               600: {
                 items: 2
               },
               1000: {
                 items: 5
               }
             }
           })
         })
      </script>

</body>

</html>