<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");
 

if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
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
     <script>
        function showRemoveForm(itemId, restaurants) {
            const removeForm = document.getElementById('removeForm');
            const restaurantList = document.getElementById('restaurantList');
            const menuIdInput = document.getElementById('menuId');

            // Clear previous options
            restaurantList.innerHTML = '';

            // Populate restaurant options
            restaurants.split(', ').forEach(restaurant => {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'restaurants[]';
                checkbox.value = restaurant;
                checkbox.id = `restaurant_${restaurant}`;

                const label = document.createElement('label');
                label.htmlFor = `restaurant_${restaurant}`;
                label.innerText = restaurant;

                const br = document.createElement('br');

                restaurantList.appendChild(checkbox);
                restaurantList.appendChild(label);
                restaurantList.appendChild(br);
            });

            // Set the menu item id
            menuIdInput.value = itemId;

            // Show the form
            removeForm.style.display = 'block';
        }
    </script>
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
                <a href="add_menu_items.php"><i class="fa fa-plus"></i> Add Menu Items</a>
            </li>
            <li>
                <a class="active-menu" href="menu_items_display.php"><i class="fa fa-eye"></i> View Menu Items</a>
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
                        <h1 class="page-head-line">VIEW FOOD ITEMS</h1>
                        

                    </div>
                </div>
                <!-- /. ROW  -->
              
            <div class="row">
                <!-- <div class="col-md-6">
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Kitchen Sink
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     
                </div> -->
                <div class="col-md-12">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         FOOD ITEMS
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                              <table class="table">
        <thead>
            <tr>
                <th>Item Id</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Description</th>
                <th>Item Image</th>
                <th>Available In Restaurants</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sel_query = "
                SELECT 
                    menu.*, 
                    GROUP_CONCAT(restaurants.name SEPARATOR ', ') AS restaurant_names 
                FROM 
                    menu 
                LEFT JOIN 
                    restaurant_menu ON menu.item_id = restaurant_menu.menu_id 
                LEFT JOIN 
                    restaurants ON restaurant_menu.restaurant_id = restaurants.id 
                GROUP BY 
                    menu.item_id 
                ORDER BY 
                    menu.item_id DESC;
            ";
            $result = mysqli_query($con, $sel_query);
            while ($row = mysqli_fetch_assoc($result)) { 
                $file_path = $row['image']; // Adjust the path according to your folder structure
            ?>
            <tr>
                <td align="center"><?php echo $count; ?></td>
                <td align="center"><?php echo $row["name"]; ?></td>
                <td align="center"><?php echo $row["price"]; ?></td>
                <td align="center"><?php echo $row["category"]; ?></td>
                <td align="center"><?php echo $row["description"]; ?></td>
                <td align="center">
                    <img src="<?php echo $file_path; ?>" alt="<?php echo $row['name']; ?>" style="width: 100px; height: auto;">
                </td>
                <td align="center"><?php echo $row["restaurant_names"]; ?></td>
                <td align="center">
                    <a href="menu_edit.php?item_id=<?php echo $row['item_id']; ?>">Edit</a>
                </td>
                <td align="center">
                    <a href="menu_del.php?item_id=<?php echo $row['item_id']; ?>">Delete</a>
                </td>
                <td align="center">
                    <button type="button" onclick="showRemoveForm(<?php echo $row['item_id']; ?>, '<?php echo $row['restaurant_names']; ?>')">Remove</button>
                </td>
            </tr>
            <?php $count++; } ?>
        </tbody>
    </table>
    <div id="removeForm" style="display:none;">
        <h3>Remove Restaurants for Menu Item</h3>
        <form action="remove_restaurants.php" method="post">
            <input type="hidden" name="menu_id" id="menuId" value="">
            <div id="restaurantList"></div>
            <button type="submit" name="remove">Remove</button>
        </form>
    </div>

                            </div>
                        </div>
                    </div>
                      <!-- End  Basic Table  -->
                </div>
            </div>
                <!-- /. ROW  -->
            <!-- <div class="row">
                <div class="col-md-6">
                     
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Striped Rows Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Bordered Table
                        </div>
                      
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     
                </div>
            </div> -->
               
            <!-- <div class="row">
                <div class="col-md-6">
                     
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Hover Rows
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    
                    <div class="panel panel-default">
                       
                        <div class="panel-heading">
                            Context Classes
                        </div>
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="success">
                                            <td>1</td>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr class="info">
                                            <td>2</td>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr class="warning">
                                            <td>3</td>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                        <tr class="danger">
                                            <td>4</td>
                                            <td>John</td>
                                            <td>Smith</td>
                                            <td>@jsmith</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div> -->
                <!-- /. ROW  -->

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
