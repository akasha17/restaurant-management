<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");
 

if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// Assuming $logged_in_staff_id contains the currently logged-in staff ID
$logged_in_staff_id = $_SESSION['staff_id']; // or however you get the logged-in staff ID

// SQL query to get order details assigned to the logged-in staff
$query = "
    SELECT 
        o.orderid,
        o.customer_id,
        o.item_id,
        o.order_date,
        o.order_time,
        o.quantity,
        o.total,
        o.payment_status,
        c.fname AS customer_fname,
        c.lname AS customer_lname,
        c.address AS customer_address,
        m.name,
        p.paid_date
    FROM orders o
    JOIN customer c ON o.customer_id = c.customerid
    JOIN menu m ON o.item_id = m.item_id
    LEFT JOIN payment p ON o.orderid = p.customer_id
    WHERE o.assigned_staff_id = ?
";
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
                        <a href="dashboard.php"><i class="fa fa-dashboard "></i>Dashboard</a>
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
    <a class="active-menu" href="my_order.php"><i class="fa fa-receipt"></i> View My Orders</a>
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
                        <h1 class="page-head-line">View My Orders</h1>
                        

                    </div>
                </div>
                <!-- /. ROW  -->
              
            <div class="row">
               
                <div class="col-md-12">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         My Orders
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <?php
                                if ($stmt = mysqli_prepare($con, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $logged_in_staff_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table">
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Order Date</th>
                        <th>Order Time</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                      
                    </tr>
                </thead>
                <tbody>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td align="center">' . $row["orderid"] . '</td>
                    <td align="center">' . $row["customer_fname"] . ' ' . $row["customer_lname"] . '</td>
                    <td align="center">' . $row["customer_address"] . '</td>
                    <td align="center">' . $row["order_date"] . '</td>
                    <td align="center">' . $row["order_time"] . '</td>
                    <td align="center">' . $row["name"] . '</td>
                    <td align="center">' . $row["quantity"] . '</td>
                    <td align="center">' . $row["total"] . '</td>
                    <td align="center">' . $row["payment_status"] . '</td>
                   
                  </tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<p>No orders found for the current staff member.</p>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo '<p>Error preparing statement: ' . mysqli_error($con) . '</p>';
}
?>
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
