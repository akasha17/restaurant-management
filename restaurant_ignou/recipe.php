<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "restaurant");

if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_POST['add_to_cart'])) {
    $item_id = mysqli_real_escape_string($con, $_POST['item_id']);
    $restaurant_id = mysqli_real_escape_string($con, $_POST['restaurant_id']);
    $item_price = mysqli_real_escape_string($con, $_POST['item_price']);
    $item_image = mysqli_real_escape_string($con, $_POST['item_image']);
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);

    // Check if the item already exists in the cart for the logged-in user
    $check_query = "SELECT * FROM menu_cart WHERE item_id = '$item_id' AND user_name = '$user_name' AND restaurant_id = '$restaurant_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Item already exists in the cart, show alert and redirect to cart page
        echo "<script>alert('Item is already in the cart!');</script>";
        echo "<script>window.location.href = 'cart.php';</script>";
        exit;
    } else {
        // Item doesn't exist in the cart, add it to the cart table
        $insert_query = "INSERT INTO menu_cart (item_id, restaurant_id, user_name, item_price, item_image) VALUES ('$item_id', '$restaurant_id', '$user_name', '$item_price', '$item_image')";
        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            // Item added to cart successfully, redirect to cart page
            echo "<script>window.location.href = 'cart.php';</script>";
            exit;
        } else {
            // Error occurred while adding item to cart, handle as needed
            echo "<script>alert('Error occurred while adding item to cart!');</script>";
            echo "<script>window.location.href = 'recipe.php';</script>";
            exit;
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

    <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <!--  <script>
    document.addEventListener("DOMContentLoaded", function() {
        var addToCartButtons = document.querySelectorAll('.add_to_cart_btn');
        addToCartButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default form submission
                var form = this.closest('form');
                form.submit(); // Submit the form
            });
        });
    });
</script> -->


    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

        <style>
            /* Add this to your CSS file */
.product_blog_cont {
    position: relative;
}

.restaurant_name {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.8); /* Adjust the background color and opacity as needed */
    padding: 5px;
    margin: 0;
}
.available-items {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between; /* or justify-content: space-around; */
}

.available_item {
    width: 30%; /* Set the width as needed */
    margin-bottom: 20px; /* Adjust margin as needed */
}
.order_now_btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.order_now_btn:hover {
    background-color: #45a049;
}
.add_to_cart_btn {
    background-color: #007bff; /* Set your desired background color */
    color: #fff; /* Set your desired text color */
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Add a smooth transition effect */
}

.add_to_cart_btn:hover {
    background-color: #0056b3; /* Set your desired hover background color */
}
.button-gap {
    margin-bottom: 20px; /* Adjust the margin as needed */
}
/* Add this to your CSS file */
.available_section {
    background-color: #f8f8f8; /* Set your desired background color */
    padding: 40px 0; /* Adjust the padding as needed */
}

.available_section h2 {
    font-size: 36px; /* Set your desired font size */
    color: #333; /* Set your desired text color */
    text-align: center; /* Center the text */
    margin-bottom: 30px; /* Adjust the margin as needed */
}

.available_item {
    background-color: #fff; /* Set your desired background color */
    border: 1px solid #ddd; /* Set your desired border color */
    border-radius: 10px; /* Adjust border-radius as needed */
    padding: 20px; /* Adjust padding as needed */
    margin-bottom: 30px; /* Adjust margin as needed */
}

.available_item h3 {
    font-size: 24px; /* Set your desired font size */
    color: #333; /* Set your desired text color */
}

/* Add this to your CSS file */
.available_item p {
    font-size: 16px; /* Set your desired font size */
    color: #555; /* Set your desired text color */
    margin-bottom: 10px; /* Adjust margin as needed */
}

/* Add a new class for styling the restaurant names */
.restaurant-name {
    font-weight: bold; /* Set your desired font weight */
    color: r: 160, g: 32, b: 240; /* Set your desired color for restaurant names */
}



.items-container {
    white-space: nowrap; /* Prevent wrapping */
    overflow-x: auto; /* Enable horizontal scrolling */
}

