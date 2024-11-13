<?php
// Include database connection
include('connection.php');

// Check if the required GET parameters are set
if (isset($_GET['requestId']) && isset($_GET['amount'])) {
    $requestId = $_GET['requestId'];
    $amount = $_GET['amount'];

    $query = "SELECT vendor_id FROM scrap_requests WHERE request_id = '$requestId'";

    // Run the query to get vendor_id
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $vendorId = $row['vendor_id'];

        // Check if vendor_id was found
        if ($vendorId) {
            $updateVendorQuery = "UPDATE vendor_profiles 
                                  SET total_requests = total_requests + 1, total_earnings = total_earnings + $amount 
                                  WHERE vendor_id = '$vendorId'";

            // Execute the query to update vendor details
            if (mysqli_query($conn, $updateVendorQuery)) {
                $updateScrapQuery = "UPDATE scrap_requests 
                                     SET status = 'completed' 
                                     WHERE request_id = '$requestId'";

                // Execute the query to update scrap details
                if (mysqli_query($conn, $updateScrapQuery)) {
                    // Success
                    echo "Data successfully updated.";
                    header("Location: ../seller/dashboard.php");
                } else {
                    echo "Error updating scrap details: " . mysqli_error($conn);
                }
            } else {
                echo "Error updating vendor details: " . mysqli_error($conn);
            }
        } else {
            echo "No vendor found for the given request ID.";
        }
    } else {
        echo "Error fetching vendor details: " . mysqli_error($conn);
    }
} else {
    echo "Invalid parameters.";
}

// Close the database connection
mysqli_close($conn);
?>
