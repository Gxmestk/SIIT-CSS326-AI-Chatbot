<?php
// Check if the request method is POST (form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user registration data from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Perform data validation
    $errors = [];

    // Example: Check if the email is in a valid format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }

    // Example: Check if passwords match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }

    // If there are no validation errors, proceed with registration
    if (empty($errors)) {
        // Hash the password (use bcrypt for security)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Establish a database connection (update with your credentials)
        $servername = "localhost";
        $username = "your_db_username";
        $password = "your_db_password";
        $dbname = "your_db_name";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare and execute an SQL INSERT statement
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone_number, date_of_birth, password) VALUES (:first_name, :last_name, :email, :phone_number, :date_of_birth, :password)");

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':date_of_birth', $dateOfBirth);
            $stmt->bindParam(':password', $hashedPassword);

            $stmt->execute();

            // Registration successful, you can redirect the user or display a success message
            echo "Registration successful!";
        } catch (PDOException $e) {
            // Handle database connection or SQL errors
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
} else {
    // Handle cases where the form is not submitted via POST
    echo "Invalid request";
}
?>
