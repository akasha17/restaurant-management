<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");
 

if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
    $menu_id = $_POST['menu_id'];
    $restaurants = $_POST['restaurants']; // Array of restaurant names

    if (!empty($menu_id) && !empty($restaurants)) {
        // Convert restaurant names to restaurant IDs
        $restaurant_ids = [];
        foreach ($restaurants as $restaurant_name) {
            $query = "SELECT id FROM restaurants WHERE name = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "s", $restaurant_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $restaurant_ids[] = $row['id'];
            }
            mysqli_stmt_close($stmt);
        }

        // Remove selected restaurants for the given menu item
        foreach ($restaurant_ids as $restaurant_id) {
            $query = "DELETE FROM restaurant_menu WHERE menu_id = ? AND restaurant_id = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "ii", $menu_id, $restaurant_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        echo "<script>alert('Selected restaurants removed successfully.'); window.location.href = 'menu_items_display.php';</script>";
    } else {
        echo "<script>alert('Please select at least one restaurant to remove.'); window.history.back();</script>";
    }
}
?>
