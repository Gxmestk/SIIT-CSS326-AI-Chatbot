<?php
// Include the database connection script.
include 'db.php';

// Initialize an error message variable.
$error_message = '';

// Function to check if the user already exists.
function userExists($email, $phone_number, $conn) {
    $count = 0;
    $checkQuery = "SELECT COUNT(*) FROM users WHERE email = ? OR phone_number = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $email, $phone_number);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

// Function to insert a new user into the database.
function insertUser($first_name, $last_name, $email, $phone_number, $date_of_birth, $password_hash, $conn) {
    $query = "INSERT INTO users (first_name, last_name, email, phone_number, date_birth, password_hash) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone_number, $date_of_birth, $password_hash);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

// Check if the form's submit button is clicked.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and trim form data.
    $first_name = trim($_POST['input_first_name']);
    $last_name = trim($_POST['input_last_name']);
    $email = trim($_POST['input_email']);
    $phone_number = trim($_POST['input_phone_number']);
    $date_of_birth = trim($_POST['input_date_of_birth']);
    $password = $_POST['input_password'];
    $confirm_password = $_POST['input_cpassword'];

    // Validate required fields.
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number) || empty($date_of_birth)) {
        $error_message = 'All fields are required and cannot be left blank.';
    } elseif (userExists($email, $phone_number, $conn)) {
        // Check if user already exists.
        $error_message = 'Email or phone number already in use.';
    } elseif ($password !== $confirm_password) {
        // Check if passwords match.
        $error_message = 'Passwords do not match.';
    } elseif (strlen($phone_number) !== 10 || !is_numeric($phone_number)) {
        // Check if the phone number has exactly 10 digits and is numeric.
        $error_message = 'Phone number must be a 10-digit numeric value.';
    } elseif (strtotime($date_of_birth) >= strtotime('now')) {
        // Check if the date of birth is in the future.
        $error_message = 'Invalid date of birth.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email address";
    } else {
        // Hash the password.
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        // Attempt to insert a new user.
        if (insertUser($first_name, $last_name, $email, $phone_number, $date_of_birth, $password_hash, $conn)) {
            // Redirect on successful registration.
            header("Location: login.php");
            exit;
        } else {
            // Handle insertion errors.
            $error_message = 'An error occurred while creating your account.';
        }
    }

    // Close the database connection.
    $conn->close();
} elseif (basename($_SERVER['PHP_SELF']) != 'sign_up.php') {
    // Redirect to the sign-up form if not submitted.
    header("Location: sign_up.php");
    exit;
}
?>


<!DOCTYPE html> <!-- Declaration for the document to be HTML5 -->
<html lang="en"> <!-- The root element of the page, with language set to English -->

<head>
    <meta charset="UTF-8"> <!-- Defines the character set to be UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Sets the viewport to scale for mobile devices -->
    <title id="title_sign_up">Sign Up</title> <!-- Title of the page, with an ID for possible JavaScript manipulation -->
    <!-- Link to Bootstrap's CSS with integrity and crossorigin attributes for Subresource Integrity (SRI) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="user_setting.css" rel="stylesheet"> <!-- Link to a custom CSS file for additional styling -->
</head>

<body>
    <!-- Display the error message if it exists using Bootstrap alert component -->
    <?php if ($error_message != ''): ?>
        <div class="alert alert-danger mt-5" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
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
    <!-- Container for the signup form with responsive breakpoints -->
    <div class="container">
        <!-- Row with centered content -->
        <div class="row justify-content-center">
            <!-- Columns for different screen sizes to ensure responsiveness -->
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <!-- Card component from Bootstrap for form -->
                <div class="card mx-auto my-5">
                    <div class="card-body">
                        <!-- Sign Up header in the card -->
                        <h3 class="text-center mb-4" id="header_sign_up">Sign up</h3>
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

                            <div class="mb-3"> <!-- A div for the confirm password field with margin-bottom spacing -->
                                <input type="password" class="form-control" name="input_cpassword" placeholder="Confirm Password" id="input_confirm_password"> <!-- Another password input field to confirm the entered password -->
                            </div> <!-- Closing div tag for the confirm password input field -->

                            <button type="submit" class="btn btn-primary w-100" id="button_submit">Sign up</button> <!-- A button to submit the form data, styled with Bootstrap and set to full width -->
                        </form> <!-- Closes the form tag that would have started before this provided snippet -->

                        <div class="mt-3 text-center"> <!-- A div that gives top margin space and centers the content inside it -->
                            <p>Already have an account? <a href="login.php">Login</a></p> <!-- A paragraph with a link to the sign-in page if the user already has an account -->
                        </div> <!-- Closing div tag for the text and link -->

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