<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

$staffid = $_GET['staffid']; // Get adminid from the URL

// Fetch user details using a prepared statement
$sel_query = "SELECT * FROM staff WHERE staffid = ?";
$stmt = mysqli_prepare($con, $sel_query);

// Bind the parameter
mysqli_stmt_bind_param($stmt, "i", $staffid);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Fetch the user details
$row = mysqli_fetch_assoc($result);

// Close the statement
mysqli_stmt_close($stmt);
?>

<!-- The rest of your HTML and form -->
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
    <?php
    $status = "";
    if(isset($_POST['new']) && $_POST['new']==1)
    {
        $staffid=$_REQUEST['staffid'];
        $fname=$_REQUEST['fname'];
        $lname=$_REQUEST['lname'];
        $email=$_REQUEST['email'];
        $phone=$_REQUEST['phone'];
        $role=$_REQUEST['role'];
        $password = $_REQUEST['password'];

       $update = "UPDATE staff SET fname=?, lname=?, email=?, phone=?, staff_position=?, password=? WHERE staffid=?";
$stmt = mysqli_prepare($con, $update);

// Bind parameters
mysqli_stmt_bind_param($stmt, "sssissi", $fname, $lname, $email, $phone, $role, $password, $staffid);

// Execute the update statement
mysqli_stmt_execute($stmt);

// Check for success
if (mysqli_stmt_affected_rows($stmt) > 0) {
    $status = "Record Updated Successfully. </br></br><a href='profile.php'>View Updated Record</a>";
    echo '<p style="color:#FF0000;">' . $status . '</p>';
} else {
    echo '<p style="color:#FF0000;">Error updating record: ' . mysqli_error($con) . '</p>';
}

// Close the statement
mysqli_stmt_close($stmt);
    }
    ?>
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
                        <a href="dashboard.php"><i class="fa fa-dashboard "></i>Dashboard</a>
                    </li>
                   
                    
                      <li>
    <a class="active-menu" href="profile.php"><i class="fa fa-user"></i> Profile</a>
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
    <a  href="my_order.php"><i class="fa fa-receipt"></i> View My Orders</a>
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
           
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Profile Edit Page</h1>
                        <!-- <h1 class="page-subhead-line">This is dummy text , you can replace it with your original text. </h1> -->

                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
        
<div class="col-md-6 col-sm-6 col-xs-12">
               <div style="justify-content: center;" class="panel panel-danger">
                        <div class="panel-heading">
                           Profile
                        </div>
                        <div class="panel-body">
                            <form method="post" role="form" >
                                <input type="hidden" name="new" value="1" />
                                            <input name="staffid" type="hidden" value="<?php echo $row['staffid'];?>" />
                                        
                                 <div class="form-group">
                                            <label>First Name</label>
                                            <input class="form-control" name="fname"type="text"value="<?php echo $row['fname'];?>">
                                     
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" name="lname"type="text"value="<?php echo $row['lname'];?>">
                                     
                                        </div>
                                            <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control"name="email" type="email"value="<?php echo $row['email'];?>">
                                     
                                        </div>
                                <div class="form-group">
                                            <label>Phone No.</label>
                                            <input class="form-control"name="phone" type="text"value="<?php echo $row['phone'];?>">
                                    
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <input class="form-control"name="role" type="text"value="<?php echo $row['staff_position'];?>">
                                     
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control"name="password" type="text"value="<?php echo $row['password'];?>">
                                     
                                        </div>
                                 
                                        <button type="submit" name="submit" class="btn btn-danger">Update </button>

                                    </form>
                            </div>
                        </div>
                            </div>
        </div>
            
        </div>

            </div>
           
        </div>
        
    </div> -->
    <!-- /. WRAPPER  -->
    <!-- <div id="footer-sec"> -->
        <!-- &copy; 2014 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a> -->
    <!-- </div> -->
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME--> -->
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
