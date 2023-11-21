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

// Include the database connection script.
require 'db.php';

function fetchUserSessions($userId, $conn)
{
    $sessions = [];
    $query = "SELECT id, name FROM sessions WHERE user_id = ? AND deleted_at IS NULL ORDER BY last_use DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }

    $stmt->close();
    return $sessions;
}

function fetchSessionMessages($sessionId, $conn)
{
    $messages = [];
    $query = "SELECT * FROM messages WHERE session_id = ? ORDER BY timestamp ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sessionId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    $stmt->close();
    return $messages;
}

// Check if the user is creating a new chat session.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_chat'])) {
    $userId = $_SESSION['user_id']; // Assuming the user is logged in and their ID is in the session


    // Insert a new session into the database
    $insertSession = $conn->prepare("INSERT INTO sessions (user_id) VALUES (?)");
    $insertSession->bind_param("i", $userId);
    $insertSession->execute();

    // Get the ID of the newly created session
    $newSessionId = $conn->insert_id;


    // Redirect to the new chat session
    header("Location: chat.php?session_id=$newSessionId");
    exit();
}

// Fetch sessions and messages if a session ID is provided.
$sessions = fetchUserSessions($_SESSION['user_id'], $conn);



// Check if session_id is present in the URL and fetch messages.
if (isset($_GET['session_id']) && filter_var($_GET['session_id'], FILTER_VALIDATE_INT) !== false) {
        // Check if the Session ID in own by user
        $sessionId = $_GET['session_id'];
        $userId = $_SESSION['user_id'];
        $query = "SELECT id FROM sessions WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $sessionId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows !== 1) {
            // Redirect to the chat page and stop script execution.
            header("Location: chat.php");
            exit();
        }
        else{
            // Fetch messages for the session
            $sessionId = $_GET['session_id'];
            $messages = fetchSessionMessages($sessionId, $conn);
            
        }
}



// Close the database connection.
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="chat_style.css" rel="stylesheet"> <!-- External CSS file for chat page styles -->
</head>

<body>
    <!-- Session List -->

    <div class="menu">
        <div class="p-5 d-flex align-items-center">
            <form action="chat.php" method="post">
                <button type="submit" name="new_chat" class="btn btn-outline-primary flex-grow-1 ">New Chat</button>
            </form>
            <a href="setting.php" class="btn btn-outline-primary ms-3 flex-grow-1">Setting</a>
        </div>

        <div class="session-container">
            <div class="flex-grow-1 overflow-auto session-list">
                <!-- Dynamic Sessions List -->
                <?php foreach ($sessions as $session) : ?>
                    <a href="chat.php?session_id=<?php echo $session['id']; ?>" class="text-decoration-none">
                        <?php echo htmlspecialchars($session['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="chat-area p-4">
        <!-- Check if there are messages to display -->
        <?php if (!empty($messages)) : ?>
            <!-- Chat Messages (History Area) -->
            <?php foreach ($messages as $message) : ?>
                <div class="mb-3 d-flex align-items-center">
                    <!-- Display appropriate icon based on who sent the message -->
                    <?php if ($message['sender'] == 'user') : ?>
                        <img src="user_icon.png" class="user-icon mr-2">
                    <?php else : ?>
                        <img src="bot_icon.png" class="user-icon mr-2">
                    <?php endif; ?>

                    <!-- Display the message content -->
                    <div>
                        <p><?php echo htmlspecialchars($message['content']); ?></p>
                        <small class="text-muted"><?php echo htmlspecialchars($message['timestamp']); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php elseif (!isset($_GET['session_id'])) : ?>
            <p>Please select a session</p>
        <?php else : ?>
            <!-- Display a message if no messages are found for the session -->
            <p>No messages to display for this session.</p>
        <?php endif; ?>
    </div>



    <!-- Input Area for User Messages -->
    <?php if (isset($_GET['session_id']) && filter_var($_GET['session_id'], FILTER_VALIDATE_INT) !== false) : ?>
        <form method="POST" class="input-area" action="bot.php">
            <textarea class="form-control" name="user_message" rows="1" placeholder="Type your message here..."></textarea>
            <input type="hidden" name="session_id" value="<?php echo $_GET['session_id']; ?>">
            <button type="submit" class="btn btn-primary">
                Send
            </button>
        </form>
    <?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> <!-- Link to Bootstrap's JavaScript bundle -->
</body>

</html>