.product-item {
    display: inline-block;
    margin-right: 10px; /* Add spacing between items */
}


        </style>
</head>
<!-- body -->
 
<body class="main-layout Recipes_page">
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
        <li class="active">
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
                     <h2>Our Recipes</h2>
                    
                  </div>
               </div>
            </div>
          </div>
</div>
    <!-- section -->
<section class="resip_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="items-container">
                    <?php
                    $query = "SELECT menu.*, 
                                 GROUP_CONCAT(restaurants.name SEPARATOR ', ') AS restaurant_names,
                                 MIN(menu.image) AS image_path,  -- Selecting the minimum image path
                                 MIN(menu.price) AS min_price    -- Selecting the minimum price
                          FROM menu
                          LEFT JOIN restaurant_menu ON menu.item_id = restaurant_menu.menu_id
                          LEFT JOIN restaurants ON restaurant_menu.restaurant_id = restaurants.id
                          GROUP BY menu.item_id";

                    $result = mysqli_query($con, $query);

                    if (!$result) {
                        die("Error in SQL query: " . mysqli_error($con));
                    }

                    while ($row = mysqli_fetch_assoc($result)) {
                        $file_path = $row['image_path']; // Use the selected image path
                        $item_id = $row['item_id'];

                        echo '<div class="product-item">';
                        echo '<div class="item">';
                        echo '<div class="product_blog_img">';
                        echo '<img src="admin/' . $file_path . '" alt="#" style="height: 212.92px;width: 214px;" />';
                        echo '</div>';
                        echo '<div class="product_blog_cont">';
                        echo '<h3>' . $row['name'] . '</h3>';
                        echo '<h4><span class="theme_color">&#8377;</span>' . $row['min_price'] . '</h4>'; // Use the selected minimum price
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="available_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Available in Restaurants</h2>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h3 style="text-align: center;">Search for Available Restaurants</h3>
                        <form action="" method="post" id="searchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search_item" placeholder="Enter Item Name">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>

                <div class="available-items">
                    <?php
                    if (isset($_POST['search_btn'])) {
                        $search_item = mysqli_real_escape_string($con, $_POST['search_item']);
                        $search_query = "SELECT menu.*, GROUP_CONCAT(restaurants.name SEPARATOR ', ') AS restaurant_names
                                         FROM menu
                                         LEFT JOIN restaurant_menu ON menu.item_id = restaurant_menu.menu_id
                                         LEFT JOIN restaurants ON restaurant_menu.restaurant_id = restaurants.id
                                         WHERE menu.name LIKE '%$search_item%'
                                         GROUP BY menu.item_id";
                        $search_result = mysqli_query($con, $search_query);

                        if ($search_result) {
                            if (mysqli_num_rows($search_result) > 0) {
                                $previousItemName = null;

                                while ($row = mysqli_fetch_assoc($search_result)) {
                                    $item_id = $row['item_id'];
                                    $restaurant_names = explode(', ', $row['restaurant_names']);

                                    if ($row['name'] !== $previousItemName) {
                                        if ($previousItemName !== null) {
                                            echo '</div>'; // Close the previous item's container
                                        }

                                        echo '<div class="available_item">';
                                        echo '<h3>' . $row['name'] . '</h3>';
                                        $previousItemName = $row['name'];
                                    }

                                    foreach ($restaurant_names as $restaurant_name) {
                                        echo '<p>Available in: <span class="restaurant-name">' . $restaurant_name . '</span></p>';
                                        echo '<div class="button-gap"></div>';
                                        // ... rest of your code
                                        echo '<a href="item-order.php?item_id=' . $item_id . '&restaurant_name=' . $restaurant_name . '" class="order_now_btn">Order Now</a>';
                                        echo '<div class="button-gap"></div>';
                                        
                                        echo '<form action="add-to-cart.php" method="post">';
                                        echo '<input type="hidden" name="item_name" value="' . $row['name'] . '">';
                                        echo '<input type="hidden" name="restaurant_name" value="' . $restaurant_name . '">';
                                        echo '<button type="submit" class="add_to_cart_btn" name="add_to_cart">Add to Cart</button>';
                                        echo '</form>';
                                        
                                    }
                                }

                                if ($previousItemName !== null) {
                                    echo '</div>'; // Close the last item's container
                                }
                            } else {
                                echo '<p>No results found in any restaurants for the item: ' . $search_item . '</p>';
                            }
                        } else {
                            echo "Error in search query: " . mysqli_error($con);
                        }
                    } else {
                        // Display all items (similar to the original code)
                        mysqli_data_seek($result, 0);

                        $previousItemName = null;

                        while ($row = mysqli_fetch_assoc($result)) {
                            $item_id = $row['item_id'];
                            $restaurant_names = explode(', ', $row['restaurant_names']);

                            if ($row['name'] !== $previousItemName) {
                                if ($previousItemName !== null) {
                                    echo '</div>'; // Close the previous item's container
                                }

                                echo '<div class="available_item">';
                                echo '<h3>' . $row['name'] . '</h3>';
                                $previousItemName = $row['name'];
                            }

                            foreach ($restaurant_names as $restaurant_name) {
                                echo '<p>Available in: <span class="restaurant-name">' . $restaurant_name . '</span></p>';
                                echo '<div class="button-gap"></div>';
                                // ... rest of your code
                                echo '<a href="item-order.php?item_id=' . $item_id . '&restaurant_name=' . $restaurant_name . '" class="order_now_btn">Order Now</a>';
                                echo '<div class="button-gap"></div>';
                               echo '<form action="add-to-cart.php" method="post">';
                                        echo '<input type="hidden" name="item_name" value="' . $row['name'] . '">';
                                        echo '<input type="hidden" name="restaurant_name" value="' . $restaurant_name . '">';
                                        echo '<button type="submit" class="add_to_cart_btn" name="add_to_cart">Add to Cart</button>';
                                        echo '</form>';
                            }
                        }

                        if ($previousItemName !== null) {
                            echo '</div>'; // Close the last item's container
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>




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

    <script src="owlcarousel/jquery.min.js"></script>
    <script src="owlcarousel/owl.carousel.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
     <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    
     <script src="js/jquery-3.0.0.min.js"></script>
   <!--   <script>
    // JavaScript to handle the click event of Add to Cart button
    document.addEventListener("DOMContentLoaded", function() {
        var addToCartButtons = document.querySelectorAll('.add_to_cart_btn');
        addToCartButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default form submission
                var form = this.closest('form');
                form.submit(); // Submit the form
            });
        });
    });
