<?php

include "connection.php";

/* For making users table */
$query1 = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(8) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('vendor', 'seller') NOT NULL
);";

/* For making vendor_profiles table */
$query2 = "CREATE TABLE vendor_profiles (
    vendor_id INT PRIMARY KEY,
    company_name VARCHAR(100),
    experience INT, 
    total_requests INT DEFAULT 0,
    total_earnings DECIMAL(10, 2) DEFAULT 0,
    FOREIGN KEY (vendor_id) REFERENCES users(id)
);";

/* For making scrap_requests table */
$query3 = "CREATE TABLE scrap_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    scrap_type VARCHAR(50) NOT NULL,
    scrap_name VARCHAR(100) NOT NULL,
    weight DECIMAL(10, 2) NOT NULL,
    address TEXT NOT NULL,
    status ENUM('ongoing', 'active', 'completed') DEFAULT 'active',
    vendor_id INT DEFAULT NULL,
    has_reached BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vendor_id) REFERENCES users(id)
);";

/* For making reviews table */
$query4 = "CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    vendor_id INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    FOREIGN KEY (seller_id) REFERENCES users(id),
    FOREIGN KEY (vendor_id) REFERENCES users(id)
);";

if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2) && mysqli_query($conn, $query3) && mysqli_query($conn, $query4)) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . mysqli_error($conn);
}

closeConnection($conn);

?>
