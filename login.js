document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector("form");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");

    loginForm.addEventListener("submit", function(event) {
        // Prevent form submission
        event.preventDefault();

        // Get the values
        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();

        // Validate username and password
        if (username === "") {
            alert("Please enter your username.");
            usernameInput.focus();
            return;
        }
        if (password === "") {
            alert("Please enter your password.");
            passwordInput.focus();
            return;
        }

        // If validation passes, submit the form
        loginForm.submit();
    });
});
