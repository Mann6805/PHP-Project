<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>Signup Page</title>
</head>
<body>
    <div class="background-image"></div>

    <a href="index.php" class="back-arrow">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#191970">
            <path d="M15.41 7l-1.41-1.41L7.83 12l6.17 6.17 1.41-1.41L10.67 12z"/>
        </svg>
    </a>

    <div class="signup-container">
        <h2>Sign Up</h2>
        <form method="POST" action="server/signup.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="vendor">Vendor</option>
                    <option value="seller">Seller</option>
                </select>
            </div>
            <button type="submit">Sign Up</button>
        </form><br>
        <p>Already have an account? <a href="login.php" style="color: #191970;">Login here</a></p> <!-- Link to Login Page -->
    </div>

    <script src="signup.js"></script>
    <script src="handler.js"></script>
    
</body>
</html>

