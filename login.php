<?php
// Always start with session_start() to continue with the current session or start a new one.
session_start();

// Include the database connection.
require 'db.php'; // Using require_once to ensure the script stops if the file is missing.

$error_message = ''; // Initialize an empty error message.

// Check for POST request to handle login submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate email and password fields.
    if ($email !== '' && $password !== '') {
        // Prepare the SQL statement to prevent SQL injection.
        if ($stmt = $conn->prepare("SELECT id, password_hash, deleted_at FROM users WHERE email = ?")) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // Fetch associative array from result set.
                $user = $result->fetch_assoc();

                // Check if the account is marked as deleted.
                if ($user['deleted_at'] !== null) {
                    // Redirect to restore_user.php with a message
                    $_SESSION['restore_user_id'] = $user['id'];
                    header("Location: restore_user.php");
                    exit();
                }

                // Check if the hashed password matches.
                if (password_verify($password, $user['password_hash'])) {
                    // Password is correct, set the session variable.
                    $_SESSION['user_id'] = $user['id'];

                    // Redirect to the chat page and stop script execution.
                    header("Location: chat.php");
                    exit();
                } else {
                    // Handle incorrect password.
                    $error_message = 'Invalid email or password.';
                }
            } else {
                // Handle no user found.
                $error_message = 'Invalid email or password.';
            }

            // Close the statement.
            $stmt->close();
        } else {
            // Handle SQL statement preparation error.
            $error_message = 'An error occurred. Please try again later.';
        }
    } else {
        // Handle empty email or password fields.
        $error_message = 'Please fill in both email and password.';
    }

    // Close the database connection if it's still open.
    if ($conn) {
        $conn->close();
    }
}
?>




<!DOCTYPE html> <!-- Defines the document type and version of HTML -->
<html lang="en"> <!-- Sets the language of the HTML document to English -->

<head> <!-- Contains meta-information about the document -->
    <meta charset="UTF-8"> <!-- Specifies the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Sets the viewport to scale for mobile devices -->
    <title data-translate="login_title">Login</title> <!-- The title of the document, with a custom data attribute for translation -->

    <!-- Link to the Bootstrap CSS from a CDN with integrity and crossorigin attributes for security -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Link to a custom stylesheet for additional styling -->
    <link href="user_setting.css" rel="stylesheet">
</head>

<body> <!-- The body tag contains the content of the HTML document that will be visible to the user -->
    <!-- Display the error message if it exists using Bootstrap alert component -->
    <?php if ($error_message != '') : ?>
        <div class="alert alert-danger mt-5" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>
    <div class="position-absolute top-0 end-0 p-3"> <!-- A fixed positioned container at the top right of the page with padding -->
        <div class="d-flex align-items-center"> <!-- Flex container to align items vertically in the center -->

            <!-- Language switch button group -->
            <div class="btn-group" role="group" aria-label="Language switch">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-language" id="btn-language-th">TH</button> <!-- Button to switch to Thai language -->
                <button type="button" class="btn btn-outline-secondary btn-sm btn-language" id="btn-language-en">EN</button> <!-- Button to switch to English language -->
            </div>

            <!-- Dark Mode toggle switch -->
            <div class="form-check form-switch ms-3"> <!-- Margin start (left margin) of 3 units -->
                <input class="form-check-input" type="checkbox" id="darkModeToggle"> <!-- Checkbox input for dark mode toggle -->
                <label class="form-check-label" for="darkModeToggle" id="label_dark_mode">Dark Mode</label> <!-- Label for the dark mode toggle -->
            </div>
        </div>
    </div>
    <div class="container"> <!-- Bootstrap container for centering content within the page -->
        <div class="row justify-content-center"> <!-- Bootstrap row to horizontally center its child columns -->
            <div class="col-12 col-sm-10 col-md-8 col-lg-6"> <!-- Responsive column sizes for different screen widths -->
                <div class="card mx-auto my-5"> <!-- Bootstrap card component with auto horizontal margins and a top and bottom margin of 5 -->
                    <div class="card-body"> <!-- Container for the content of the card -->
                        <h3 class="text-center mb-4" id="login_title">Login</h3> <!-- Centered title for the login card -->

                        <!-- Form for login -->
                        <form method="post">
                            <div class="mb-3"> <!-- Form group with a bottom margin of 3 -->
                                <input type="email" name="email" class="form-control" id="input_email_placeholder" placeholder="Email"> <!-- Input for email with a placeholder -->
                            </div>
                            <div class="mb-3"> <!-- Form group with a bottom margin of 3 -->
                                <input type="password" name="password" class="form-control" id="input_password_placeholder" placeholder="Password"> <!-- Input for password with a placeholder -->
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="button_login">Login</button> <!-- Submit button for the form -->
                        </form>

                        <!-- Sign up link for users who don't have an account -->
                        <div class="mt-3 text-center"> <!-- Text centering with a top margin of 3 -->
                            <p id="link_sign_up">Don't have an account? <a href="sign_up.php">Sign up</a></p> <!-- Paragraph containing the sign-up link -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for theme handling -->
    <script src="themeHandler.js"></script>

    <!-- Bootstrap's JavaScript bundle that includes jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95"></script>
</body>

</html>