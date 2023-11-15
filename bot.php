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
    // Call the Hugging Face API with the user's message
    $apiResponse = callHuggingFaceAPI($_POST['user_message']);

    // Process the API's response
    if ($apiResponse) {
        /*CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `sender` enum('user','bot') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_question_message_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;*/

        //insert bot message 
        $sql = "INSERT INTO messages (session_id, content, sender, user_question_message_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $session_id = $_POST['session_id'];
        $content = $_POST['user_message'];
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

        $stmt->close();
    }
}
