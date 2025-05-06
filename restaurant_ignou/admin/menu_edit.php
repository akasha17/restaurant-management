<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$item_id = $_REQUEST['item_id'];
$query = "SELECT * from menu where item_id='" . $item_id . "'";
$result = mysqli_query($con, $query) or die(mysqli_error($con));
$row = mysqli_fetch_assoc($result);

$status = "";
if (isset($_POST['new']) && $_POST['new'] == 1) {
    $item_id = $_REQUEST['item_id'];
    $name = $_REQUEST['foodname'];
    $foodprice = $_REQUEST['foodprice'];
    $category = $_REQUEST['category'];
    $description = $_REQUEST['description'];

    // Handle the image update only if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_path = "adminuploads/" . $file_name;

        // Upload the new image
        if (is_uploaded_file($file_tmp) && move_uploaded_file($file_tmp, $file_path)) {
            $image_update_query = ", image='$file_path'";
        }
    } else {
        // If no new image, keep the old image
        $image_update_query = "";
    }

    // Update the database with or without the image update
    $update = "UPDATE menu SET name='$name', price='$foodprice', category='$category', description='$description' $image_update_query WHERE item_id='$item_id'";
    mysqli_query($con, $update) or die(mysqli_error($con));

    // Display JavaScript alert and redirect
    echo '<script type="text/javascript">
            alert("Record Updated Successfully.");
            window.location.href = "menu_items_display.php";
          </script>';
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
        <a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
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
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">EDIT FOOD ITEM DETAILS</h1>
                       

                    </div>
                </div>
               
                 <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div style="justify-content: center;" class="panel panel-danger">
                    <div class="panel-heading">
                        FOOD ITEMS
                    </div>
                    <div class="panel-body">
                        <form method="post" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="new" value="1" />
                            <input name="item_id" type="hidden" value="<?php echo $row['item_id']; ?>" />
                            <div class="form-group">
                                <label>Food Name</label>
                                <input class="form-control" name="foodname" type="text" value="<?php echo $row['name']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Food Price</label>
                                <input class="form-control" name="foodprice" type="text" value="<?php echo $row['price']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <input class="form-control" name="category" type="text" value="<?php echo $row['category']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input class="form-control" name="description" type="text" value="<?php echo $row['description']; ?>">
                            </div>
                            <div class="form-group">
    <label>Current Image</label><br>
    <?php if (!empty($row['image'])) { ?>
        <img src="<?php echo $row['image']; ?>" width="150px"><br><br>
    <?php } else { ?>
        <p>No image available</p>
    <?php } ?>
</div>

<div class="form-group">
    <label>
        <input type="checkbox" id="updateImageCheck" onclick="toggleImageUpdate()"> Do you want to update the image?
    </label>
</div>

<div class="form-group" id="updateImageField" style="display: none;">
    <label>Update Image</label>
    <input class="form-control" name="image" type="file">
</div>




                            <button type="submit" name="submit" class="btn btn-danger">Update</button>
                        </form>
                        <?php  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    <script>
    function toggleImageUpdate() {
        var checkBox = document.getElementById("updateImageCheck");
        var updateImageField = document.getElementById("updateImageField");
        if (checkBox.checked == true) {
            updateImageField.style.display = "block";
        } else {
            updateImageField.style.display = "none";
        }
    }
</script>


</body>
</html>
