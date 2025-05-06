<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "restaurant");

if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_POST['searchInput'])) {
    $search = mysqli_real_escape_string($con, $_POST['searchInput']);
    $query = "SELECT * FROM restaurants WHERE name LIKE '%$search%' OR place LIKE '%$search%' OR address LIKE '%$search%'";
    $result = mysqli_query($con, $query);

    // Fetch and return results as JSON
    $resultsArray = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $resultsArray[] = $row;
    }
    echo json_encode($resultsArray);
}
?>
