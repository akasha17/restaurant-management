<?php
session_start();
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Get the logged-in user ID
    $user_id = $_SESSION['user_id'];

    // Fetch customer details based on the logged-in user ID
    $query = "SELECT * FROM customer WHERE customerid = '$user_id'";
    $customer_result = mysqli_query($con, $query);
} else {
    // Redirect or show an error if user is not logged in
    echo "User not logged in.";
    exit;
}
?>
<?php
if (isset($_SESSION['user_id'])) {
    // Get the logged-in user ID
    $user_id = $_SESSION['user_id'];
    $customer_name = $_SESSION['user_name'];

$pquery = "SELECT  item_id, item_name, restaurant_name, qnty, tot_amount, paid_date 
              FROM payment 
              WHERE customer_name = '$customer_name'";
    
    $result = mysqli_query($con, $pquery);
} else {
    $result = null;
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
    </header><br />
            <div class="yellow_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title">
                                <h2>Profile with<strong class="white"> Paid Items</strong></h2>
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
                                <h2>Profile</h2>
                              <table class="table table-bordered table-hover" style="margin-left:120px;">
                                    <thead>
                                        <tr>
                                            <th>Customer Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Address</th>
                                            <th>Password</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Check if the query returned any results
                                        if (mysqli_num_rows($customer_result) > 0) {
                                            // Fetch associative array for each row
                                            while ($customer_row = mysqli_fetch_assoc($customer_result)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($customer_row['customerid']) . "</td>";
                                                echo "<td>" . htmlspecialchars($customer_row['fname']) . "</td>";
                                                echo "<td>" . htmlspecialchars($customer_row['lname']) . "</td>";
                                                echo "<td>" . htmlspecialchars($customer_row['email']) . "</td>";
                                                echo "<td>" . htmlspecialchars($customer_row['phone']) . "</td>";
                                                echo "<td>" . htmlspecialchars($customer_row['address']) . "</td>";
                                                echo "<td>" . htmlspecialchars($customer_row['password']) . "</td>";
                                                echo '<td><a href="edit_customer.php?customerid=' . htmlspecialchars($customer_row['customerid']) . '">Edit</a></td>';
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8'>No customer details found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                     <div class="col-md-12">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <h2>Paid Item Details</h2>
                              <table class="table table-bordered table-hover" style="margin-left:120px;">
                                    <thead>
                                        <tr>
                                            <th>Item Id</th>
                                            <th>Item Name</th>
                                            <th>Restaurant Name</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                            <th>Paid Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <tbody>
                                <?php
                                // Check if the query returned any results
                                if ($result && mysqli_num_rows($result) > 0) {
                                    // Fetch associative array for each row
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['item_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['restaurant_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['qnty']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['tot_amount']) . "</td>";
                                        $paid_date = new DateTime($row['paid_date']);
            echo "<td>" . htmlspecialchars($paid_date->format('d M Y')) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No paid items found.</td></tr>";
                                }
                                ?>
                            </tbody>
                                    </tbody>
                                </table>


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


</body>

</html>

<?php
// Close the database connection
mysqli_close($con);
?>
