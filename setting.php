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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card mx-auto my-5">
                    <div class="card-body">
                        <h3 class="text-center mb-4" id="header_new_page">Profile</h3>

                        <!-- Personal Information Section -->
                        <div class="mb-3">
                            <div class="row g-2 d-flex justify-content-center align-items-center">
                                <div class="col border">
                                    <p><strong>First Name: </strong> </p>
                                </div>
                                <div class="col border">
                                    <p><strong>Last Name: </strong> </p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border p-1">
                            <p><strong>Email: </strong> </p>
                        </div>
                        <div class="mb-3 border p-1">
                            <p><strong>Phone Number: </strong> </p>
                        </div>
                        <div class="mb-3 border p-1">
                            <p><strong>Date of Birth: </strong> </p>
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
