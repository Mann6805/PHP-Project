<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login Page</title>
</head>
<body>
    <div class="background-image"></div>
    
    <a href="index.php" class="back-arrow">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#191970">
            <path d="M15.41 7l-1.41-1.41L7.83 12l6.17 6.17 1.41-1.41L10.67 12z"/>
        </svg>
    </a>
    
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="server/login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="vendor">Vendor</option>
                    <option value="seller">Seller</option>
                </select>
            </div>
            <button type="submit">Login</button>
        </form><br>
        <p>Don't have an account? <a href="signup.php" style="color: #191970;">Sign up here</a></p> <!-- Link to Signup Page -->
    </div>

    <script src="login.js"></script>
    <script src="handler.js"></script>

</body>
</html>
