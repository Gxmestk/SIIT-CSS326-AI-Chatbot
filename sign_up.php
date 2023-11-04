<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="user_setting.css" rel="stylesheet">
</head>

<body>
    <div class="position-absolute top-0 end-0 p-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="darkModeToggle">
            <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card mx-auto my-5">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Sign up</h3>
                        <form>
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="First Name">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" placeholder="Phone Number">
                            </div>
                            <div class="mb-3">
                                <input type="date" class="form-control" placeholder="Date of Birth">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Confirm Password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Sign up</button>
                        </form>
                        <div class="mt-3 text-center">
                            <p>Already have an account? <a href="login.php">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="themeHandler.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
