<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Setting the document character encoding -->
    <meta charset="UTF-8">
    <!-- Making the web page responsive to screen size -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title for the web page -->
    <title>Sign Up</title>
    <!-- Including Bootstrap CSS from the specified version -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Inline CSS for custom styling -->

</head>

<body class="bg-light"> <!-- Setting a light background color for the body -->
    <!-- Bootstrap row for grid system -->
    <div class="row justify-content-center">
        <!-- Setting the column width for different screen sizes -->
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <!-- Bootstrap card component for content grouping -->
            <div class="card">
                <!-- Container for card content -->
                <div class="card-body">
                    <!-- Header for the form -->
                    <h3 class="text-center mb-4">Sign up</h3>
                    <!-- Registration form begins here -->
                    <form>
                        <!-- Container for first name and last name -->
                        <div class="mb-3">
                            <div class="row g-2"> <!-- Added Bootstrap's g-2 class to reduce gap between columns -->
                                <!-- Input for first name -->
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="First Name">
                                </div>
                                <!-- Input for last name -->
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <!-- Input for email -->
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <!-- Input for phone number -->
                        <div class="mb-3">
                            <input type="tel" class="form-control" placeholder="Phone Number">
                        </div>
                        <!-- Input for date of birth -->
                        <div class="mb-3">
                            <input type="date" class="form-control" placeholder="Date of Birth">
                        </div>
                        <!-- Input for password -->
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <!-- Input for confirming password -->
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Confirm Password">
                        </div>
                        <!-- Sign up button -->
                        <button type="submit" class="btn btn-primary w-100">Sign up</button>
                    </form>
                    <!-- "Already have an account? Sign in" link -->
                    <div class="mt-3 text-center">
                        <p>Already have an account? <a href="login.php">Sign in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Including Bootstrap JS and Popper.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
