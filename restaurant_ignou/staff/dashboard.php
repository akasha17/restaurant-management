<?php 
  session_start();
  $con = mysqli_connect("localhost","root","","restaurant");
  if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant Management Staff</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="assets/css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php">Staff</a>
            </div>

           <div class="header-right">
    <a href="profile.php" class="btn btn-info" title="Profile">
        <i class="fa fa-user-circle fa-2x"></i>
        Profile
    </a>
    <a href="logout.php" class="btn btn-danger" title="Logout">
        <i class="fa fa-exclamation-circle fa-2x"></i>
        Logout
    </a>
</div>


        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
    <li>
        <div class="user-img-div">
            <div class="inner-text">
                <h4 style="text-align: center;"> Welcome, <?php echo $_SESSION['staff_name']; ?></h4>
                <br />
            </div>
        </div>
    </li>

                    <li>
                        <a class="active-menu" href="dashboard.php"><i class="fa fa-dashboard "></i>Dashboard</a>
                    </li>
                   
                    
                     <li>
    <a href="profile.php"><i class="fa fa-user"></i> Profile</a>
</li>
<li>
    <a href="menu_items_display.php"><i class="fa fa-utensils"></i> Menu Items</a>
</li>
<li>
    <a href="view_restaurants.php"><i class="fa fa-store"></i> Restaurants</a>
</li>
<li>
    <a href="inventory_display.php"><i class="fa fa-boxes"></i> Inventory</a>
</li>
<li>
    <a href="my_order.php"><i class="fa fa-receipt"></i> View My Orders</a>
</li>
<li>
    <a href="view_orders.php"><i class="fa fa-receipt"></i> View Orders</a>
</li>
<li>
    <a href="view_payments.php"><i class="fa fa-credit-card"></i> View Payments</a>
</li>
<li>
    <a href="view_reviews.php"><i class="fa fa-comments"></i> View Reviews</a>
</li>

                </ul>

            </div>

        </nav>
           <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">STAFF DASHBOARD</h1>
                       

                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="main-box mb-red">
                            <a href="menu_items_display.php">
                                <i class="fa fa-utensils fa-5x"></i>
                                <h5>Menu Items</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="main-box mb-dull">
                            <a href="inventory_display.php">
                                <i class="fa fa-archive fa-5x"></i>
                                <h5>Inventory</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="main-box mb-pink">
                            <a href="view_restaurants.php">
                                <i class="fa fa-store-alt fa-5x"></i>
                                <h5>Restaurants</h5>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

   
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    


</body>
</html>
