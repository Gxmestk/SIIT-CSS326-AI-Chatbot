<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Setting the document character encoding -->
    <meta charset="UTF-8">
    <!-- Making the web page responsive to screen size -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title for the web page -->
    <title>Login</title>
    <!-- Including Bootstrap CSS from the specified version -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="user_setting.css" rel="stylesheet">

</head>

<body> <!-- Setting a light background color for the body -->
    <div class="position-absolute top-0 end-0 p-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="darkModeToggle">
            <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
        </div>
    </div>
    <!-- Bootstrap row for grid system -->
    <div class="row justify-content-center">
        <!-- Setting the column width for different screen sizes -->
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <!-- Bootstrap card component for content grouping -->
            <div class="card">
                <!-- Container for card content -->
                <div class="card-body">
                    <!-- Header for the form -->
                    <h3 class="text-center mb-4">Login</h3>
                    <!-- Login form begins here -->
                    <form>
                        <!-- Input for email -->
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <!-- Input for password -->
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <!-- Login button -->
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <!-- "Don't have an account? Sign up" link -->
                    <div class="mt-3 text-center">
                        <p>Don't have an account? <a href="sign_up.php">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="themeHandler.js"></script>
    <!-- Including Bootstrap JS and Popper.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>