<?php
session_start();

// Check if session exists
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Check if the role is 'seller'
if ($_SESSION['role'] != 'vendor') {
    // If the role is not 'seller', redirect to the vendor dashboard
    header("Location: ../Seller/dashboard.php");
    exit();
}

include "../server/connection.php"; // Include your database connection file

// Assuming the user ID is stored in the session after login
$userId = $_SESSION['username'];

// Fetch user data
$userQuery = "SELECT id, username, email, role FROM users WHERE username = '$userId'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

$vendorid = $userData['id']; // Vendor ID

// Fetch vendor profile data
$profileQuery = "SELECT company_name, experience, total_requests, total_earnings FROM vendor_profiles WHERE vendor_id = '$vendorid'";
$profileResult = mysqli_query($conn, $profileQuery);
$profileData = mysqli_fetch_assoc($profileResult);

// Fetch reviews data (assuming seller has given reviews)
$reviewsQuery = "SELECT AVG(rating) as avg_rating FROM reviews WHERE vendor_id = '$vendorid'";
$reviewsResult = mysqli_query($conn, $reviewsQuery);
$reviewsData = mysqli_fetch_assoc($reviewsResult);
$averageRating = $reviewsData['avg_rating'] ? round($reviewsData['avg_rating'], 1) : 'No reviews yet'; // Default if no reviews

// Optional: Fetch completed requests count if needed
$completedRequestsQuery = "SELECT COUNT(*) as completed_requests FROM scrap_requests WHERE vendor_id = '$vendorid' AND status = 'completed'";
$completedRequestsResult = mysqli_query($conn, $completedRequestsQuery);
$completedRequestsData = mysqli_fetch_assoc($completedRequestsResult);
$completedRequestsCount = $completedRequestsData['completed_requests'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Vendor Dashboard</title>
</head>
<body>

    <a href="../index.php" class="back-arrow">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#191970">
            <path d="M15.41 7l-1.41-1.41L7.83 12l6.17 6.17 1.41-1.41L10.67 12z"/>
        </svg>
    </a>

    <div class="dashboard-container">
        <!-- Profile Information Section -->
        <div class="profile-info">
            <h2>Vendor Profile</h2>
            <p><strong>Username:</strong> <?php echo $userData['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $userData['email']; ?></p>
            <p><strong>Role:</strong> <?php echo ucfirst($userData['role']); ?></p>
            <div>
                <label for="companyName"><strong>Company Name:</strong></label>
                <input type="text" id="companyName" value="<?php echo $profileData['company_name']; ?>" readonly>
            </div>
            <div>
                <label for="experience"><strong>Experience:</strong></label>
                <input type="text" id="experience" value="<?php echo $profileData['experience']; ?>" readonly>
            </div>
            <div class="button-container">
                <button class="edit-button">Edit</button>
                <button class="save-button">Save</button>
            </div>
        </div>

        <hr class="divider">

        <!-- Statistics Section -->
        <div class="statistics">
            <h2>Performance Overview</h2>
            <div class="stat-item">
                <p><strong>Total Earnings:</strong> $<?php echo number_format($profileData['total_earnings'], 2); ?></p>
            </div>
            <div class="stat-item">
                <p><strong>Completed Pickups:</strong> <?php echo $completedRequestsCount; ?></p>
            </div>
            <div class="stat-item">
                <p><strong>Seller Review:</strong> <?php echo $averageRating; ?> / 5</p>
            </div>
        </div>

        <!-- Logout Button at the Bottom -->
        <div class="button-container">
            <a href="../server/logout.php" class="logout-button">Logout</a>
        </div>
    </div>

    <script src="dashboard.js"></script>
    <script src="../handler.js" defer></script>
</body>
</html>
