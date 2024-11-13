<?php
// Include your database connection file
include "../server/connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
// Check if the role is 'seller'
if ($_SESSION['role'] != 'vendor') {
    // If the role is not 'seller', redirect to the vendor dashboard
    header("Location: ../Seller/sell.php");
    exit();
}


$vendorQuery = "SELECT id FROM users WHERE username = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "' AND role = '" . mysqli_real_escape_string($conn, $_SESSION['role']) . "'";
$vendorResult = mysqli_query($conn, $vendorQuery);
$vendorId = null;

if (mysqli_num_rows($vendorResult) > 0) {
    $vendorData = mysqli_fetch_assoc($vendorResult);
    $vendorId = $vendorData['id'];
}

// SQL queries to fetch the data for ongoing, active, and completed requests
$ongoingQuery = "SELECT sr.request_id, sr.scrap_type, sr.scrap_name, sr.weight, sr.address, u.username AS seller_name, vp.company_name, sr.has_reached
                 FROM scrap_requests sr
                 JOIN users u ON sr.user_id = u.id
                 LEFT JOIN vendor_profiles vp ON sr.vendor_id = vp.vendor_id
                 WHERE sr.status = 'ongoing' AND sr.vendor_id = '$vendorId'";

$activeQuery = "SELECT sr.request_id, sr.scrap_type, sr.scrap_name, sr.weight, sr.address, u.username AS seller_name, vp.company_name
                FROM scrap_requests sr
                JOIN users u ON sr.user_id = u.id
                LEFT JOIN vendor_profiles vp ON sr.vendor_id = vp.vendor_id
                WHERE sr.status = 'active'";

$completedQuery = "SELECT sr.request_id, sr.scrap_type, sr.scrap_name, sr.weight, sr.address, 
                          vp.total_earnings, u.username AS seller_name, vp.company_name
                   FROM scrap_requests sr
                   JOIN users u ON sr.user_id = u.id
                   LEFT JOIN vendor_profiles vp ON sr.vendor_id = vp.vendor_id
                   WHERE sr.status = 'completed'";   

// Execute the queries
$ongoingResult = mysqli_query($conn, $ongoingQuery);
$activeResult = mysqli_query($conn, $activeQuery);
$completedResult = mysqli_query($conn, $completedQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="buy.css">
    <title>Buy Page</title>
</head>
<body>

    <!-- Back Arrow -->
    <a href="../index.php" class="back-arrow">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#191970">
            <path d="M15.41 7l-1.41-1.41L7.83 12l6.17 6.17 1.41-1.41L10.67 12z"/>
        </svg>
    </a>

    <!-- Ongoing Requests Section -->
    <section class="SectionThree">
        <h1>Ongoing</h1>
        <?php
        if (mysqli_num_rows($ongoingResult) > 0) {
            while ($row = mysqli_fetch_assoc($ongoingResult)) {
                $hasReached = $row['has_reached'];
                echo '
                <div class="request-container">
                    <div class="request-info">
                        <div class="request-header">
                            <span class="seller-name">' . htmlspecialchars($row['seller_name']) . '</span>
                            <span class="scrap-type">' . htmlspecialchars($row['scrap_type']) . '</span>
                        </div>
                        <div class="request-details">
                            <span>Scrap Name: ' . htmlspecialchars($row['scrap_name']) . '</span><br>
                            <span>Weight: ' . htmlspecialchars($row['weight']) . '</span><br>
                            <span>Address: ' . htmlspecialchars($row['address']) . '</span><br>';
                            if ($hasReached) {
                                echo '<button class="reach-button" disabled>Reached</button>';
                            } else {
                                echo '<a href="../server/process_reach.php?request_id=' . $row['request_id'] . '">
                                        <button class="reach-button">Reach</button>
                                    </a>';
                            }
                            echo'
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p>No ongoing requests.</p>';
        }
        ?>
    </section>

    <!-- Active Requests Section -->
    <section class="SectionThree">
        <h1>Active</h1>
        <?php
        if (mysqli_num_rows($activeResult) > 0) {
            while ($row = mysqli_fetch_assoc($activeResult)) {
                echo '
                <div class="request-container">
                    <div class="request-info">
                        <div class="request-header">
                            <span class="seller-name">' . htmlspecialchars($row['seller_name']) . '</span>
                            <span class="scrap-type">' . htmlspecialchars($row['scrap_type']) . '</span>
                        </div>
                        <div class="request-details">
                            <span>Scrap Name: ' . htmlspecialchars($row['scrap_name']) . '</span><br>
                            <span>Weight: ' . htmlspecialchars($row['weight']) . '</span><br>
                            <span>Address: ' . htmlspecialchars($row['address']) . '</span><br>
                            <a href="../server/process_buy.php?request_id=' . $row['request_id'] . '&vendor_id=' . $vendorId . '">
                                <button class="accept-button">Accept</button>
                            </a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p>No active requests.</p>';
        }
        ?>
    </section>

    <!-- Completed Requests Section -->
    <section class="SectionThree">
        <h1>Completed</h1>
        <?php
        if (mysqli_num_rows($completedResult) > 0) {
            while ($row = mysqli_fetch_assoc($completedResult)) {
                echo '
                <div class="request-container">
                    <div class="request-info">
                        <div class="request-header">
                            <span class="seller-name">' . htmlspecialchars($row['seller_name']) . '</span>
                            <span class="scrap-type">' . htmlspecialchars($row['scrap_type']) . '</span>
                        </div>
                        <div class="request-details">
                            <span>Scrap Name: ' . htmlspecialchars($row['scrap_name']) . '</span><br>
                            <span>Weight: ' . htmlspecialchars($row['weight']) . '</span><br>
                            <span>Address: ' . htmlspecialchars($row['address']) . '</span><br>
                            <span class="amount">Amount: $' . htmlspecialchars($row['total_earnings']) . '</span>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p>No completed requests.</p>';
        }
        ?>
    </section>
    <p style="margin-top: 20px">&nbsp</p>
    <script src="buy.js"></script>
    <script src="../handler.js" defer></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
