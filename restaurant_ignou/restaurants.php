<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");
 
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
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
       <!-- Add the following styles within the <style> tag in the head section -->
<!-- Add the following styles within the <style> tag in the head section -->

<style>
    /* Existing styles */
    .search-section {
        margin-top: 20px;
        margin-bottom: 40px;
    }

    .search-box {
        display: flex;
    }

    .search-input {
        flex: 1;
        padding: 10px;
    }

    .search-button {
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        cursor: pointer;
    }

    .search-results {
        margin-top: 20px;
    }

    /* New styles for search results */
    .search-results h3 {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    .search-results p {
        font-size: 16px;
        color: #555;
    }

    /* Style for no results message */
    .no-results-message {
        font-size: 18px;
        color: #f00; /* Red color for emphasis */
        margin-top: 10px;
    }

    /* Styles for restaurant displaying section */
   .blog {
        margin-top: 20px;
    }

    .blog_box {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        padding: 20px;
        transition: 0.3s;
        margin-bottom: 20px;
        border-radius: 10px; /* Rounded corners for the box */
    }

    .blog_box:hover {
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .blog_img_box {
        overflow: hidden;
        position: relative;
        border-radius: 8px; /* Rounded corners for the image */
    }

    .blog_img_box img {
        width: 100%;
        height: auto;
        transition: transform 0.3s;
        border-radius: 8px; /* Rounded corners for the image */
    }

    .blog_box:hover .blog_img_box img {
        transform: scale(1.1);
    }

    .blog h3 {
        font-size: 22px;
        color: #333;
        margin-top: 15px;
        margin-bottom: 10px;
    }

    .label {
        font-weight: bold;
        color: #555;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .blog p {
        font-size: 16px;
        color: #777;
        margin-bottom: 10px;
    }
</style>


</head>
<!-- body -->

<body class="main-layout blog_page">
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
<div class="yellow_bg">
   <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                     <h2> Restaurants</h2>
                    
                  </div>
               </div>
            </div>
          </div>
</div>

<div class="blog">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title">
          <i><img src="images/title.png" alt="#" /></i>
          <h2>Our Restaurants</h2>
        </div>
        <div class="search-section">
                        <h3>Search Restaurants</h3>
                        <div class="search-box">
                            <input type="text" class="search-input" placeholder="Search...">
                            <button class="search-button" onclick="searchRestaurants()">Search</button>
                        </div>
                    </div>
      </div>
    </div>
    <div class="search-results">
    <!-- Search results will be displayed here -->
</div>
    <div class="row">
      <?php
      $query = "SELECT * FROM restaurants";
      $result = mysqli_query($con, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        $restaurant_id = $row['id'];
        $file_path = $row['image'];
      ?>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom">
          <a href="rest_view.php?id=<?php echo $restaurant_id; ?>">
            <div class="blog_box">
              <div class="blog_img_box">
                <figure><img src="admin/<?php echo $file_path; ?>" style="width: 348.66px; height: 348.66px;" alt="#" />
                </figure>
              </div>
              <h3><?php echo $row['name']; ?></h3>
              <p class="label">Address:</p>
              <p><?php echo $row['address']; ?> </p>
              <p class="label">Contact:</p>
              <p><?php echo $row['phone']; ?> </p>
              <p class="label">Place:</p>
              <p><?php echo $row['place']; ?> </p>
            </div>
          </a>
        </div>
      <?php
      }
      ?>
      
       
    </div>
  </div>
</div>


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
      function searchRestaurants() {
    var searchInput = $(".search-input").val();

    $.ajax({
        type: "POST",
        url: "search_results.php",
        data: { searchInput: searchInput },
        dataType: "json",
        success: function (data) {
            // Handle success, update the search results section
            updateSearchResults(data);
        },
        error: function (error) {
            console.log("Error:", error);
        }
    });
}

function updateSearchResults(results) {
    var searchResultsDiv = $(".search-results");
    searchResultsDiv.empty(); // Clear previous results

    // Check if there are any results
    if (results.length > 0) {
        // Create a row to hold all search results
        var resultHtml = '<div class="row">';

        // Display each result in the search results section
        $.each(results, function (index, result) {
            resultHtml += `
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom">
                    <a href="rest_view.php?id=${result.id}">
                        <div class="blog_box">
                            <div class="blog_img_box">
                                <figure><img src="admin/${result.image}" style="width: 348.66px; height: 348.66px;" alt="#" /></figure>
                            </div>
                            <h3>${result.name}</h3>
                            <p class="label">Address:</p>
                            <p>${result.address}</p>
                            <p class="label">Contact:</p>
                            <p>${result.phone}</p>
                            <p class="label">Place:</p>
                            <p>${result.place}</p>
                        </div>
                    </a>
                </div>
            `;
        });

        resultHtml += '</div>'; // Close the row

        // Append the heading and the row to the search results section
        searchResultsDiv.append('<h3>Search Results:</h3>');
        searchResultsDiv.append(resultHtml);
    } else {
        // Display a message when no results are found
        searchResultsDiv.html('<p class="no-results-message">No results found.</p>');
    }

    // Show the search results section
    searchResultsDiv.show();
}


    </script>

</body>

</html>