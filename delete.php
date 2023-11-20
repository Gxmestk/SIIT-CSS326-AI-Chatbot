<?php
// Start the session to access session variables
session_start();

// Include database connection
require 'db.php';

$message = ''; // Empty message string
$alertClass = ''; // Will be used to set the class for Bootstrap alert

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user clicked "Yes"
    if (isset($_POST['confirm_deletion']) && $_POST['confirm_deletion'] == 'yes') {
        // Retrieve the user ID from the session
        $userId = $_SESSION['user_id'];

        // Call the SoftDeleteUser stored procedure
        if ($stmt = $conn->prepare("CALL SoftDeleteUser(?)")) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();

            // Check for errors
            if ($stmt->error) {
                $message = "Error during deletion: " . $stmt->error;
                $alertClass = 'alert-danger'; // Bootstrap class for error
            } else {
                // Check for successful execution of the stored procedure
                if ($stmt->affected_rows > 0) {
                    $message = "Record deleted successfully!";
                    $alertClass = 'alert-success'; // Bootstrap class for success
                    // Log the user out and redirect to the login page or home page
                    session_destroy();
                    header("Location: login.php");
                    exit();
                } else {
                    $message = "No record was deleted. It may already have been deleted, or the user ID may not exist.";
                    $alertClass = 'alert-warning'; // Bootstrap class for warning
                }
            }
        } else {
            $message = "Preparation error: " . $conn->error;
            $alertClass = 'alert-danger'; // Bootstrap class for error
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> <!-- Sets the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensures proper rendering and touch zooming on mobile devices -->
    <title>Delete Account</title> <!-- Title of the document shown in the browser's title bar or tab -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Links to the Bootstrap CSS for styling -->
    <link href="user_setting.css" rel="stylesheet"> <!-- Links to your custom CSS for additional styling -->
</head>


<body class="d-flex justify-content-center align-items-center vh-100">

    <!-- Top-right corner language switch and dark mode toggle -->
    <div class="position-absolute top-0 end-0 p-3">
        <div class="d-flex align-items-center"> <!-- Flex container for inline alignment of elements -->
            <!-- Language Switch Buttons -->
            <div class="btn-group" role="group" aria-label="Language switch">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-language" id="btn-language-th">TH</button> <!-- Button for Thai language -->
                <button type="button" class="btn btn-outline-secondary btn-sm btn-language" id="btn-language-en">EN</button> <!-- Button for English language -->
            </div>

            <!-- Dark Mode Toggle Switch -->
            <div class="form-check form-switch ms-3">
                <input class="form-check-input" type="checkbox" id="darkModeToggle"> <!-- Checkbox input for dark mode toggle -->
                <label class="form-check-label" for="darkModeToggle" id="label_dark_mode">Dark Mode</label> <!-- Label for the dark mode toggle -->
            </div>
        </div>
    </div>

    <div class="row"> <!-- Bootstrap row for layout -->
        <div class="col-12 text-center" style="width: 500px;"> <!-- Column with centered text and fixed width -->
            <h1 class="mb-2" id="delete_title">Are you sure you want to delete your account?</h1> <!-- Main heading -->
            <form method="POST" action="">
                <button type="submit" name="confirm_deletion" value="yes" class="btn btn-outline-primary btn-lg mb-2 w-50" id="button_yes">YES</button> <!-- Submit button for "Yes" -->
                <br> <!-- Line break -->
                <a href="setting.php" class="btn btn-outline-primary btn-lg w-50" id="button_no">NO</a> <!-- Link styled as button for "No" -->
            </form>
        </div>
    </div>

    <script src="themeHandler.js"></script> <!-- A script link to a JavaScript file for theme handling, likely related to dark/light mode switching -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>