<?php
// Database connection
include 'connection.php'; // Make sure to include your database connection file

// Get requestId and rating from the URL parameters
$requestId = isset($_GET['requestId']) ? $_GET['requestId'] : null;
$rating = isset($_GET['rating']) ? $_GET['rating'] : null;

// Check if requestId and rating are provided
if ($requestId && $rating !== null) {
    // Validate the rating
    if ($rating >= 1 && $rating <= 5) {
        // Get the vendor_id and user_id based on requestId from the scrap_requests table
        $query = "SELECT vendor_id, user_id FROM scrap_requests WHERE request_id = $requestId";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch vendor_id and user_id
            $row = mysqli_fetch_assoc($result);
            $vendorId = $row['vendor_id'];
            $userId = $row['user_id'];

            // Insert the review into the reviews table
            $reviewQuery = "INSERT INTO reviews (vendor_id, seller_id, rating) 
                            VALUES ($vendorId, $userId, $rating)";
            $reviewResult = mysqli_query($conn, $reviewQuery);

            if ($reviewResult) {
                // Redirect to the previous page or show success message
                echo "Review submitted successfully!";
                // Optionally, redirect to a different page
                header("Location: ../seller/dashboard.php"); // Replace with your desired redirect URL
                exit;
            } else {
                echo "Error submitting review: " . mysqli_error($conn);
            }
        } else {
            echo "Request not found.";
        }
    } else {
        echo "Invalid rating. Please provide a rating between 1 and 5.";
    }
} else {
    echo "Missing requestId or rating.";
}

// Close the database connection
mysqli_close($conn);
?>
