<?php
session_start();

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "restaurant");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the feedback form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve feedback text from the form
    $feedbackText = $_POST['feedback-text'];

    // Retrieve the restaurant ID from the form (passed as a hidden input)
    $restaurantId = isset($_POST['restaurant_id']) ? $_POST['restaurant_id'] : null;

    // Retrieve the customer ID from session (assuming it is stored in session)
    $customerId = isset($_SESSION['order_details']['user_id']) ? $_SESSION['order_details']['user_id'] : null;

    // Validate that restaurant ID, customer ID, and feedback text are available
    if ($restaurantId && $customerId && !empty($feedbackText)) {
        // Prepare the SQL statement to insert the feedback into the 'review' table
        $insertFeedbackQuery = "INSERT INTO review (sid, customer_id, description) VALUES (?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($con, $insertFeedbackQuery);
        mysqli_stmt_bind_param($stmt, "iis", $restaurantId, $customerId, $feedbackText);

        // Execute the statement and check if the feedback was inserted successfully
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Thank you for your feedback!'); window.location.href = 'success.php?restaurant_id={$restaurantId}&restaurant_name=" . urlencode($_GET['restaurant_name']) . "';</script>";
        } else {
            echo "<script>alert('Feedback submission failed. Please try again.'); history.back();</script>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('All fields are required.'); history.back();</script>";
    }
}

// Close the database connection
mysqli_close($con);
?>
