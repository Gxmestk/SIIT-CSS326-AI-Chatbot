<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the session to access session variables.
session_start();

// Redirect to the login page if the user is not logged in.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require 'db.php';

// Initialize an empty array for messages
$savedMessages = [];

// Check if user_id is provided
$UserId = $_SESSION['user_id'];

if ($UserId) {
    // Prepare the SQL query
    $sql = "SELECT * FROM saved_bot_messages WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $UserId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all saved messages
    while ($row = $result->fetch_assoc()) {
        $savedMessages[] = $row;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="chat_style.css" rel="stylesheet"> <!-- External CSS file for chat page styles -->
</head>

<body>

    <div class="chat-area p-4">
        <h2>Archived Messages</h2>
        <?php if (count($savedMessages) > 0) : ?>
            <?php foreach ($savedMessages as $message) : ?>
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <img src="user_icon.png" class="user-icon mr-2">
                        <div>
                            <strong>You:</strong>
                            <p><?php echo htmlspecialchars($message['user_message_content']); ?></p>
                            <small><?php echo htmlspecialchars($message['user_message_timestamp']); ?></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="bot_icon.png" class="user-icon mr-2">
                        <div>
                            <strong>Bot:</strong>
                            <p><?php echo htmlspecialchars($message['bot_message_content']); ?></p>
                            <small><?php echo htmlspecialchars($message['bot_message_timestamp']); ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No archived messages.</p>
        <?php endif; ?>
        <a href="chat.php" class="btn btn-secondary mt-3">Back to Chat</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>