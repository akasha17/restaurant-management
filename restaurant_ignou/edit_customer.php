<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "restaurant");

$customerid = $_GET['customerid']; // Get customerid from the URL

// Fetch user details using a prepared statement
$sel_query = "SELECT * FROM customer WHERE customerid = ?";
$stmt = mysqli_prepare($con, $sel_query);

// Bind the parameter
mysqli_stmt_bind_param($stmt, "i", $customerid);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Fetch the user details
$row = mysqli_fetch_assoc($result);

// Check if the form has been submitted for an update
if (isset($_POST['submit'])) {
    // Get updated values from the form
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Update the user details using a prepared statement
    $update_query = "UPDATE customer SET fname = ?, lname = ?, email = ?, phone = ?, address = ?, password = ? WHERE customerid = ?";
    $update_stmt = mysqli_prepare($con, $update_query);

    // Bind the parameters
    mysqli_stmt_bind_param($update_stmt, "ssssssi", $fname, $lname, $email, $contact, $address, $password, $customerid);

    // Execute the update query
    if (mysqli_stmt_execute($update_stmt)) {
        // Redirect to profile page with success alert
        echo "<script>
                alert('Profile updated successfully');
                window.location.href = 'profile_with_paid.php'; // Change this to your profile page URL
              </script>";
    } else {
        echo "<script>alert('Failed to update profile');</script>";
    }

    // Close the update statement
    mysqli_stmt_close($update_stmt);
}

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
    <title>Online Restaurant Management System </title>
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
    <style type="text/css">
        .container {
    text-align: center;
}

.payment-form {
    width: 70%;
    margin: 0 auto;
}

.section {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
}

.order-details {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

.payment-form h2 {
    font-size: 24px;
}

.payment-form .form-group {
    margin-bottom: 20px;
}

.submit-button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.submit-button:hover {
    background-color: #45a049;
}

/* Container styles */
.container {
    text-align: center;
}

/* Form section styles */
.section {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
}

.section-title {
    font-size: 24px;
    margin-bottom: 10px;
}

/* Form field styles */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}



/* Submit button styles */
.submit-button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.submit-button:hover {
    background-color: #45a049;
}


    </style>
  
</head>

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
                    <h2>Profile</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container" style="margin-top:100px;">
   <form id="payment-form" method="POST" class="payment-form">
    <h2 class="section-title">Profile Edit</h2>
    <input type="hidden" name="new" value="1" />
    <input name="customerid" type="hidden" value="<?php echo $row['customerid']; ?>" />
    <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" value="<?php echo $row['fname']; ?>" required>
    </div>
    <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" value="<?php echo $row['lname']; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
    </div>
    <div class="form-group">
        <label for="contact">Contact</label>
        <input type="text" id="contact" name="contact" value="<?php echo $row['phone']; ?>" required>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="text" id="password" name="password" value="<?php echo $row['password']; ?>" required>
    </div>
    <button type="submit" name="submit" class="submit-button">Update</button>
</form>

</div>

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
</body>

</html>
