document.querySelectorAll('.toggle-details').forEach(button => {
    button.addEventListener('click', () => {
        const container = button.closest('.request-container');
        const details = container.querySelector('.request-details');

        // Toggle the 'expanded' class on the parent container
        container.classList.toggle('expanded');

        // Change the button icon based on the expanded state
        if (container.classList.contains('expanded')) {
            button.innerHTML = '&#x25B2;'; // Up arrow
        } else {
            button.innerHTML = '&#x25BC;'; // Down arrow
        }

        // Dynamically adjust the container height to fit the content
        if (container.classList.contains('expanded')) {
            container.style.height = `${container.scrollHeight}px`; // Set height to fit content
        } else {
            container.style.height = '200px'; // Collapse back to original height
        }
    });
});
