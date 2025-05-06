<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

if (isset($_POST['submit'])) {
    $itemid = $_POST['itemid']; // The selected item ID
    $restaurantname = $_POST['restaurantname'];
    $qnty = $_POST['qnty'];
    $record = $_POST['record'];

    // Fetch the item name based on the selected item ID
    $fetchItemNameQuery = "SELECT name FROM menu WHERE item_id='$itemid'";
    $itemResult = mysqli_query($con, $fetchItemNameQuery);
    $itemRow = mysqli_fetch_assoc($itemResult);
    $itemname = $itemRow['name']; // Now you have the correct item name

    // Insert the item into the inventory table
    $q = "INSERT INTO inventory (item_id, item_name, quantity, record_threshold, restaurant_id) VALUES ('$itemid', '$itemname', '$qnty', '$record', '$restaurantname')";

    $result = mysqli_query($con, $q);

    if ($result) {
        echo "<script>alert('Added successfully!!')</script>";
    } else {
        echo "<script>alert('Not Added!!')</script>";
    }
}
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
     <div id="wrapper">
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
        <a  href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
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
        <a class="active-menu" href="#"><i class="fa fa-archive"></i> Inventory </a>
        <ul class="nav nav-second-level">
            <li>
                <a class="active-menu" href="add_inventory.php"><i class="fa fa-plus"></i> Add Inventory</a>
            </li>
            <li>
                <a  href="inventory_management.php"><i class="fa fa-eye"></i> View Inventory</a>
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
    <div id="wrapper">
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">ADD INVENTORY DETAILS</h1>
                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div style="justify-content: center;" class="panel panel-danger">
                            <div class="panel-heading">
                                INVENTORY
                            </div>
                            <div class="panel-body">
                              <form method="post" role="form">
    <div class="form-group">
        <label>Item name</label>
        <select class="form-control" name="itemname" id="itemname">
            <?php
            $menuQuery = "SELECT item_id, name FROM menu";
            $menuResult = mysqli_query($con, $menuQuery);
            if (mysqli_num_rows($menuResult) > 0) {
                while ($menuItem = mysqli_fetch_assoc($menuResult)) {
                    $itemName = htmlspecialchars($menuItem['name']);
                    $itemId = htmlspecialchars($menuItem['item_id']);
                    echo "<option data-itemid='$itemId' value='$itemId'>$itemName</option>";
                }
            } else {
                echo '<option value="" disabled>No items available</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Restaurant name</label>
        <select class="form-control" name="restaurantname" id="restaurantname">
            <?php
            $restaurantQuery = "SELECT id, name FROM restaurants";
            $restaurantResult = mysqli_query($con, $restaurantQuery);
            if (mysqli_num_rows($restaurantResult) > 0) {
                while ($restaurant = mysqli_fetch_assoc($restaurantResult)) {
                    $restaurantName = htmlspecialchars($restaurant['name']);
                    $restaurantId = htmlspecialchars($restaurant['id']);
                    echo "<option data-restaurantid='$restaurantId' value='$restaurantId'>$restaurantName</option>";
                }
            } else {
                echo '<option value="" disabled>No restaurants available</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Quantity</label>
        <input class="form-control" name="qnty" type="text">
    </div>
    <div class="form-group">
        <label>Record Threshold</label>
        <input class="form-control" name="record" type="text">
    </div>
    <!-- Hidden item ID field -->
    <input type="hidden" name="itemid" id="itemid" value="">
    <!-- Hidden restaurant ID field -->
    <input type="hidden" name="restaurantid" id="restaurantid" value="">
    <button type="submit" name="submit" class="btn btn-danger">Add</button>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    // Update the hidden field when an item is selected
    $(document).ready(function () {
        $('#itemname').change(function () {
            $('#itemid').val($(this).find(':selected').data('itemid'));
        });

        // Prevent form submission on Enter key press
        $('#itemname, #qnty, #record').keydown(function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
        });
    });
</script>

    

</body>
</html>
