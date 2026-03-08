<?php
// Database credentials
// Copy this file to db.php and update with your actual credentials
$host = 'localhost';      // Database host (usually localhost)
$db   = 'chatbot_db';     // Database name
$user = 'your_username';  // Database username
$pass = 'your_password';  // Database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
