document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent form submission for validation
        
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const email = document.getElementById("email").value;

        // Basic validation
        if (!validateUsername(username)) {
            alert("Username must be between 3 and 20 characters and contain no special characters.");
            return;
        }

        if (!validatePassword(password)) {
            alert("Password must be at least 8 characters long and include at least one number and one letter.");
            return;
        }

        if (!validateEmail(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        // If all validations pass, submit the form
        form.submit();
    });

    function validateUsername(username) {
        const usernameRegex = /^[a-zA-Z0-9]{3,20}$/; // Only alphanumeric characters, 3-20 characters long
        return usernameRegex.test(username);
    }

    function validatePassword(password) {
        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/; // At least 8 characters, at least 1 letter and 1 number
        return passwordRegex.test(password);
    }

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email format validation
        return emailRegex.test(email);
    }
});
