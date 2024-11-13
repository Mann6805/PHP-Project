document.addEventListener("DOMContentLoaded", function () {
    // Get all the sell buttons and review buttons
    const sellButtons = document.querySelectorAll('.sell-button');
    const reviewButtons = document.querySelectorAll('.review-button');

    // Validation for Sell button
    sellButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            console.log('Sell button clicked');  // Add log to track button click

            const parent = e.target.closest('.scrap-details');
            const weight = parent.querySelector('.scrapinfo p:nth-child(2)').textContent.split(":")[1].trim();
            const amountInput = parent.querySelector('input[type="text"]');
            const amount = amountInput.value.trim();
            const requestId = parent.getAttribute('data-request-id');

            // Create a message container to show messages to the user
            const messageContainer = parent.querySelector('.message-container') || document.createElement('div');
            messageContainer.classList.add('message-container');
            parent.appendChild(messageContainer);

            // Clear any previous messages
            messageContainer.innerHTML = '';

            // Check if amount is provided and weight is valid
            if (amount === "") {
                messageContainer.textContent = "Please enter an amount to sell.";
                messageContainer.style.color = 'red';
            } else if (parseFloat(amount) <= 0) {
                messageContainer.textContent = "Amount must be a positive number.";
                messageContainer.style.color = 'red';
            } else if (parseFloat(weight) <= 0) {
                messageContainer.textContent = "Invalid weight value.";
                messageContainer.style.color = 'red';
            } else {
                console.log(`Redirecting to amount.php with requestId: ${requestId} and amount: ${amount}`);
                window.location.href = `../server/amount.php?requestId=${requestId}&amount=${amount}`;
            }
        });
    });

    // Validation for Review button
    reviewButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const parent = e.target.closest('.scrap-details');
            const reviewInput = parent.querySelector('input[type="number"]');
            const rating = reviewInput.value.trim();
            const requestId = parent.getAttribute('data-request-id');

            // Create a message container to show messages to the user
            const messageContainer = parent.querySelector('.message-container') || document.createElement('div');
            messageContainer.classList.add('message-container');
            parent.appendChild(messageContainer);

            // Clear any previous messages
            messageContainer.innerHTML = '';

            // Check if a rating is provided and is between 1 and 5
            if (rating === "") {
                messageContainer.textContent = "Please provide a rating.";
                messageContainer.style.color = 'red';
            } else if (rating < 1 || rating > 5) {
                messageContainer.textContent = "Please provide a rating between 1 and 5.";
                messageContainer.style.color = 'red';
            } else {
                // Hide the review input and display the rating
                reviewInput.style.display = 'none';
                const reviewDisplay = document.createElement('p');
                reviewDisplay.textContent = `Rating: ${rating}`;
                reviewDisplay.style.fontWeight = 'bold';
                reviewDisplay.style.color = 'green';
                parent.querySelector('.scrap-info').appendChild(reviewDisplay);

                // Send the GET request with request_id and rating
                console.log(`Redirecting to review.php with requestId: ${requestId} and rating: ${rating}`);
                window.location.href = `../server/review.php?requestId=${requestId}&rating=${rating}`;
            }
        });
    });
});
