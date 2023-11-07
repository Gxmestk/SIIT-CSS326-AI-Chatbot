<!DOCTYPE html> <!-- Defines the document type and version of HTML -->
<html lang="en"> <!-- Sets the language of the document to English -->

<head>
    <meta charset="UTF-8"> <!-- Sets the character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensures proper rendering and touch zooming on mobile devices -->
    <title>Get Started</title> <!-- Title of the document shown in the browser's title bar or tab -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Links to the Bootstrap CSS for styling -->
    <link href="user_setting.css" rel="stylesheet"> <!-- Links to your custom CSS for additional styling -->
</head>

<body class="d-flex justify-content-center align-items-center vh-100"> <!-- Flex container to center content vertically and horizontally in the viewport -->

    <div class="position-absolute top-0 end-0 p-3"> <!-- Div for language and dark mode switch, positioned absolutely at the top right -->
        <div class="d-flex align-items-center"> <!-- Flex container to align the switches next to each other -->
            <!-- Language Switch -->
            <div class="btn-group" role="group" aria-label="Language switch"> <!-- Group of buttons to switch language -->
                <button type="button" class="btn btn-outline-secondary btn-sm btn-language" id="btn-language-th">TH</button> <!-- Button for Thai language -->
                <button type="button" class="btn btn-outline-secondary btn-sm btn-language" id="btn-language-en">EN</button> <!-- Button for English language -->
            </div>

            <!-- Dark Mode Toggle -->
            <div class="form-check form-switch ms-3"> <!-- A switch toggle for dark mode with a margin start -->
                <input class="form-check-input" type="checkbox" id="darkModeToggle"> <!-- Checkbox input for the toggle -->
                <label class="form-check-label" for="darkModeToggle" id="label_dark_mode">Dark Mode</label> <!-- Label for the dark mode toggle -->
            </div>
        </div>
    </div>

    <div class="row"> <!-- Bootstrap row for layout -->
        <div class="col-12 text-center" style="width: 500px;"> <!-- Column with centered text and fixed width -->
            <h1 class="mb-2">Why do programmers</h1> <!-- Main heading -->
            <div class="fade show d-flex align-items-center justify-content-center mb-5" id="animatedTextWrapper"> <!-- Container for animated text with fade and centering -->
                <h3 id="animatedText">drink a lot of coffee</h3> <!-- The text that will be animated -->
            </div>
            <a href="login.php" class="btn btn-outline-primary btn-lg mb-2 w-50" id="button_log_in">Log in</a> <!-- Link styled as button for logging in -->
            <br> <!-- Line break -->
            <a href="sign_up.php" class="btn btn-outline-primary btn-lg w-50" id="button_sign_up">Sign up</a> <!-- Link styled as button for signing up -->
        </div>
    </div>

    <script>
        // Array of texts to animate
        const textArray = [
            "drink a lot of coffee",
            "often get asked to fix printers",
            "listen to music while they are coding",
            "prefer dark mode over light mode",
            "hate interruptions during coding",
            "love optimizing and refactoring"
        ]; // Array holding different phrases to be displayed in the animation

        let textIndex = 0; // Index of the current text from the array to display
        const textElement = document.getElementById("animatedText"); // Reference to the h3 tag where the text is displayed
        const textWrapper = document.getElementById("animatedTextWrapper"); // Reference to the div that wraps the animated text

        function changeText() {
            textWrapper.classList.remove('show'); // Remove the 'show' class to hide the text element
            setTimeout(() => {
                textElement.textContent = textArray[textIndex]; // Change the text of the h3 element
                textWrapper.classList.add('show'); // Add 'show' class back to display the new text with a fade effect
                textIndex = (textIndex + 1) % textArray.length; // Increment the index to show the next phrase
            }, 300); // Wait 300ms to make the change, allowing the fade out effect

            setTimeout(changeText, 2000); // Set a timeout to call changeText again after 2000ms
        }

        changeText(); // Call changeText initially to start the text animation loop
    </script>

    <script src="themeHandler.js"></script> <!-- Link to the JavaScript file that handles theme switching -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> <!-- Link to Bootstrap's JavaScript bundle -->
</body>

</html>
