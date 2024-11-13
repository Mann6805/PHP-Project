// handler.js

// Function to handle navigation
function navigateTo(url) {
    // Use location.replace to prevent going back to the current page
    window.location.replace(url);
}

// Attach event listeners to all anchor tags that should navigate
document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('a[href]');

    links.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent the default anchor behavior
            const url = link.getAttribute('href'); // Get the href value
            navigateTo(url); // Call the navigateTo function
        });
    });
});
