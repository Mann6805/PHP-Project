<?php
session_start();
include "connection.php"; // Include your database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Insert the new user into the `users` table
    $query1 = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
    
    if (mysqli_query($conn, $query1)) {
        // Get the ID of the newly inserted user
        $userId = mysqli_insert_id($conn);
        
        // If the role is 'vendor', also insert an entry into the `vendor_profiles` table
        if ($role === 'vendor') {
            $companyName = $_POST['company_name'] ?? ''; // Optional company name field
            $experience = $_POST['experience'] ?? ''; // Optional experience field

            $query2 = "INSERT INTO vendor_profiles (vendor_id, company_name, experience) VALUES ('$userId', '$companyName', '$experience')";

            if (!mysqli_query($conn, $query2)) {
                echo "Error inserting into vendor_profiles: " . mysqli_error($conn);
            }
        }

        // Set session variables after successful entry
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect to home page
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error inserting into users: " . mysqli_error($conn);
    }
}

mysqli_close($conn); // Close the database connection
?>
