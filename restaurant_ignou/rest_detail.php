<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details</title>
    <!-- Add your CSS styles and scripts here -->
</head>
<body>

<?php
// ... your database connection code ...

if (isset($_GET['id'])) {
    $restaurant_id = $_GET['id'];

    // Retrieve restaurant details
    $query = "SELECT * FROM restaurants WHERE id = '$restaurant_id'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
?>

    <div class="container">
        <h2><?php echo $row['name']; ?> Details</h2>
        <p>Address: <?php echo $row['address']; ?></p>
        <p>Contact: <?php echo $row['phone']; ?></p>
        <p>Place: <?php echo $row['place']; ?></p>
    </div>

    <div class="container">
        <h2>Menu Items</h2>
        <div class="row">
            <?php
            // Retrieve menu items for the restaurant
            $menu_query = "SELECT * FROM menu
                           JOIN restaurant_menu ON menu.item_id = restaurant_menu.menu_id
                           WHERE restaurant_menu.restaurant_id = '$restaurant_id'";
            $menu_result = mysqli_query($con, $menu_query);

            while ($menu_row = mysqli_fetch_assoc($menu_result)) {
            ?>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom">
                    <div class="blog_box">
                        <div class="blog_img_box">
                            <figure><img src="<?php echo $menu_row['image']; ?>" style="width: 348.66px; height: 348.66px;" alt="#"/></figure>
                        </div>
                        <h3><?php echo $menu_row['name']; ?></h3>
                        <p>Price: <?php echo $menu_row['price']; ?></p>
                        <p>Category: <?php echo $menu_row['category']; ?></p>
                        <p>Description: <?php echo $menu_row['description']; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

<?php
    } else {
        echo "<p>Restaurant not found</p>";
    }
}

// ... rest of your code ...
?>

</body>
</html>