</script> -->
    <!--  <script>
function addToCart(item_id, restaurant_name, item_name, item_price, item_image, restaurant_id) {
    // Get the current logged-in user name from the PHP session
    var user_name = "<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; ?>";

    // Perform an AJAX request to check if the item is already in the cart
    $.ajax({
        type: "POST",
        url: "checkCartItem.php",
        data: {
            item_id: item_id,
            restaurant_name: restaurant_name,
            user_name: user_name
        },
        success: function(response) {
            // Handle the response from the server
            if (response.trim() === 'exists') {
                // Display an alert if the item from this restaurant is already in the cart
                alert("This item from " + restaurant_name + " is already in your cart!");
            } else {
                // If the item is not in the cart, proceed to add it
                // Prepare data to send to the server
                var data = {
                    item_id: item_id,
                    restaurant_name: restaurant_name,
                    item_name: item_name,
                    item_price: item_price,
                    item_image: item_image,
                    user_name: user_name,
                    restaurant_id: restaurant_id
                };

                // Perform an AJAX request to add the item to the cart
                $.ajax({
                    type: "POST",
                    url: "addToCart.php",
                    data: data,
                    success: function(response) {
                        // Handle the response from the server if needed
                        console.log(response);

                        // Show an alert indicating that the item has been added to the cart
                        alert("Item added to the cart!");

                        // Redirect to the cart page after adding to the cart
                        window.location.href = 'cart.php';
                    },
                    error: function(error) {
                        // Handle the error if the AJAX request fails
                        console.error(error);
                    }
                });
            }
        },
        error: function(error) {
            // Handle the error if the AJAX request fails
            console.error(error);
        }
    });
}



</script>
 -->
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