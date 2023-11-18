<?php
header('Location: chat.php?session_id=' . $_POST['session_id']);

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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_message'])) {
    $session_id = $_POST['session_id'];
    $content = $_POST['user_message'];
    // Check if the message is a command to change the session name
    if (preg_match('/^\/name\s+(.+)/', $content, $matches)) {
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
    }
}
