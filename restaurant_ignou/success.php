<?php
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check if the restaurant_id and restaurant_name are set in the URL
if (isset($_GET['restaurant_id']) && isset($_GET['restaurant_name'])) {
    // Retrieve restaurant ID and name from the URL query parameters
    $restaurantId = $_GET['restaurant_id'];
    $restaurantName = urldecode($_GET['restaurant_name']); // Decodes the URL-encoded restaurant name

    // Safely output the restaurant details (use htmlspecialchars to prevent XSS attacks)
    echo "Restaurant ID: " . htmlspecialchars($restaurantId) . "<br>";
    echo "Restaurant Name: " . htmlspecialchars($restaurantName) . "<br>";
} else {
    // Handle the case where the parameters are missing
    echo "Restaurant details not available.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- Site Metas -->
    <title>Online Restaurant Management System</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Owl CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Awesome Fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        /* Add your custom styles here */
        .feedback-box {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .feedback-box label {
            display: block;
            margin-bottom: 10px;
        }

        .feedback-box textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .feedback-box button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<!-- Body -->

<body class="main-layout blog_page">
    <!-- Loader -->
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
                                
                                <!-- <li class="button_user"><a class="button" href="sign in.php">Login</a><a class="button" href="sign up.php">Register</a></li> -->
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
            <!-- Blog Page Content -->
            <div class="yellow_bg">
                <!-- ... (unchanged) ... -->
            </div>

            <div class="container">
    <!-- Thank You Section -->
    <div class="text-center mt-5">
        <h1>Thank you for your payment!</h1>
        <p>We appreciate your business.</p>
    </div>

    <!-- Feedback Section -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["feedback"]) && $_POST["feedback"] == "yes") {
        // Display feedback form
        echo '<div class="feedback-box mt-5">';
        echo '<h2 class="text-center">Provide Feedback</h2>';
        echo '<form action="submit_feedback.php" method="post">';
        echo '<input type="hidden" name="restaurant_id" value="' . htmlspecialchars($restaurantId) . '">';
        echo '<label for="feedback-text">Your Feedback:</label>';
        echo '<textarea id="feedback-text" name="feedback-text" rows="4" required></textarea>';
        echo '<br>';
        echo '<button type="submit">Submit Feedback</button>';
        echo '</form>';
        echo '</div>';
    } else {
        // Display option to provide feedback
        echo '<div class="feedback-box mt-5 text-center">';
        echo '<h2>Would you like to provide feedback?</h2>';
        echo '<form action="" method="post">';
        echo '<label for="feedback-yes">Yes</label>';
        echo '<input type="radio" id="feedback-yes" name="feedback" value="yes" required>';
        echo '<label for="feedback-no">No</label>';
        echo '<input type="radio" id="feedback-no" name="feedback" value="no" required>';
        echo '<br>';
        echo '<button type="submit">Submit</button>';
        echo '</form>';
        echo '</div>';
    }
    ?>

    <!-- Back to Home Button -->
    <div class="mt-5 text-center">
        <a href="index.php" class="btn btn-secondary">Back to Home</a>
    </div>
</div>
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
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
</body>

</html>
