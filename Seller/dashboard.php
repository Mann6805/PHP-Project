<?php
session_start();

// Check if session exists
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Check if the role is 'seller'
if ($_SESSION['role'] != 'seller') {
    // If the role is not 'seller', redirect to the vendor dashboard
    header("Location: ../Vendor/dashboard.php");
    exit();
}

include "../server/connection.php"; // Database connection file

// Assuming the user's username and role are stored in the session after login
$username = $_SESSION['username'];
$userrole = $_SESSION['role'];

// Fetch the user's profile data based on username
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if ($result) {
    $profileData = mysqli_fetch_assoc($result);
    $userid = $profileData["id"];
} else {
    echo "Error fetching profile data: " . mysqli_error($conn);
    exit();
}

// Fetch active and ongoing scrap requests for the user with vendor details from `users` table
$activeQuery = "
    SELECT sr.*, u.username AS vendor_name
    FROM scrap_requests sr
    LEFT JOIN users u ON sr.vendor_id = u.id
    WHERE sr.user_id = '$userid' AND (sr.status = 'active' OR sr.status = 'ongoing')
";
$activeResult = mysqli_query($conn, $activeQuery);
if (!$activeResult) {
    echo "Error fetching active requests: " . mysqli_error($conn);
    exit();
}

// Fetch completed scrap requests for the user with vendor details from `users` table
$completedQuery = "
    SELECT sr.*, u.username AS vendor_name
    FROM scrap_requests sr
    LEFT JOIN users u ON sr.vendor_id = u.id
    WHERE sr.user_id = '$userid' AND sr.status = 'completed'
";
$completedResult = mysqli_query($conn, $completedQuery);
if (!$completedResult) {
    echo "Error fetching completed requests: " . mysqli_error($conn);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <a href="../index.php" class="back-arrow">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#191970">
            <path d="M15.41 7l-1.41-1.41L7.83 12l6.17 6.17 1.41-1.41L10.67 12z"/>
        </svg>
    </a>

    <div class="dashboard-container">
        <!-- Profile Section -->
        <div class="profile-section">
            <div class="profile-info">
                <p style="font-size: 20px"><strong>Name:</strong> <?php echo $profileData['username']; ?></p>
                <p style="font-size: 20px"><strong>Email:</strong> <?php echo $profileData['email']; ?></p>
                <p style="font-size: 20px"><strong>Role:</strong> <?php echo $userrole; ?></p>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="button-container">
            <a href="../server/logout.php" class="logout-button">Logout</a>
        </div>
        
        <hr>

        <!-- Details Section --> 
        <div class="details-section">
            <!-- Active and Ongoing Requests Section -->
            <div class="section-column">
                <h2 class="section-title secondary-text">Active & Ongoing Requests</h2>
                
                <?php if (mysqli_num_rows($activeResult) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($activeResult)) { ?>
                        <div class="scrap-details" data-request-id="<?php echo $row['request_id']; ?>">
                            <div class="scrap-header">
                                <p><strong>Vendor:</strong> <?php echo $row['vendor_name'] ? $row['vendor_name'] : 'No Vendor'; ?></p>
                                <p><strong>Status:</strong> <?php echo ucfirst($row['status']); ?></p>
                                <p><strong>Reached:</strong> <?php echo $row['has_reached'] ? 'Yes' : 'No'; ?></p>
                            </div>
                            <div class="scrapinfo">
                                <p><strong>Scrap Type:</strong> <?php echo $row['scrap_type']; ?></p>
                                <p><strong>Scrap Name:</strong> <?php echo $row['scrap_name']; ?></p>
                                <p><strong>Weight:</strong> <?php echo $row['weight']; ?> kg</p>
                                <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                            </div>
                            <div class="payment-section">
                                <?php if ($row['has_reached'] == 1) { ?>
                                    <input type="text" class="amount-input" placeholder="Enter amount">
                                    <button class="sell-button" data-request-id="<?php echo $row['request_id']; ?>">Sell</button>
                                <?php } else { ?>
                                    <button class="sell-button" disabled>Waiting for Vendor</button>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No active or ongoing requests found.</p>
                <?php } ?>
            </div>

            <!-- Completed Requests Section -->
            <div class="section-column">
                <h2 class="section-title secondary-text">Completed Requests</h2>
                
                <?php if (mysqli_num_rows($completedResult) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($completedResult)) { ?>
                        <div class="scrap-details" data-request-id="<?php echo $row['request_id']; ?>">
                            <div class="scrap-header">
                                <p><strong>Vendor:</strong> <?php echo $row['vendor_name'] ? $row['vendor_name'] : 'No Vendor'; ?></p>
                                <p><strong>Status:</strong> <?php echo ucfirst($row['status']); ?></p>
                            </div>
                            <div class="scrap-info" style="background-color: #f9fafb;"> 
                                <p><strong>Scrap Type:</strong> <?php echo $row['scrap_type']; ?></p>
                                <p><strong>Weight:</strong> <?php echo $row['weight']; ?> kg</p>
                                <hr>
                                <?php
                                // Fetch the review if exists for this request_id
                                $reviewQuery = "SELECT * FROM reviews WHERE seller_id = '$userid';";
                                $reviewResult = mysqli_query($conn, $reviewQuery);
                                if (mysqli_num_rows($reviewResult) > 0) {
                                    $reviewData = mysqli_fetch_assoc($reviewResult);
                                    ?>
                                    <p><strong>Your Review:</strong> <?php echo $reviewData['rating']; ?>/5</p>
                                <?php } else { ?>
                                    <!-- Review Form -->
                                    <label for="review">Rate:</label>
                                    <input type="number" id="review-<?php echo $row['request_id']; ?>" name="review" min="1" max="5" placeholder="1-5">
                                    <button class="review-button" data-request-id="<?php echo $row['request_id']; ?>">Submit Review</button>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No completed requests found.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <script src="../handler.js" defer></script>
    <script src="dashboard.js" defer></script>
</body>
</html>
