<?php
// Database credentials
$host = 'localhost';
$db   = 'chatbot_db';
$user = 'backend';
$pass = 'aesWt1z4QT5AEy@b';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
