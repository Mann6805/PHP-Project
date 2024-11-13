<?php
session_start();
include "../server/connection.php"; // Include your database connection

// Get the vendor's username from the session
$vendorName = $_SESSION['username'];

// Retrieve the updated values from the URL
$companyName = $_GET['companyName'];
$experience = $_GET['experience'];

// Fetch the vendor's user ID from the users table based on the username
$vendorQuery = "SELECT id FROM users WHERE username = '$vendorName' AND role = 'vendor'";
$vendorResult = mysqli_query($conn, $vendorQuery);

if ($vendorResult && mysqli_num_rows($vendorResult) > 0) {
    $vendorData = mysqli_fetch_assoc($vendorResult);
    $vendorId = $vendorData['id']; // Retrieve the vendor_id

    // Update the vendor profile in the vendor_profiles table
    $updateQuery = "UPDATE vendor_profiles SET company_name = '$companyName', experience = '$experience' WHERE vendor_id = '$vendorId'";
    
    if (mysqli_query($conn, $updateQuery)) {
        // Redirect back to dashboard after successful update
        header("Location: ../Vendor/dashboard.php");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
} else {
    echo "Vendor not found!";
}

mysqli_close($conn);
?>
