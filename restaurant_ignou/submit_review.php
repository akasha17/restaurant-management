<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $restaurant_id = $_POST['restaurant_id'];
        $customer_id = $_POST['customer_id'];
        $review = $_POST['review'];

        $query = "INSERT INTO review (sid, customer_id, description) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iis", $restaurant_id, $customer_id, $review);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Thank you for your review!');</script>";
            echo "<script>window.location.href='restaurants_view.php';</script>"; // Redirect back to the restaurants page
        } else {
            echo "Error: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('You need to be logged in to submit a review.');</script>";
        echo "<script>window.location.href='login.php';</script>"; // Redirect to the login page
    }

    mysqli_close($con);
}
?>
