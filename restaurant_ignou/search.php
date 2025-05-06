<?php
// search.php

session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Function to check if the input is a place
function is_place($input) {
    return preg_match('/^[a-zA-Z\s]+$/', $input);
}

$search_results = '';

if (isset($_GET['search_query'])) {
    $search_query = $_GET['search_query'];

    // Perform SQL query to search for restaurants based on name, place, or address
    $query = "SELECT * FROM restaurants WHERE name LIKE '%$search_query%' OR place LIKE '%$search_query%' OR address LIKE '%$search_query%'";

    $result = mysqli_query($con, $query);

    // Check if any matching restaurants found
    if (mysqli_num_rows($result) > 0) {
        // Display matching restaurants
        while ($row = mysqli_fetch_assoc($result)) {
            $restaurant_id = $row['id'];
            $file_path = $row['image'];

            // Build HTML for each restaurant
            $search_results .= '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom">';
            $search_results .= '<a href="rest_view.php?id=' . $restaurant_id . '">';
            $search_results .= '<div class="blog_box">';
            $search_results .= '<div class="blog_img_box">';
            $search_results .= '<figure><img src="admin/' . $file_path . '" style="width: 348.66px; height: 348.66px;" alt="#" /></figure>';
            $search_results .= '</div>';
            $search_results .= '<h3>' . $row['name'] . '</h3>';
            $search_results .= '<p class="label">Address:</p>';
            $search_results .= '<p>' . $row['address'] . '</p>';
            $search_results .= '<p class="label">Contact: <span>' . $row['phone'] . '</span></p>';
            $search_results .= '<p class="label">Place: <span>' . $row['place'] . '</span></p>';
            $search_results .= '</div>';
            $search_results .= '</a>';
            $search_results .= '<button class="review-btn" onclick="showReviewForm(' . $restaurant_id . ')">Add Review</button>';
            $search_results .= '<button class="view-reviews-btn" onclick="fetchReviews(' . $restaurant_id . ')">View Reviews</button>';
            $search_results .= '<div id="review-form-' . $restaurant_id . '" class="review-form" style="display: none;">';
            if (isset($_SESSION['user_name'])) {
                $search_results .= '<h4>Review for ' . $row['name'] . '</h4>';
                $search_results .= '<form method="POST" action="submit_review.php">';
                $search_results .= '<input type="hidden" name="restaurant_id" value="' . $restaurant_id . '">';
                $search_results .= '<input type="hidden" name="customer_id" value="' . $_SESSION['user_id'] . '">';
                $search_results .= '<p><strong>Customer:</strong> ' . $_SESSION['user_name'] . '</p>';
                $search_results .= '<textarea name="review" placeholder="Write your review here..." required></textarea>';
                $search_results .= '<button type="submit">Submit</button>';
                $search_results .= '</form>';
            } else {
                $search_results .= '<p>Please log in to leave a review.</p>';
            }
            $search_results .= '</div>';
            $search_results .= '<div id="reviews-' . $restaurant_id . '" class="reviews-section" style="display: none;"></div>';
            $search_results .= '</div>';
        }
    } else {
        // No matching restaurants found
        $search_results = "<p>No restaurants found matching your search criteria.</p>";
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
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
      <style>
  .blog_box {
    position: relative;
  }

  .blog_box h3,
  .blog_box p {
    margin-bottom: -1px;
  }

  .blog_box p.label {
    font-weight: bold;
    color: #000000; /* Change the color as needed */
    margin-bottom: 1px; /* Adjust the margin-bottom for spacing */
  }
  p.label {
  margin-bottom: 1px; /* Decrease the margin bottom */
}
.blog_box p.label span {
  font-weight: normal; /* Reset font weight */
  color: #333333; /* Change color for phone number */
  margin-left: 5px; /* Add some space between label and phone number */
}
.blog_box h3 {
    text-decoration: underline; /* Add underline only to h3 within .blog_box */
    text-align: center;
}
.btn-primary {
    background-color: #007bff; /* Primary color */
    border-color: #007bff; /* Primary color */
}

.btn-primary:hover {
    background-color: #0056b3; /* Darken color on hover */
    border-color: #0056b3; /* Darken color on hover */
}
/* Styling the Add Review button */
.review-btn, .view-reviews-btn {
    background-color: #4CAF50; /* Green background */
    border: none; /* Remove border */
    color: white; /* White text */
    padding: 10px 24px; /* Some padding */
    text-align: center; /* Centered text */
    text-decoration: none; /* Remove underline */
    display: inline-block; /* Make the button inline-block */
    font-size: 16px; /* Increase font size */
    margin: 10px 2px; /* Some margin */
    cursor: pointer; /* Pointer/hand icon on hover */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s ease; /* Smooth transition */
}

.review-btn:hover, .view-reviews-btn:hover  {
    background-color: #45a049; /* Darker green on hover */
}

/* Styling the review form */
.review-form, .reviews-section  {
    background-color: #f9f9f9; /* Light grey background */
    border: 1px solid #ddd; /* Grey border */
    padding: 20px; /* Some padding */
    margin-top: 10px; /* Margin on top */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

.review-form h4 {
    margin-top: 0; /* Remove top margin */
}

.review-form textarea {
    width: 100%; /* Full width */
    padding: 10px; /* Some padding */
    border: 1px solid #ccc; /* Grey border */
    border-radius: 4px; /* Rounded corners */
    resize: vertical; /* Allow vertical resizing */
    margin-bottom: 10px; /* Margin at the bottom */
}

.review-form button {
    background-color: #4CAF50; /* Green background */
    color: white; /* White text */
    border: none; /* Remove border */
    padding: 10px 20px; /* Some padding */
    text-align: center; /* Centered text */
    text-decoration: none; /* Remove underline */
    display: inline-block; /* Make the button inline-block */
    font-size: 16px; /* Increase font size */
    margin-top: 10px; /* Some margin at the top */
    cursor: pointer; /* Pointer/hand icon on hover */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s ease; /* Smooth transition */
}

.review-form button:hover {
    background-color: #45a049; /* Darker green on hover */
}
.reviews-section .review {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
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
<div class="blog">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title">
          
          <h2>Search Results</h2>
        </div>
      </div>
    </div>

                    <div class="row">
                        <?php echo $search_results; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer code here -->
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

 <script>
function showReviewForm(restaurantId) {
    var form = document.getElementById('review-form-' + restaurantId);
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

function fetchReviews(restaurantId) {
    var reviewsSection = document.getElementById('reviews-' + restaurantId);
    if (reviewsSection.style.display === 'none') {
        // Make AJAX request to fetch reviews
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_reviews.php?restaurant_id=' + restaurantId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                reviewsSection.innerHTML = xhr.responseText;
                reviewsSection.style.display = 'block';
            }
        };
        xhr.send();
    } else {
        reviewsSection.style.display = 'none';
    }
}
</script>


</body>

</html>
