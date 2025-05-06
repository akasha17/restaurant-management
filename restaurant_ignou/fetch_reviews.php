<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_GET['restaurant_id'])) {
    $restaurant_id = $_GET['restaurant_id'];

    $query = "SELECT review.description, customer.fname, customer.lname 
              FROM review 
              JOIN customer ON review.customer_id = customer.customerid 
              WHERE review.sid = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $restaurant_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $description, $first_name, $last_name);

    $reviews = [];
    while (mysqli_stmt_fetch($stmt)) {
        $reviews[] = ['description' => $description, 'fname' => $first_name, 'lname' => $last_name];
    }
    mysqli_stmt_close($stmt);

    if (count($reviews) > 0) {
        foreach ($reviews as $review) {
            echo "<div class='review'>";
            echo "<p><strong>" . htmlspecialchars($review['fname'] . ' ' . $review['lname']) . ":</strong> " . htmlspecialchars($review['description']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No reviews yet.</p>";
    }

    mysqli_close($con);
}
?>
