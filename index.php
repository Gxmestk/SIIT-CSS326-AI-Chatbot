<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Started</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="user_setting.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="position-absolute top-0 end-0 p-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="darkModeToggle">
            <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center" style="width: 500px;">
            <h1 class="mb-2">Why do programmers</h1>
            <div class="fade show d-flex align-items-center justify-content-center mb-5" id="animatedTextWrapper">
                <h3 id="animatedText">drink a lot of coffee</h3>
            </div>
            <a href="login.php" class="btn btn-outline-primary btn-lg mb-2 w-50">Log in</a>
            <br>
            <a href="sign_up.php" class="btn btn-outline-primary btn-lg w-50">Sign up</a>
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
            "love optimizing and refactoring code"
        ];

        let textIndex = 0;
        const textElement = document.getElementById("animatedText");
        const textWrapper = document.getElementById("animatedTextWrapper");

        function changeText() {
            textWrapper.classList.remove('show'); // Remove the show class to hide
            setTimeout(() => {
                textElement.textContent = textArray[textIndex];
                textWrapper.classList.add('show'); // Add the show class to display with fade effect
                textIndex = (textIndex + 1) % textArray.length; // Cycle through the array
            }, 300);

            setTimeout(changeText, 2300); // Adjust timing for fade effect and text change
        }

        changeText(); // Initial call to start the animation
    </script>

    <script src="themeHandler.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
