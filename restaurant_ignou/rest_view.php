<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "restaurant");

if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_POST['add_to_cart'])) {
    $user_name = $_POST['user_name'];
    $item_id = $_POST['item_id'];
    $restaurant_id = $_POST['restaurant_id'];

    // Check if the item from the same restaurant already exists in the cart for the logged-in user
    $check_query = "SELECT * FROM menu_cart WHERE user_name = '$user_name' AND item_id = '$item_id' AND rest_id = '$restaurant_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Set session variable for alert message
        $_SESSION['alert_message'] = "This item from this restaurant is already in the cart!";
    } else {
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $item_image = $_POST['item_image'];
        $restaurant_name = $_POST['restaurant_name'];

        // Insert data into the cart table
        $cart_insert_query = "INSERT INTO menu_cart (user_name, item_id, item_name, price, img, rest_id, rest_name)
                             VALUES ('$user_name', '$item_id', '$item_name', '$item_price', '$item_image', '$restaurant_id', '$restaurant_name')";
        mysqli_query($con, $cart_insert_query);

        $_SESSION['alert_message'] = "Item added to the cart!";
    }

    // Redirect to the cart page or perform any other actions
    header("Location: cart.php"); // Change "cart.php" to the actual cart page URL
    exit();
}

?>


<!-- The rest of your HTML code remains unchanged -->


<!-- The rest of your HTML code remains unchanged -->

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
        <!-- Add the following styles to the existing styles in the head section -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
    }

     .blog_box {
    position: relative;
  }


   

    .restaurant-details-box {
    background-color: #f8f8f8;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    
}

.restaurant-details-box h3 {
    /* Highlight color */
    font-size: 24px;
    margin-bottom: 10px;
}

.restaurant-details-box p {
    margin-bottom: 8px;
}
.restaurant-details-box p strong {
    color: #333; /* Highlight the text within <strong> tags */
    font-weight: bold; /* Make the text bold */
}


    .menu-item-box {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .menu-item-box img {
        width: 100%;
        height: auto;
        margin-bottom: 10px;
        border-radius: 8px;
    }
    .menu-item-box p strong {
    color: #333; /* Highlight the text within <strong> tags */
    font-weight: bold; /* Make the text bold */
}


    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Additional style to make each menu item take full width */
    .menu-item-box {
        width: 100%;
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
    <!-- end header -->
<?php
            if (isset($_GET['id'])) {
                $restaurant_id = $_GET['id'];
                // Retrieve restaurant details
                $query = "SELECT * FROM restaurants WHERE id = '$restaurant_id'";
                $result = mysqli_query($con, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
            ?>
<div class="blog" style="margin-bottom:5px; margin-top: -80px;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title">
          <i><img src="images/title.png" alt="#"/></i>
          <h1 style="text-align: center; color:#007bff;"><?php echo $row['name']; ?> </h1>
         
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-20 mar_bottom d-flex justify-content-center">
        <div class="product-detail">
            
            <div class="row">
                <div class="col-md-12" >
                    
                </div>
                <div class="" style="width: 450px;height: 300px;">
                    <div class="restaurant-details-box">
                        <h3 style="text-align:center;">Restaurant Details</h3>
                        <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                        <p><strong>Contact:</strong> <?php echo $row['phone']; ?></p>
                        <p><strong>Place:</strong> <?php echo $row['place']; ?></p>
                    </div>
                </div>
            </div>
            <?php
        } }
        ?>
        </div>
    </div>
</div>
           
           

<div class="blog" style="margin-top: -200px;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title">
          
          <h1>Menu Items</h1>
        </div>
      </div>
    </div>
    <div class="row">
       <?php
                $menu_query = "SELECT * FROM menu
                   JOIN restaurant_menu ON menu.item_id = restaurant_menu.menu_id
                   WHERE restaurant_menu.restaurant_id = '$restaurant_id'";
                   $menu_result = mysqli_query($con, $menu_query);
                    while ($menu_row = mysqli_fetch_assoc($menu_result)) {
                   ?>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom">
          
            <div class="menu-item-box" style="height: 700px;">
              <div class="menu-item-box">
                <figure><img src="admin/<?php echo $menu_row['image']; ?>" style="width: 269.99px;height: 202.24px;" alt="#" />
                </figure>
              </div>
               <h3 style="text-align:center;"><?php echo $menu_row['name']; ?></h3>
                        <p><strong>Category:</strong> <?php echo $menu_row['category']; ?></p>
                        <p><strong>Description:</strong> <?php echo $menu_row['description']; ?></p><br>
                        <p><span class="product-price"><strong>Price: </strong>&#8377;<?php echo $menu_row['price']; ?></span></p><br>
                       <!--  <div class="menu-item-details">
                            <p><strong>Contact:</strong> <?php echo $row['phone']; ?></p>
                             <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                        </div> -->
                        <form action="" method="post">
                            <input type="hidden" name="item_id" value="<?php echo $menu_row['item_id']; ?>">
                            <input type="hidden" name="item_name" value="<?php echo $menu_row['name']; ?>">
                            <input type="hidden" name="item_price" value="<?php echo $menu_row['price']; ?>">
                            <input type="hidden" name="item_image" value="<?php echo $menu_row['image']; ?>">
                            <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
                            <input type="hidden" name="restaurant_name" value="<?php echo $row['name']; ?>">
                            <input type="hidden" name="user_name" value="<?php echo $_SESSION['user_name']; ?>">
                            <button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>
                        </form>
                        <br>
                       <a href="item_order.php?item_id=<?php echo $menu_row['item_id']; ?>&restaurant_name=<?php echo urlencode($row['name']); ?>" class="btn btn-success" name="order_now">Order Now</a>


                        
            </div>
          </a>
        </div>
      <?php
      }
      ?>
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