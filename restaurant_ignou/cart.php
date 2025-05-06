<?php
session_start();
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if alert message is set
if (isset($_SESSION['alert_message'])) {
    // Display alert message in JavaScript
    echo '<script>alert("' . $_SESSION['alert_message'] . '");</script>';
    // Unset the session variable
    unset($_SESSION['alert_message']);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the item name, restaurant name, and user name from the form
    $itemName = $_POST['item_name'];
    $restaurantName = $_POST['restaurant_name'];
    $userName = $_SESSION['user_name'];

  // Get the item name from the form

// Query to fetch the price of the item from the database based on its name
$price_query = "SELECT price FROM menu WHERE name = '$itemName'";
$price_result = mysqli_query($con, $price_query);
$price_row = mysqli_fetch_assoc($price_result);
$itemPrice = $price_row['price'];
echo $itemPrice; // This should display the price


   

    
    // Query to check if the item is already in the cart for the logged-in user
    $cart_query = "SELECT * FROM menu_cart WHERE item_name = '$itemName' AND rest_name = '$restaurantName' AND user_name = '$userName'";
    $cart_result = mysqli_query($con, $cart_query);

    // Display an alert if the item is already in the cart for the logged-in user
    if (mysqli_num_rows($cart_result) > 0) {
        echo "<script>alert('This item from $restaurantName is already in your cart.');</script>";
    } else {
        // If not already in the cart, add the item to the cart
        // Your code to add the item to the cart goes here
        
        // For example:
        $insert_query = "INSERT INTO menu_cart (item_name, rest_name, user_name) VALUES ('$itemName', '$restaurantName', '$userName')";
        if (mysqli_query($con, $insert_query)) {
            echo "<script>alert('Item added to cart successfully.');</script>";
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
        }
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
        <style>
    button[name="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px;
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
        <li class="active">
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
                                    <table class="table table-bordered table-hover" style="margin-left:120px;">
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
                                            <?php
                                            $count = 1;
                                            $user_name = $_SESSION['user_name'];
                                            $cart_query = "SELECT * FROM menu_cart WHERE user_name = '$user_name'";
                                            $cart_result = mysqli_query($con, $cart_query);

                                            $totalAmount = 0;

                                            // Assuming $cartResult is the result set containing cart items
                                            while ($cartRow = mysqli_fetch_assoc($cart_result)) {
                                                $itemId = $cartRow['item_id'];
                                                $itemName = $cartRow['item_name'];
                                                 $price_query = "SELECT price FROM menu WHERE name = '$itemName'";
    $price_result = mysqli_query($con, $price_query);
    $price_row = mysqli_fetch_assoc($price_result);
    $itemPrice = $price_row['price'];
                                               
                                                $restaurantID = $cartRow['rest_id'];
                                                $restaurantName = $cartRow['rest_name'];
                                                $quantity = 1; // Default quantity

                                                $itemTotal = $itemPrice * $quantity;

                                            ?>
                                             <input type="hidden" name="quantity[<?php echo $itemId; ?>][<?php echo $restaurantID; ?>][<?php echo $count; ?>]" value="<?php echo $quantity; ?>">
        <input type="hidden" name="subtotal[<?php echo $itemId; ?>][<?php echo $restaurantID; ?>][<?php echo $count; ?>]" value="<?php echo $itemTotal; ?>">
                                                <tr class="item-row">
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $itemName; ?></td>
                                                    <td><?php echo $itemPrice; ?></td>

                                                    <td><?php echo $restaurantName; ?></td>
                                                    <td>
                                                        <!-- <input type="number" class="quantity-input" name="quantity[<?php echo $itemId; ?>][<?php echo $restaurantID; ?>][<?php echo $count; ?>]" value="<?php echo $quantity; ?>" min="1" onchange="updateAmount(this, <?php echo $itemPrice; ?>, <?php echo $itemId; ?>, <?php echo $restaurantID; ?>, <?php echo $count; ?>);"> -->

                                                        
                                                        <input type="number" class="quantity-input" name="quantity[<?php echo $itemId; ?>][<?php echo $restaurantID; ?>][<?php echo $count; ?>]"
   data-item-id="<?php echo $itemId; ?>"
   data-restaurant-id="<?php echo $restaurantID; ?>"
   data-count="<?php echo $count; ?>"
   value="<?php echo $quantity; ?>"
   min="1" onchange="updateAmount(this, <?php echo $itemPrice; ?>, <?php echo $itemId; ?>, <?php echo $restaurantID; ?>, <?php echo $count; ?>);">


                                                    </td>
                                                    <td><span class="item-total" id="item-total-<?php echo $itemId; ?>-<?php echo $restaurantID; ?>-<?php echo $count; ?>"><?php echo $itemTotal; ?></span></td>
                                                    <td>
                                                        <input type="checkbox" name="selectedItems[]" value="<?php echo $itemId . '-' . $restaurantID . '-' . $count; ?>">

                                                    </td>
                                                  
                                                 <td>
    <button type="button" class="btn btn-danger remove-item" data-table-id="<?php echo $cartRow['id']; ?>" data-item-id="<?php echo strval($itemId); ?>">
        <i class="fa fa-trash" aria-hidden="true"></i> Remove
    </button>
</td>



  <input type="hidden" name="itemData" id="itemDataInput" value="">
    <!-- Add these hidden input fields inside your <form> element -->
    <input type="hidden" name="customer_id" value="<?php echo $_SESSION['user_id']; ?>">
    <input type="hidden" name="total_amount" id="total-amount-input" value="">

<!-- Inside the loop where you generate form inputs -->
<input type="hidden" name="restaurant_id[<?php echo $count; ?>]" value="<?php echo $restaurantID; ?>">
<input type="hidden" name="restaurant_name[<?php echo $count; ?>]" value="<?php echo $restaurantName; ?>">




                                                </tr>
                                            <?php
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                        <tr>
    <td colspan="5" style="text-align: right;">
        <!-- Display the Calculate Total button -->
       <h6>Total Amount</h6>
    </td>
    <td colspan="3">
        <span id="total-amount"><?php echo $totalAmount; ?></span>
        <input type="hidden" name="totalAmount" value="<?php echo $totalAmount; ?>">
    </td>
</tr>
<!-- Inside the loop where you generate form inputs -->
<input type="hidden" name="total_amount" id="total-amount-input" value="">

                                    </table>
                                   




                                    <button type="submit" name="submit" style="margin-left:500px;">Make Payment</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- ... your existing HTML and PHP code ... -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    $(document).ready(function () {
    // Attach click event to remove buttons
    $('.remove-item').click(function () {
        var tableId = $(this).data('table-id');

        // Make an Ajax request to remove the item from the cart based on the table ID
        $.ajax({
            type: 'POST',
            url: 'remove-item.php',
            data: {
                table_id: tableId
            },
            success: function (response) {
                // Refresh the page after successful removal
                location.reload();
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });
});


</script>

<script>
    var itemData = {};

    function updateAmount(input, itemPrice, itemId, restaurantId, count) {
        var quantity = input.value;
        var itemTotal = itemPrice * quantity;

        // Update the item total display
        $('#item-total-' + itemId + '-' + restaurantId + '-' + count).text(itemTotal.toFixed(2));

        // Update the quantity and amount in the JavaScript object
        itemData[itemId] = itemData[itemId] || {};
        itemData[itemId][restaurantId] = itemData[itemId][restaurantId] || {};
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
    $('input[name="selectedItems[]"]:checked').each(function () {
        var values = this.value.split('-');
        var itemId = values[0];
        var restaurantId = values[1];
        var count = values[2];

        totalAmount += parseFloat($('#item-total-' + itemId + '-' + restaurantId + '-' + count).text());
    });

    // Update the total amount display
    $('#total-amount').text(totalAmount.toFixed(2));

    // Update the value of the hidden input field
    $('#total-amount-input').val(totalAmount.toFixed(2));
}


    $(document).ready(function () {
        // Attach change event to checkboxes
        $('input[name="selectedItems[]"]').change(function () {
            calculateTotalAmount();
        });

        // Attach change event to quantity inputs
        $('.quantity-input').change(function () {
            var itemPrice = parseFloat($(this).closest('tr').find('td:eq(2)').text());
            updateAmount(this, itemPrice, $(this).data('item-id'), $(this).data('restaurant-id'), $(this).data('count'));
        });

        // Trigger the change event on page load for each quantity input
        $('.quantity-input').change();
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

    <style>
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
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
