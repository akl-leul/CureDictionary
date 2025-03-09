// Get the toggle button
const toggleButton = document.getElementById('dark-mode-toggle');

// Check if dark mode is already set in localStorage
if(localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
}

// Add event listener to toggle button
toggleButton.addEventListener('click', () => {
    // Toggle dark mode on the body
    document.body.classList.toggle('dark-mode');

    // Save dark mode preference in localStorage
    if(document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
    } else {
        localStorage.setItem('darkMode', 'disabled');
    }
});
