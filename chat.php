<?php
include 'db.php';  // Include database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $message_content = $_POST["message_content"];

    // Fetch user ID or create a new user
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        $stmt = $pdo->prepare("INSERT INTO users (username) VALUES (?)");
        $stmt->execute([$username]);
        $_SESSION["user_id"] = $pdo->lastInsertId();
    } else {
        $_SESSION["user_id"] = $user["id"];
    }

    // Store user's message
    $stmt = $pdo->prepare("INSERT INTO messages (user_id, content, sender) VALUES (?, ?, 'user')");
    $stmt->execute([$_SESSION["user_id"], $message_content]);

    // Generate a simple bot response and store it
    $bot_response = "Hello, I'm your chatbot!";
    $stmt = $pdo->prepare("INSERT INTO messages (user_id, content, sender) VALUES (?, ?, 'bot')");
    $stmt->execute([$_SESSION["user_id"], $bot_response]);
}

// Fetch chat messages
$messages = [];
if (isset($_SESSION["user_id"])) {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE user_id=? ORDER BY id ASC");
    $stmt->execute([$_SESSION["user_id"]]);
    $messages = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>

<body>
    <form action="chat.php" method="post">
        <?php if (!isset($_SESSION["user_id"])) : ?>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
        <?php endif; ?>
        <label for="message_content">Message:</label>
        <input type="text" id="message_content" name="message_content">
        <input type="submit" value="Send">
    </form>

    <?php foreach ($messages as $message) : ?>
        <div><strong><?php echo htmlspecialchars($message['sender']); ?>:</strong> <?php echo htmlspecialchars($message['content']); ?></div>
    <?php endforeach; ?>
</body>

</html>