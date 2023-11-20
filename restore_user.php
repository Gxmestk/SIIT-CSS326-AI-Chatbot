<?php
// Start the session to access session variables
session_start();

// Include database connection
require 'db.php';

// Check if the user ID is set in the session for restoration
if (isset($_SESSION['restore_user_id'])) {
    $userId = $_SESSION['restore_user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['restore'])) {
            // Restore the user account 
            $stmt = $conn->prepare("CALL RestoreUser(?)");
            $stmt->bind_param("i", $userId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Success - Account restored
                unset($_SESSION['restore_user_id']); // Remove the restore_user_id from session
                header("Location: login.php");
                exit();
            } else {
                // Error - Account not restored
                $error_message = "Error: Could not restore the account.";
            }
            $stmt->close();
        } elseif (isset($_POST['no'])) {
            // User chose not to restore the account
            header("Location: login.php");
            exit();
        }
    }
} else {
    // User ID for restoration not set, redirect to login
    header("Location: login.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restore Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Restore Your Account</h2>
    <p>This account will be permanently deleted in 30 days. Do you want to restore this account?</p>
    <form method="POST" action="restore_user.php">
        <button type="submit" name="restore" value="yes" class="btn btn-success">Yes, restore my account</button>
        <button type="submit" name="no" value="no" class="btn btn-danger">No, thank you</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
