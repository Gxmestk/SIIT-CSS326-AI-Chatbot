<?php
// Include the database connection script.
require 'db.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle unauthorized access
    header('Location: login.php'); // Replace 'login.php' with your login page URL
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Function to fetch user information
function fetchUserInfo($userId, $conn)
{
    $userInfo = [];
    $query = "SELECT first_name, last_name, email, phone_number, date_birth FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $userInfo = $row;
    }

    $stmt->close();
    return $userInfo;
}

// Fetch user information
$userInfo = fetchUserInfo($userId, $conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title_page">Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="user_setting.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card mx-auto my-5">
                    <div class="card-body">
                        <h3 class="text-center mb-4" id="header_new_page">Profile</h3>

                        <!-- Personal Information Section -->
                        <div class="mb-3 border p-1" id="s_first_name">
                            <p><strong>First Name: </strong><?php echo $userInfo['first_name']; ?></p>
                        </div>

                        <div class="mb-3 border p-1" id="s_last_name">
                            <p><strong>Last Name: </strong><?php echo $userInfo['last_name']; ?></p>
                        </div>

                        <div class="mb-3 border p-1" id="s_email">
                            <p><strong>Email: </strong><?php echo $userInfo['email']; ?></p>
                        </div>

                        <div class="mb-3 border p-1" id="s_phone_number">
                            <p><strong>Phone Number: </strong><?php echo $userInfo['phone_number']; ?></p>
                        </div>

                        <div class="mb-3 border p-1" id="s_date_of_birth">
                            <p><strong>Date of Birth: </strong><?php echo $userInfo['date_birth']; ?></p>
                        </div>
                        <!-- End of Personal Information Section -->

                        <!-- Edit and Delete buttons -->
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <a href="edit.php" class="btn btn-primary w-100" id="edit_titles">Edit Profile</a>
                            <a href="delete.php" class="btn btn-primary w-100" id="delete_button">Delete Account</a>
                        </div>

                        <div class="center text-center mb-2">
                            <a href="chat.php" class="btn btn-primary w-100" id="button_back">Back</a>
                        </div>
                        <!-- End of Edit and Delete buttons -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="themeHandler.js"></script> <!-- A script link to a JavaScript file for theme handling, likely related to dark/light mode switching -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>

</html>
