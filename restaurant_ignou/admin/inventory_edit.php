<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$item_id = $_REQUEST['id']; // Should be item_id, not id

// Join query to fetch item details and restaurant name
$query = "SELECT i.item_id, i.item_name, i.quantity, i.record_threshold, r.name 
          FROM inventory i 
          JOIN restaurants r ON i.restaurant_id = r.id 
          WHERE i.item_id='".$item_id."'"; 
$result = mysqli_query($con, $query) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($result);
?>   
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant Management Admin</title>

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
</head>
<body>
<?php
$status = "";
if(isset($_POST['new']) && $_POST['new'] == 1) {
    $item_id = $_REQUEST['id']; // Should be item_id, not id
    $quantity = $_REQUEST['quantity'];
    $record_threshold = $_REQUEST['record_threshold'];

    $update = "UPDATE inventory SET quantity='".$quantity."', record_threshold='".$record_threshold."' WHERE item_id='".$item_id."'";
    mysqli_query($con, $update) or die(mysqli_error($con));
    $status = "Record Updated Successfully. </br></br>
    <a href='inventory_management.php'>View Updated Record</a>";
    echo '<p style="color:#FF0000;">'.$status.'</p>';
} else {
?> <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php">Administration</a>
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
                <h4 style="text-align: center;"> Welcome, <?php echo $_SESSION['username']; ?></h4>
                <br />
            </div>
        </div>
    </li>
    <li>
        <a href="profile.php"><i class="fa fa-user"></i> Profile</a>
    </li>
    <li>
        <a class="active-menu" href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
    </li>
    <li>
        <a href="#"><i class="fa fa-desktop"></i> Menu Items </a>
        <ul class="nav nav-second-level">
            <li>
                <a href="add_menu_items.php"><i class="fa fa-plus"></i> Add Menu Items</a>
            </li>
            <li>
                <a href="menu_items_display.php"><i class="fa fa-eye"></i> View Menu Items</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#"><i class="fa fa-cutlery"></i> Restaurants</a>
        <ul class="nav nav-second-level">
            <li>
                <a href="add_restaurants.php"><i class="fa fa-coffee"></i> Add Restaurants</a>
            </li>
            <li>
                <a href="view_restaurants.php"><i class="fa fa-list"></i> View Restaurants</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#"><i class="fa fa-archive"></i> Inventory </a>
        <ul class="nav nav-second-level">
            <li>
                <a href="add_inventory.php"><i class="fa fa-plus"></i> Add Inventory</a>
            </li>
            <li>
                <a href="inventory_management.php"><i class="fa fa-eye"></i> View Inventory</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="customer_display.php"><i class="fa fa-users"></i> View Customers</a>
    </li>
    <li>
        <a href="view_staff.php"><i class="fa fa-users"></i> View Staffs</a>
    </li>
    <li>
        <a href="view_orders.php"><i class="fa fa-shopping-cart"></i> View Orders</a>
    </li>
    <li>
        <a href="view_payments.php"><i class="fa fa-money"></i> View Payments</a>
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
                        <h1 class="page-head-line">EDIT INVENTORY DETAILS</h1>
                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                                <div style="justify-content: center;" class="panel panel-danger">
                                    <div class="panel-heading">
                                        INVENTORY ITEMS
                                    </div>
                                    <div class="panel-body">
                                       <form method="post" role="form">
    <input type="hidden" name="new" value="1" />
    <input name="id" type="hidden" value="<?php echo $row['item_id']; ?>" />
    <div class="form-group">
        <label>Item Name</label>
        <input class="form-control" name="item_name" type="text" value="<?php echo $row['item_name']; ?>" readonly>
    </div>
    <div class="form-group">
        <label>Restaurant Name</label>
        <input class="form-control" name="restaurant_name" type="text" value="<?php echo $row['name']; ?>" readonly>
    </div>
    <div class="form-group">
        <label>Quantity</label>
        <input class="form-control" name="quantity" type="text" value="<?php echo $row['quantity']; ?>">
    </div>
    <div class="form-group">
        <label>Record Threshold</label>
        <input class="form-control" name="record_threshold" type="text" value="<?php echo $row['record_threshold']; ?>">
    </div>
    <button type="submit" name="submit" class="btn btn-danger">Update</button>
</form>
<?php } ?>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
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
