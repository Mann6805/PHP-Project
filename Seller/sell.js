// Toggle multi-select for scrap type
function toggleMultiSelect(element) {
    element.classList.toggle("selected");

    // Get all selected scrap types and join them as a comma-separated string
    const selectedTypes = Array.from(document.querySelectorAll(".scrap-type.selected"))
        .map(el => el.textContent)
        .join(", ");
    
    // Set the comma-separated list of selected types into the hidden input
    document.getElementById("scrapTypeInput").value = selectedTypes;
}

// Toggle single-select for weight options
function toggleSingleSelect(selectedElement) {
    const weightOptions = document.querySelectorAll('.weight-option');
    weightOptions.forEach(option => option.classList.remove("selected"));
    selectedElement.classList.add("selected");

    // Get the selected weight and set it in the hidden input field
    const weightInput = document.getElementById("weightInput");
    weightInput.value = selectedElement.textContent.trim(); // Set the weight value
}
