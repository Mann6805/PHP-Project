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
        header("Location: ../Vendor/buy.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Scrap</title>
    <link rel="stylesheet" href="sell.css">
</head>
<body>

    <a href="../index.php" class="back-arrow">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#191970">
            <path d="M15.41 7l-1.41-1.41L7.83 12l6.17 6.17 1.41-1.41L10.67 12z"/>
        </svg>
    </a>

    <div class="container">
        <h1>Sell Scrap</h1>

        <form action="../server/process_sell.php" method="POST">
            <h2 class="sub-heading">Scrap Name</h2>
            <input type="text" name="scrap_name" placeholder="Enter scrap name" required>

            <h2 class="sub-heading">Select Scrap Type</h2>
            <div class="scrap-type-selection">
                <div class="scrap-type" onclick="toggleMultiSelect(this)">Paper</div>
                <div class="scrap-type" onclick="toggleMultiSelect(this)">Plastic</div>
                <div class="scrap-type" onclick="toggleMultiSelect(this)">Metal</div>
                <div class="scrap-type" onclick="toggleMultiSelect(this)">Electronics</div>
                <div class="scrap-type" onclick="toggleMultiSelect(this)">Clothes</div>
                <div class="scrap-type" onclick="toggleMultiSelect(this)">Others</div>
            </div>
            <input type="hidden" name="scrap_type" id="scrapTypeInput">

            <h2 class="sub-heading">Select Approximate Weight</h2>
            <div class="weight-selection">
                <div class="weight-option" onclick="toggleSingleSelect(this)">0-10kg</div>
                <div class="weight-option" onclick="toggleSingleSelect(this)">10-30kg</div>
                <div class="weight-option" onclick="toggleSingleSelect(this)">30kg+</div>
            </div>
            <input type="hidden" name="weight" id="weightInput">

            <h2 class="sub-heading">Address</h2>
            <textarea name="address" placeholder="Enter address for collecting scrap" required></textarea>

            <button type="submit">Book Pickup</button>
        </form>
    </div>

    <script src="sell.js"></script>
    <script src="../handler.js" defer></script>
</body>
</html>
