<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are empty
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password.');</script>";
    } else {
        $sql2 = "SELECT * FROM customer WHERE email='" . $email . "'";
        $res2 = mysqli_query($con, $sql2);
        $array3 = mysqli_fetch_array($res2);

        // Check if email exists
        if ($array3) {
            // Check if password is correct
            if ($array3['password'] === $password) {
                $_SESSION['user_id'] = $array3['customerid'];
                $_SESSION['user_name'] = $array3['fname'];
                header("location:index.php");
            } else {
                echo "<script>alert('Password is incorrect.');</script>";
            }
        } else {
            // Both email and password are incorrect
            echo "<script>alert('Entered email and password do not match.');</script>";
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
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <style>
    .highlight-section {
         /* Use your desired highlight color */
        padding: 10px; /* Add some padding for better visibility */
        border-radius: 5px; /* Optional: add rounded corners */
    }

    .highlight-section a {
        /* Optional: Style the link within the highlighted section */
        color: #333; /* Use your desired link color */
        font-weight: bold; /* Optional: Make the link bold */
    }
</style>

</head>
<!-- body -->

<body class="main-layout Contact_page">
 <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="" /></div>
    </div>

    <div class="wrapper">
    <!-- end loader -->

     

    <div id="content">
    <!-- header -->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- <div class="full">
                        <a class="logo" href="index.html"><img src="images/logo.png" alt="#" /></a>
                    </div> -->
                </div>
                <div class="col-md-9">
                    <div class="full">
                       
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- end header -->
    <!-- footer -->
    <fooetr>
        <div class="footer">
            <div class="container-fluid">
                <div class="row" style="margin-left: 180px;">
                  <div class=" col-md-12">
                     <h3 style="padding: 10px; border-radius: 5px; margin-top: 40px;">WELCOME...</h3><br>
                    <h2 style="margin-top: -80px; margin-left: 60px;">Sign In</h2>
                  </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                      
                        <form method="post" class="main_form">
                            <div class="row">
                             
                                
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <input class="form-control" placeholder="Email" type="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address" required />
                                </div>
                                
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <input class="form-control" placeholder="Password" type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, and one digit" required />
                                </div>
                              
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <button class="send" type="submit" name="submit">Submit</button>
                                </div>
                                <br>
                                <div class="col-md-12  highlight-section">
                                    <p>Don't have an account? <a href="sign up.php">Sign Up</a></p>
                                </div>
                            </div>
                        </form>
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

</body>

</html>