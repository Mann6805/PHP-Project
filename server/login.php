<?php
session_start(); // Start the session

// Include the database connection
include 'connection.php'; // Ensure this file sets up the $conn variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $query = "SELECT password, role FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Check if the user exists
    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if ($user && $user['password'] === $password) {
            // Store username and role in session variables
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Redirect to index.php
            header("Location: ../index.php"); // Adjust the path to your index.php
            exit(); // Make sure to exit after redirection
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Query error
        die("Query failed: " . mysqli_error($conn));
    }
}
?>
