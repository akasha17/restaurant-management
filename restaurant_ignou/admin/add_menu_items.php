<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");
$query = "SELECT id, name FROM restaurants";
$result = mysqli_query($con, $query);

// Check for query execution errors
if (!$result) {
    die("Error retrieving restaurants: " . mysqli_error($con));
}

if (isset($_POST['submit'])) {
    $selectedOption = $_POST['food_selection'];
    $foodname = "";
    $food_id = null;

    if ($selectedOption === 'add_new') {
        $foodname = $_POST['foodname'];
        $foodprice = $_POST['foodprice'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_path = "adminuploads/" . $file_name;

        if (is_uploaded_file($file_tmp) && move_uploaded_file($file_tmp, $file_path)) {
            // Insert the new food item into the menu table
            $q = "INSERT INTO menu(name, price, category, description, image) VALUES ('$foodname', '$foodprice', '$category', '$description', '$file_path')";
            $result = mysqli_query($con, $q);

            if ($result) {
                // Get the ID of the last inserted menu item
                $food_id = mysqli_insert_id($con);
            } else {
                die("Error uploading the image: " . mysqli_error($con));
            }
        }
    } else {
        // The user selected an existing food item
        $food_id = $selectedOption;
    }

    if ($food_id) {
        $selectedRestaurants = isset($_POST['rest']) ? $_POST['rest'] : array();

        // Delete existing associations from restaurant_menu table
        $deleteQuery = "DELETE FROM restaurant_menu WHERE menu_id = $food_id";
        $deleteResult = mysqli_query($con, $deleteQuery);
        if (!$deleteResult) {
            die("Error deleting existing associations: " . mysqli_error($con));
        }

        // Insert new associations into restaurant_menu table
        foreach ($selectedRestaurants as $restaurantId) {
            $insertQuery = "INSERT INTO restaurant_menu(restaurant_id, menu_id) VALUES ('$restaurantId', '$food_id')";
            $insertResult = mysqli_query($con, $insertQuery);
            if (!$insertResult) {
                die("Error inserting records into restaurant_menu: " . mysqli_error($con));
            }
        }

        echo "<script>alert('Added successfully!!')</script>";
    }
}
?>


<!-- Rest of your HTML code remains unchanged -->
    
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
        <a class="active-menu" href="#"><i class="fa fa-desktop"></i> Menu Items </a>
        <ul class="nav nav-second-level">
            <li>
                <a class="active-menu" href="add_menu_items.php"><i class="fa fa-plus"></i> Add Menu Items</a>
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
                        <h1 class="page-head-line">ADD FOOD ITEM DETAILS</h1>
                        <!-- <h1 class="page-subhead-line">This is dummy text , you can replace it with your original text. </h1> -->

                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
          <!--   <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="panel panel-info">
                        <div class="panel-heading">
                           BASIC FORM
                        </div>
                        <div class="panel-body">
                            <form role="form">
                                        <div class="form-group">
                                            <label>Enter Name</label>
                                            <input class="form-control" type="text">
                                            <p class="help-block">Help text here.</p>
                                        </div>
                                 <div class="form-group">
                                            <label>Enter Email</label>
                                            <input class="form-control" type="text">
                                     <p class="help-block">Help text here.</p>
                                        </div>
                                            <div class="form-group">
                                            <label>Text area</label>
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                  
                                 
                                        <button type="submit" class="btn btn-info">Send Message </button>

                                    </form>
                            </div>
                        </div>
                            </div> -->
<div class="col-md-6 col-sm-6 col-xs-12">
               <div style="justify-content: center;" class="panel panel-danger">
                        <div class="panel-heading">
                           FOOD ITEMS
                        </div>
                        <div class="panel-body">
                            <form method="post" role="form" enctype="multipart/form-data">
                                        
                                 <div class="form-group">
        <label>Select or Add Food</label>
        <select class="form-control" name="food_selection" id="food_selection">
            <option value="">Select Food</option>
            <?php
            $con = mysqli_connect("localhost", "root", "", "restaurant");
$mquery = "SELECT item_id, name FROM menu";
$mresult = mysqli_query($con, $mquery);
            while ($mrow = mysqli_fetch_assoc($mresult)) {
                $food_id = $mrow['item_id'];
                $food_name = $mrow['name'];
                echo "<option value='$food_id'>$food_name</option>";
            }
            ?>
            <option value="add_new">Add New Food</option>
        </select>
    </div>
    
    <!-- New food item fields (hidden by default) -->
    <div id="new_food_fields" style="display: none;">
        <div class="form-group">
            <label>Food Name</label>
            <input class="form-control" name="foodname" type="text">
        </div>
    </div>
                                  <div class="form-group">
                                            <label>food price</label>
                                            <input class="form-control"name="foodprice" type="text">
                                     
                                        </div>
                                <div class="form-group">
                                            <label>category</label>
                                            <input class="form-control"name="category" type="text">
                                    
                                        </div>
                                        <div class="form-group">
                                            <label>description</label>
                                            <input class="form-control"name="description" type="text">
                                     
                                        </div>
                                        <div class="form-group">
                                            <label>food image</label>
                                            <input class="form-control"name="image" type="file">
                                     
                                        </div>
                                       <div class="form-group">
    <label>Restaurants</label>
     <select class="form-control" name="rest[]" multiple>
            <?php
            // Populate the dropdown with the retrieved restaurant data
            while ($row = mysqli_fetch_assoc($result)) {
                $restaurantId = $row['id'];
                $restaurantName = $row['name'];
                echo "<option value='$restaurantId'>$restaurantName</option>";
            }
            ?>
        </select>
</div>

                                 
                                        <button type="submit" name="submit" class="btn btn-danger">Add </button>

                                    </form>
                            </div>
                        </div>
                            </div>
        </div>
          
        </div>

            </div>
           
        </div>
        <script>
    // Function to toggle display of new food item fields based on dropdown selection
    document.getElementById('food_selection').addEventListener('change', function() {
        var food_selection = this.value;
        var new_food_fields = document.getElementById('new_food_fields');
        var existing_food_fields = document.getElementById('existing_food_fields');
        
        if (food_selection === 'add_new') {
            new_food_fields.style.display = 'block';
            existing_food_fields.style.display = 'none';
        } else {
            new_food_fields.style.display = 'none';
            existing_food_fields.style.display = 'block';
        }
    });
</script>
    </div>
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
<script>
    // Function to toggle display of new food item fields based on dropdown selection
    document.getElementById('food_selection').addEventListener('change', function() {
        var food_selection = this.value;
        var new_food_fields = document.getElementById('new_food_fields');
        
        if (food_selection === 'add_new') {
            new_food_fields.style.display = 'block';
        } else {
            new_food_fields.style.display = 'none';
        }
    });
</script>


</body>
</html>
