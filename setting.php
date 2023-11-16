<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="chat_style.css" rel="stylesheet"> <!-- External CSS file for chat page styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #profile-container {
            max-width: 600px;
            margin: auto;
        }

        h2 {
            color: #333;
        }

        p {
            margin-bottom: 20px;
        }

        #button_edit,
        #button_delete {
            width: 100%; /* Make buttons take up the full width */
        }
    </style>
</head>
<body>

<div id="profile-container" class="mx-auto text-center">
    <h2>User Profile</h2>
    <br>
    <p><strong>FirstName:</strong> John <strong>LastName:</strong> D</p>
    <p><strong>Email:</strong> john.doe@example.com</p>
    <p><strong>Phone Number:</strong> 0890000000</p>
    <p><strong>Birthdate:</strong> 01/01/2000</p>
    
    <a href="edit.php" class="btn btn-outline-primary btn-lg mb-2 w-50 " id="button_edit">Edit Profile</a>
    <br>
    <a href="delete.php" class="btn btn-outline-primary btn-lg mb-2 w-50" id="button_delete">Delete Account</a>
    
</div>

</body>
</html>
