<?php
session_start();
include "connection.php"; // Include your connection file

// Retrieve the username and role from the session
$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Query to fetch user ID based on session data
$query = "SELECT id FROM users WHERE username = '$username' AND role = '$role'";
$result = mysqli_query($conn, $query);

// Check if the user exists and retrieve the user ID
if ($result && mysqli_num_rows($result) > 0) {
    $profileData = mysqli_fetch_assoc($result);
    $user_id = $profileData["id"]; // Set the user ID for further use
} else {
    echo "Error: User not found.";
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $scrap_name = mysqli_real_escape_string($conn, $_POST['scrap_name']);
    $scrap_type = mysqli_real_escape_string($conn, $_POST['scrap_type']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Insert data into scrap_requests table
    $query = "INSERT INTO scrap_requests (user_id, scrap_type, scrap_name, weight, address, status) 
              VALUES ('$user_id', '$scrap_type', '$scrap_name', '$weight', '$address', 'active')";

    if (mysqli_query($conn, $query)) {
        // Redirect to dashboard on success
        header("Location: ../seller/dashboard.php");
        exit();
    } else {
        // Output error message if insertion fails
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
closeConnection($conn);
?>
