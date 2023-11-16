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

 <div class="row"> <!-- Bootstrap row for layout -->
        <div class="col-12 text-center" style="width: 500px;"> <!-- Column with centered text and fixed width -->
            <h1 class="mb-2"> Are you sure you want to delete your account?</h1> <!-- Main heading -->
            <br>    
            <a href=" " class="btn btn-outline-primary btn-lg mb-2 w-50" id="button_yes">YES</a> <!-- Link styled as button for logging in -->
            <br> <!-- Line break -->
            <a href=" " class="btn btn-outline-primary btn-lg w-50" id="button_no">NO</a> <!-- Link styled as button for signing up -->
        </div>
    </div>


</body>
</html>
