<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> <!-- Sets the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensures proper rendering and touch zooming on mobile devices -->
    <title>delete page</title> <!-- Title of the document shown in the browser's title bar or tab -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Links to the Bootstrap CSS for styling -->
    <link href="user_setting.css" rel="stylesheet"> <!-- Links to your custom CSS for additional styling -->
</head>
<body>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user clicked "Yes"
    if (isset($_POST['yes'])) {
        // Perform the delete operation or any other action here
        echo "Record deleted successfully!";
    } elseif (isset($_POST['no'])) {
        // User clicked "No"
        echo "Deletion canceled.";
    }
}
?>

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
            <h1 class="mb-2" id="delete_title"> Are you sure you want to delete your account?</h1> <!-- Main heading -->
            <br>    
            <a href=" " class="btn btn-outline-primary btn-lg mb-2 w-50" id="button_yes">YES</a> <!-- Link styled as button for logging in -->
            <br> <!-- Line break -->
            <a href=" " class="btn btn-outline-primary btn-lg w-50" id="button_no">NO</a> <!-- Link styled as button for signing up -->
        </div>
    </div>

    <script src="themeHandler.js"></script> <!-- A script link to a JavaScript file for theme handling, likely related to dark/light mode switching -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
