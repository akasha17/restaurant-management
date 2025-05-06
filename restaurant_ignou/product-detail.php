<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Function to handle database errors
function handleDatabaseError($message = "Database operation failed.") {
    echo "Error: $message";
    exit();
}

$restaurant_id = 0; // Initialize with a default value

if (isset($_GET['id'])) {
    $restaurant_id = (int) $_GET['id']; // Cast to integer for security

    $query_restaurant = "SELECT * FROM restaurants WHERE id = ?";
    $stmt_restaurant = mysqli_prepare($con, $query_restaurant);
    mysqli_stmt_bind_param($stmt_restaurant, "i", $restaurant_id);
    if (!mysqli_stmt_execute($stmt_restaurant)) {
        handleDatabaseError("Restaurant query execution failed.");
    }
    
    $result_restaurant = mysqli_stmt_get_result($stmt_restaurant);

    if ($result_restaurant && mysqli_num_rows($result_restaurant) > 0) {
        $row_restaurant = mysqli_fetch_assoc($result_restaurant);
        // Now $row_restaurant contains the details of the clicked restaurant
    } else {
        // Handle the case where the restaurant is not found
        echo "Restaurant not found.";
    }
}

// Fetch menu item details
$item_id = 0; // Initialize with a default value
if (isset($_GET['item_id'])) {
    $item_id = (int) $_GET['item_id'];
    $query_menu = "SELECT menu.*, restaurants.name AS rest_name 
                   FROM menu 
                   INNER JOIN restaurants ON menu.rest_id = restaurants.id 
                   WHERE menu.item_id = ?";
    $stmt_menu = mysqli_prepare($con, $query_menu);
    mysqli_stmt_bind_param($stmt_menu, "i", $item_id);
    if (!mysqli_stmt_execute($stmt_menu)) {
        handleDatabaseError("Menu query execution failed.");
    }
    $result_menu = mysqli_stmt_get_result($stmt_menu);
    $row_menu = mysqli_fetch_assoc($result_menu);
} else {
    // Handle the case where the 'item_id' parameter is not set
    echo "Item ID not provided.";
}

// ... existing code ...

if (isset($_POST['add_to_cart'])) {
    $item_id = (int) $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_image = $_POST['item_image'];
    $restaurant_id = (int) $_POST['restaurant_id']; // Add this line

    // Check if the cart session variable is set
    if (!isset($_SESSION['cart'])) {
        // If not, initialize it as an empty array
        $_SESSION['cart'] = array();
    }

    // Fetch user_id from the session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    // Check if the item is already in the cart
    if (!isset($_SESSION['cart'][$item_id][$user_id])) {
        // If not, add it to the session-based cart along with restaurant_id
        $_SESSION['cart'][$item_id][$user_id] = array(
            'name' => $item_name,
            'price' => $item_price,
            'image' => $item_image,
            'quantity' => 1,
            'restaurant_id' => $restaurant_id // Add this line
        );

        // Insert into the database cart table
        $insert_query = "INSERT INTO cart (user_id, item_id, name, price, image, rest_id) 
                         VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt_insert, "iissii", $user_id, $item_id, $item_name, $item_price, $item_image, $restaurant_id);

        if (!mysqli_stmt_execute($stmt_insert)) {
            handleDatabaseError("Insert into cart table failed.");
        }

        // Display an alert
        echo "<script>alert('Item added to cart.'); window.location.href = 'recipe.php';</script>";
        exit(); // Exit the script after displaying the alert
    } else {
        // If the item is already in the cart for the user, display a different message
        echo "<script>alert('Item is already in the cart.'); window.location.href = 'recipe.php';</script>";
        exit(); // Exit the script
    }
}
?>
<!-- ... existing HTML code ... -->






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
    <!-- end header -->

<div class="blog">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title">
          <i><img src="images/title.png" alt="#"/></i>
          <h2>Our Blog</h2>
          <!-- <span>when looking at its layout. The point of using Lorem</span> -->
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom d-flex justify-content-center align-items-center">
        <div class="product-detail text-center">
            <?php
            if (isset($_GET['item_id'])) {
                $item_id = $_GET['item_id'];
                // Fetch product details from the database based on $item_id
                // Replace this with your actual database query
                $query = "SELECT * FROM menu WHERE item_id = $item_id";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    $file_path = $row['image'];
            ?>
            <div class="blog_img_box">
                <figure><img src="admin/<?php echo $file_path; ?>" alt="#" /></figure>
            </div>
             <h3><?php echo $row['name']; ?></h3>
            <h5><?php echo $row['category']; ?></h5>
            <p>
                <span class="product-price"><b>Price:</b> <?php echo $row['price']; ?></span>
            </p>
            <p><b>Description:</b> <?php echo $row['description']; ?></p>
            <p><b>Restaurant:</b> <?php echo $row_menu['rest_name']; ?></p>
            <form action="" method="post">
                <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                <input type="hidden" name="item_name" value="<?php echo $row['name']; ?>">
                <input type="hidden" name="item_price" value="<?php echo $row['price']; ?>">
                <input type="hidden" name="item_image" value="<?php echo $row['image']; ?>">
                <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
                <button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>
            </form>
        </div>
      </div>
      <?php } } ?>
       <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom">
        <div class="blog_box">
          <div class="blog_img_box">
            <figure><img src="images/blog_img2.png" alt="#"/>
             <span>02 FEB 2019</span>
            </figure>
          </div>
          <h3>Egg & Tosh</h3>
          <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the </p>
        </div>
      </div> -->
       <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
        <div class="blog_box">
          <div class="blog_img_box">
            <figure><img src="images/blog_img3.png" alt="#"/>
             <span>02 FEB 2019</span>
            </figure>
          </div>
          <h3>Pizza</h3>
          <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the </p>
        </div>
      </div> -->
    </div>
  </div>
</div>

<!-- <div id="orderDetails" style="visibility: hidden;">
    <h4>Order Details</h4>
    <form class="main_form">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <input class="form-control" placeholder="Name" type="text" name="Name">
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <input class="form-control" placeholder="Email" type="text" name="Email">
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <input class="form-control" placeholder="Phone" type="text" name="Phone">
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <textarea class="textarea" placeholder="Message" type="text" name="Message"></textarea>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <button class="send">Send</button>
            </div>
        </div>
    </form>
    
</div> -->

    <fooetr>
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                  <div class=" col-md-12">
                    <h2>Request  A<strong class="white"> Call  Back</strong></h2>
                  </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                      
                        <form class="main_form">
                            <div class="row">
                             
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <input class="form-control" placeholder="Name" type="text" name="Name">
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <input class="form-control" placeholder="Email" type="text" name="Email">
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <input class="form-control" placeholder="Phone" type="text" name="Phone">
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <textarea class="textarea" placeholder="Message" type="text" name="Message"></textarea>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <button class="send">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="img-box">
                            <figure><img src="images/img.jpg" alt="img" /></figure>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer_logo">
                          <!-- <a href="index.html"><img src="images/logo1.jpg" alt="logo" /></a> -->
                        </div>
                    </div>
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