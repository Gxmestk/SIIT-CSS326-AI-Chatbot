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
include 'db.php';
// Function to call the Hugging Face API
function callHuggingFaceAPI($userInput)
{
    $apiURL = 'https://api-inference.huggingface.co/models/facebook/blenderbot-400M-distill';
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer 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' // Replace API_TOKEN with your actual token
    ];

    $postData = [
        'inputs' => [
            'past_user_inputs' => [], // Include past user inputs if needed
            'generated_responses' => [], // Include past responses if needed
            'text' => $userInput
        ]
    ];

    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // ignore certificate errors
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // ignore certificate errors
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        // error occurred
        echo 'Error:' . curl_error($ch);
        return null;
    }

    curl_close($ch);

    return json_decode($response, true); // Return the decoded response
}

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_message']) && isset($_POST['session_id'])) {
    $session_id = $_POST['session_id'];
    $content = $_POST['user_message'];
    $feedbackType = null;
    $comment = null;

    // Determine the feedback type and extract the optional comment

    // type /help in order show all command and the explanation of each command
    if (preg_match('/^\/help/', $content, $matches)) {
        header("Location: help.php");
    }
    // When user type "/model" then link to model.php
    elseif (preg_match('/^\/model/', $content, $matches)) {
        header("Location: model.php");
    }
    //When user type "/delete" the sessions will be softdelete by call SoftDeleteSession store procedure
    elseif (preg_match('/^\/delete/', $content, $matches)) {

        $sql = "CALL SoftDeleteSession(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $session_id);
        //check affected_rows
        if ($stmt->execute()) {

            // Check for successful execution of the stored procedure
            if ($stmt->affected_rows > 0) {
                // Success - the session name was updated
                // Redirect back to the chat with a success message (or handle as appropriate)
                header("Location: chat.php");
            } else {
                // Error - the session name was not updated
                die("Error: " . $sql . "<br>" . $conn->error);
            }
        } else {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } elseif (preg_match('/^\/upvote(?:\s+(.*))?$/i', $content, $matches)) {
        $feedbackType = 'upvote';
        $comment = $matches[1] ?? null; // Set to null if no comment is provided
    } elseif (preg_match('/^\/downvote(?:\s+(.*))?$/i', $content, $matches)) {
        $feedbackType = 'downvote';
        $comment = $matches[1] ?? null; // Set to null if no comment is provided
    } elseif (preg_match('/^\/upvote(?:\s+(.*))?$/i', $content, $matches)) {
        $feedbackType = 'upvote';
        $comment = $matches[1] ?? null; // Set to null if no comment is provided
    } elseif (preg_match('/^\/downvote(?:\s+(.*))?$/i', $content, $matches)) {
        $feedbackType = 'downvote';
        $comment = $matches[1] ?? null; // Set to null if no comment is provided
    }
    // Check if the message is a command to change the session name
    elseif (preg_match('/^\/name\s+(.+)/', $content, $matches)) {
        $newSessionName = $matches[1]; // Capture the new name from the regex match

        // Update the session name in the database
        $updateSession = $conn->prepare("UPDATE sessions SET name = ? WHERE id = ?");
        $updateSession->bind_param("si", $newSessionName, $session_id);
        $updateSession->execute();

        // Check if the update was successful

        if ($updateSession->affected_rows > 0) {
            // Success - the session name was updated
            // Redirect back to the chat with a success message (or handle as appropriate)
            header("Location: chat.php?session_id=$session_id");
        } else {
            // Error - the session name was not updated

            die("Error: " . $sql . "<br>" . $conn->error);
        }
        $updateSession->close();
    } elseif (preg_match('/^\/save/', $content, $matches)) {
        $sql = "UPDATE messages SET saved_timestamp = CURRENT_TIMESTAMP WHERE session_id = ? AND sender = 'bot' ORDER BY timestamp DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $session_id);
        $stmt->execute();
        //check affected_rows
        if ($stmt->affected_rows > 0) {
            // Success - the session name was updated
            // Redirect back to the chat with a success message (or handle as appropriate)
            header("Location: chat.php?session_id=$session_id");
        } else {
            // Error - the session name was not updated
            die("Error: " . $sql . "<br>" . $conn->error);
        }
        $stmt->close();
    } elseif (preg_match('/^\/archive/', $content, $matches)) {
        $user_id = $_SESSION['user_id'];
        header("Location: archive.php");
    } else {
        // The message is not a command - handle normal message processing here
        // Call the Hugging Face API with the user's message
        $apiResponse = callHuggingFaceAPI($_POST['user_message']);

        // Process the API's response
        if ($apiResponse) {


            //insert bot message 
            $sql = "INSERT INTO messages (session_id, content, sender, user_question_message_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $sender = "user";
            $user_question_message_id = NULL;
            $stmt->bind_param("issi", $session_id, $content, $sender, $user_question_message_id);

            if (!$stmt->execute()) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            //get id from statement execute()
            $last_id = $stmt->insert_id;

            $session_id = $_POST['session_id'];
            $content = $apiResponse["generated_text"];
            $sender = "bot";
            $user_question_message_id = $last_id;
            $stmt->bind_param("issi", $session_id, $content, $sender, $user_question_message_id);
            if (!$stmt->execute()) {
                die("Error: " . $sql . "<br>" . $conn->error);
            }
        }

        $stmt->close();
        header('Location: chat.php?session_id=' . $_POST['session_id']);
    }
    if ($feedbackType) {
        // Get the latest bot message for the session
        $sql = "SELECT id FROM messages WHERE session_id = ? AND sender = 'bot' ORDER BY timestamp DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $session_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $latestBotMessage = $result->fetch_assoc();
        $stmt->close();


        //if row exists update instead


        // Check if a bot message was found
        if ($latestBotMessage) {
            // Insert the feedback
            $insertSql = "INSERT INTO modelfeedback (message_id, feedback, comment) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("iss", $latestBotMessage['id'], $feedbackType, $comment);
            $insertStmt->execute();

            if ($insertStmt->affected_rows == -1) {
                $updateSql = "UPDATE modelfeedback SET feedback = ?, comment = ? WHERE message_id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ssi", $feedbackType, $comment, $latestBotMessage['id']);
                $updateStmt->execute();
            }


            $insertStmt->close();
            header('Location: chat.php?session_id=' . $_POST['session_id']);
        }
    }
}
