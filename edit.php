<?php
include 'db.php';
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$error_message = '';
$success_message = '';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $first_name = trim($_POST['input_first_name']);
    $last_name = trim($_POST['input_last_name']);
    $email = trim($_POST['input_email']);
    $phone_number = trim($_POST['input_phone_number']);
    $date_of_birth = trim($_POST['input_date_of_birth']);
    $password = $_POST['input_password'];

    // Fetch user information from the database
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) 
    {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            $user = $result->fetch_assoc();

                // Validate form data
            $validation_result = validateFormData($first_name, $last_name, $email, $phone_number, $date_of_birth, $password, $user);

            if ($validation_result !== true) 
            {
                    $error_message = $validation_result;
            } 
            else 
            {
                // Update user information in the database
                $update_query = "UPDATE users SET
                        first_name = ?,
                        last_name = ?,
                        email = ?,
                        phone_number = ?,
                        date_birth = ?
                        WHERE id = ?";

                // Prepare and execute the update query
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone_number, $date_of_birth, $userId);
                $update_stmt->execute();

                if ($update_stmt->affected_rows > 0) 
                {
                    $success_message = 'Profile updated successfully.';
                } 
                else 
                {
                    $error_message = 'Failed to update profile.';
                }

                    $update_stmt->close();
            }
            
        } 
        else 
        {
            $error_message = 'User not found.';
        }
        $stmt->close();
    } 
    else 
    {
        $error_message = 'Error preparing the SQL statement: ' . $conn->error;
    }
    // Close the database connection
    $conn->close();
}


function validateFormData($first_name, $last_name, $email, $phone_number, $date_of_birth, $password, $user)
{
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number) || empty($date_of_birth)) {
        return 'All fields are required and cannot be left blank.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email address';
    } elseif (strlen($phone_number) !== 10 || !is_numeric($phone_number)) {
        return 'Phone number must be a 10-digit numeric value.';
    } elseif (strtotime($date_of_birth) >= strtotime('now')) {
        return 'Invalid date of birth.';
    } elseif (!password_verify($password, $user['password_hash'])) {
        return 'Passwords do not match.';}

    return true; // Validation passed
}
?>




<!DOCTYPE html> <!-- Declaration for the document to be HTML5 -->
<html lang="en"> <!-- The root element of the page, with language set to English -->

<head>
    <meta charset="UTF-8"> <!-- Defines the character set to be UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Sets the viewport to scale for mobile devices -->
    <title data-translate="edit_title">Edit Profile</title> <!-- Title of the page, with an ID for possible JavaScript manipulation -->
    <!-- Link to Bootstrap's CSS with integrity and crossorigin attributes for Subresource Integrity (SRI) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="user_setting.css" rel="stylesheet"> <!-- Link to a custom CSS file for additional styling -->
</head>

<body>
    <?php if ($error_message != ''): ?>
        <div class="alert alert-danger mt-5" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <!-- Display success message if it exists -->
    <?php if ($success_message != ''): ?>
        <div class="alert alert-success mt-5" role="alert">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

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
    <!-- Container for the edit form with responsive breakpoints -->
    <div class="container">
        <!-- Row with centered content -->
        <div class="row justify-content-center">
            <!-- Columns for different screen sizes to ensure responsiveness -->
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <!-- Card component from Bootstrap for form -->
                <div class="card mx-auto my-5">
                    <div class="card-body">
                        <!-- Sign Up header in the card -->
                        <h3 class="text-center mb-4" id="edit_title">Edit profile</h3>
                        <!-- Sign Up form starts -->
                        <form method="post">
                            <!-- Input group for First and Last name -->
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col">
                                        <input type="text" class="form-control" name="input_first_name" placeholder="First Name" id="input_first_name">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="input_last_name" placeholder="Last Name" id="input_last_name">
                                    </div>
                                </div>
                            </div>
                            <!-- Email input -->
                            <div class="mb-3">
                                <input type="email" class="form-control" name="input_email" placeholder="Email" id="input_email">
                            </div>
                            <div class="mb-3"> <!-- A div element with a Bootstrap class to give a margin-bottom space -->
                                <input type="tel" class="form-control" name="input_phone_number" placeholder="Phone Number" id="input_phone_number"> <!-- An input field for telephone numbers with a placeholder -->
                            </div> <!-- Closing div tag for the telephone number input field -->

                            <div class="mb-3"> <!-- A div element with margin-bottom space for the date input field -->
                                <input type="date" class="form-control" name="input_date_of_birth" placeholder="Date of Birth" id="input_date_of_birth"> <!-- An input field for date of birth -->
                            </div> <!-- Closing div tag for the date input field -->

                            <div class="mb-3"> <!-- A div for the password input field with margin-bottom space -->
                                <input type="password" class="form-control" name="input_password" placeholder="Password" id="input_password"> <!-- A password input field that hides the text entered -->
                            </div> <!-- Closing div tag for the password input field -->

                            <div class="d-flex justify-content-center align-items-center">
                                <button  type="submit" class="btn btn-primary w-100" id="button_confirm">Confirm</button>                          
                                <a href="setting.php" class="btn btn-primary w-100" id="button_back">Back</a>
                            </div>

                            <!-- <div class="d-flex justify-content-center align-items-center">
                                <button type="confirm" class="btn btn-primary" id="button_confirm">Confirm</button>
                                <button type="back" class="btn btn-primary" id="button_back">Back</button>
                            </div> -->


                        </form> <!-- Closes the form tag that would have started before this provided snippet -->

                    </div> <!-- Assuming this closes a div that was opened outside this snippet -->
                </div> <!-- Another closing div tag for the parent element -->
            </div> <!-- And another closing div, likely for the structural layout -->
        </div> <!-- Closing div tag that probably closes a container or a row -->
    </div> <!-- Closing div tag that is likely ending another container or section -->
    </div> <!-- Final closing div, which would be closing the main wrapper or a significant layout division started before this snippet -->

    <script src="themeHandler.js"></script> <!-- A script link to a JavaScript file for theme handling, likely related to dark/light mode switching -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Link to Bootstrap's JavaScript bundle with integrity and crossorigin attributes for security and resource validation -->
</body> <!-- Closes the body tag of the HTML document -->

</html> <!-- Closes the html tag, marking the end of the HTML document -->