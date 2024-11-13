<?php
// Include the database connection
include "../server/connection.php";

// Check if the request_id is passed in the URL
if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Update the has_reached field to 1 for the selected request
    $updateQuery = "UPDATE scrap_requests SET has_reached = 1 WHERE request_id = " . intval($request_id);

    if (mysqli_query($conn, $updateQuery)) {
        // Redirect back to the buy page after updating
        header("Location: ../Vendor/buy.php"); // Adjust the redirect URL if needed
        exit();
    } else {
        // Handle the error if the update fails
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // If request_id is not provided, redirect back or show an error
    echo "Request ID not found!";
}

// Close the database connection
mysqli_close($conn);
?>
