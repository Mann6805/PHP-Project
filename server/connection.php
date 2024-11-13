<?php
// connection.php

// Database credentials
$host = 'localhost'; // or your database server
$username = 'root';
$port = "3307";
$password = '';
$database = 'trashhandler';

// Create a connection
$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to UTF-8 for proper encoding
$conn->set_charset("utf8");

// You can also define a function to close the connection
function closeConnection($connection) {
    $connection->close();
}

// If you want to use this connection file in other scripts, just include it
// include 'path/to/connection.php';

?>
