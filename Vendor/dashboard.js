// Enable editing on clicking the "Edit" button
document.querySelector('.edit-button').addEventListener('click', function() {
    document.getElementById('companyName').removeAttribute('readonly');
    document.getElementById('experience').removeAttribute('readonly');
});

// Save changes and redirect to updateprofile.php with updated values
document.querySelector('.save-button').addEventListener('click', function() {
    // Make fields read-only again
    document.getElementById('companyName').setAttribute('readonly', true);
    document.getElementById('experience').setAttribute('readonly', true);

    // Get the updated values
    const companyName = document.getElementById('companyName').value;
    const experience = document.getElementById('experience').value;

    // Redirect to updateprofile.php with the updated data as URL parameters
    window.location.href = `../server/updateprofile.php?companyName=${encodeURIComponent(companyName)}&experience=${encodeURIComponent(experience)}`;
});
