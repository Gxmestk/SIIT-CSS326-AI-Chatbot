function setTheme(theme) {
    if (theme === 'dark') {
        document.body.classList.add('dark-mode');
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.classList.add('dark-mode');
        });
    } else {
        document.body.classList.remove('dark-mode');
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.classList.remove('dark-mode');
        });
    }
}

// Function to toggle the theme
function toggleTheme() {
    if (document.body.classList.contains('dark-mode')) {
        setTheme('light');
        localStorage.setItem('theme', 'light');
    } else {
        setTheme('dark');
        localStorage.setItem('theme', 'dark');
    }
}

// Load the theme preference on window load
window.onload = () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);
};

// If you have a dark mode toggle in any page, you can attach event listener like this:
const darkModeToggle = document.getElementById("darkModeToggle");
if (darkModeToggle) {
    darkModeToggle.addEventListener('change', toggleTheme);
}


document.addEventListener('DOMContentLoaded', (event) => {
    const currentTheme = localStorage.getItem('theme');

    // If the current theme in localStorage is 'dark', enable the dark mode
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');

        // Also, set the toggle switch to checked
        const darkModeToggle = document.getElementById("darkModeToggle");
        if (darkModeToggle) {
            darkModeToggle.checked = true;
        }
    }
});