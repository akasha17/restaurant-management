<?php
session_start();
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
$item_id = $_GET['item_id'];
$restaurant_name = $_GET['restaurant_name'];
$item_name = $_GET['item_name'];

// Fetch additional details of the clicked item from the database
// Modify this query based on your database schema
$query = "SELECT * FROM your_items_table WHERE item_id = $item_id AND restaurant_name = '$restaurant_name'";
$result = mysqli_query($con, $query);

// Fetch the result (you may need to modify this based on your database structure)
$row = mysqli_fetch_assoc($result);

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
    <title>Spicyo</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>
                    <li>
                        <a href="recipe.html">Recipe</a>
                    </li>
                    <li>
                        <a href="blog.html">Blog</a>
                    </li>
                    <li>
                        <a href="contact.html">Contact Us</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="content">
            <!-- header -->
            <header>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <div class="full">
                                <div class="right_header_info">
                                    <ul>
                                        <li class="dinone">Contact Us : <img style="margin-right: 15px;margin-left: 15px;" src="images/phone_icon.png" alt="#"><a href="#">987-654-3210</a></li>
                                        <li class="dinone"><img style="margin-right: 15px;" src="images/mail_icon.png" alt="#"><a href="#">demo@gmail.com</a></li>
                                        <li class="dinone"><img style="margin-right: 15px;height: 21px;position: relative;top: -2px;" src="images/location_icon.png" alt="#"><a href="#">Kerala , India</a></li>
                                        <li class="button_user"><a class="button active" href="#">Login</a><a class="button" href="#">Register</a></li>
                                        <li><img style="margin-right: 15px;" src="images/search_icon.png" alt="#"></li>
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
            </header><br />
            <div class="yellow_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title">
                                <h2>Cart<strong class="white"> Contents</strong></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <form method="post" action="process-order.php">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Restaurant Name</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Select</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        <tr>
    <td colspan="5" style="text-align: right;">
        <!-- Display the Calculate Total button -->
        <button type="button" id="calculateTotalButton" onclick="calculateTotalAmount()">Calculate Total</button>
    </td>
    <td colspan="3">
        <span id="total-amount"><?php echo $totalAmount; ?></span>
    </td>
</tr>
                                    </table>
                                    <input type="hidden" name="itemData" id="itemDataInput" value="">
    <!-- Add these hidden input fields inside your <form> element -->
    <input type="hidden" name="customer_id" value="<?php echo $_SESSION['user_id']; ?>">
    <input type="hidden" name="total_amount" id="total-amount-input" value="">


                                    <button type="submit" name="submit">Make Payment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="footer_logo">
                                <!-- <a href="index.html"><img src="images/logo1.jpg" alt="logo" /></a> -->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="lik">
                                <li class="active"> <a href="index.html">Home</a></li>
                                <li> <a href="about.html">About</a></li>
                                <li> <a href="recipe.html">Recipe</a></li>
                                <li> <a href="blog.html">Blog</a></li>
                                <li> <a href="contact.html">Contact us</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="new">
                                <h3>Newsletter</h3>
                                <form class="newtetter">
                                    <input class="tetter" placeholder="Your email" type="text" name="Your email">
                                    <button class="submit">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <div class="container">
                        <p>© 2019 All Rights Reserved. Design by<a href="https://html.design/"> Free Html Templates</a></p>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- ... your existing HTML and PHP code ... -->

<script>
    var itemData = {};

   function updateAmount(input, itemPrice, itemId, restaurantId, count) {
    var quantity = input.value;

    // Calculate the item total
    var itemTotal = itemPrice * quantity;

    // Update the item total display for the corresponding item
    document.getElementById('item-total-' + itemId + '-' + restaurantId + '-' + count).innerText = itemTotal;

    // Update the quantity and amount in the JavaScript object
    if (!itemData[itemId]) {
        itemData[itemId] = {};
    }
    if (!itemData[itemId][restaurantId]) {
        itemData[itemId][restaurantId] = {};
    }
    itemData[itemId][restaurantId][count] = {
        quantity: quantity,
        amount: itemTotal
    };

    // Recalculate the total amount
    calculateTotalAmount();
}


    function calculateTotalAmount() {
        var totalAmount = 0;

        // Get an array of selected item IDs
        var selectedItems = document.querySelectorAll('input[name="selectedItems[]"]:checked');

        // Iterate through the selected items to calculate the total amount
        selectedItems.forEach(function (checkbox) {
            var itemId = checkbox.value.split('-')[0];
            var restaurantId = checkbox.value.split('-')[1];
            var count = checkbox.value.split('-')[2];

            totalAmount += itemData[itemId][restaurantId][count].amount;
        });

        // Update the total amount display
        document.getElementById('total-amount').innerText = totalAmount.toFixed(2);
    }

    // Trigger the change event on checkboxes
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[name="selectedItems[]"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                calculateTotalAmount();
            });
        });

        // Trigger the change event on page load for each quantity input
        document.querySelectorAll('.quantity-input').forEach(function (input) {
            updateAmount(input, parseFloat(input.value), input.dataset.itemId, input.dataset.restaurantId, input.dataset.count);
        });
    });
</script>


<!-- ... rest of your HTML ... -->


    <style>
        #owl-demo .item {
            margin: 3px;
        }

        #owl-demo .item img {
            display: block;
            width: 100%;
            height: auto;
        }
    </style>
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

<?php
// Close the database connection
mysqli_close($con);
?>

