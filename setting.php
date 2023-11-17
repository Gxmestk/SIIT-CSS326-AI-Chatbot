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
                                    <p><strong>FirstName:</strong> </p>
                                </div>
                                <div class="col border">
                                    <p><strong>LastName:</strong> </p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border p-1">
                            <p><strong>Email:</strong> </p>
                        </div>
                        <div class="mb-3 border p-1">
                            <p><strong>Phone Number:</strong> </p>
                        </div>
                        <div class="mb-3 border p-1">
                            <p><strong>Birthdate:</strong> .</p>
                        </div>
                        <!-- End of Personal Information Section -->

                        <!-- Edit and Delete buttons -->
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <a href="edit.php" class="btn btn-primary flex-grow-1" id="button_edit">Edit Profile</a>
                            <a href="delete.php" class="btn btn-primary flex-grow-1" id="button_delete">Delete Account</a>
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
</body>

</html>
