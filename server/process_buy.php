<?php
// Include the database connection file
include "connection.php";

// Get the request_id and vendor_id from the URL parameters
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$vendor_id = isset($_GET['vendor_id']) ? intval($_GET['vendor_id']) : 0;

echo $request_id;
echo $vendor_id;

// Check if the request_id and vendor_id are valid
if ($request_id > 0 && $vendor_id > 0) {
    // Update the scrap_requests table to set the request status to active and assign the vendor
    $query = "UPDATE scrap_requests 
              SET status = 'ongoing', vendor_id = $vendor_id 
              WHERE request_id = $request_id AND status = 'active'"; // Only update ongoing requests

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "Request accepted successfully.";
        // Optionally, redirect back to the previous page or a success page
        header("Location: ../Vendor/buy.php");
        exit();
    } else {
        echo "Error accepting the request: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request or vendor.";
}

// Close the database connection
mysqli_close($conn);
?>
