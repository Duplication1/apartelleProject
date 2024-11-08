// firstenterinfo.js
document.addEventListener('DOMContentLoaded', () => {
    fetch("https://psgc.gitlab.io/api/island-groups/luzon/cities-municipalities/", {
        method: "GET",
        headers: {
            "Accept": "text/html"
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json(); // Parse the JSON data
    })
    .then(data => {
        const dataList = document.getElementById('data-list');
        data.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item.name; // Assuming 'name' is a property in the data
            dataList.appendChild(li);
        });
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
    });
});

//////////////////////////////////////////////////////////////////////////

// JavaScript to handle phone number input restrictions
function sanitizeInput() {
    const phoneInput = document.getElementById('phone');
    const errorMessage = document.getElementById('error-message');
    
    // Get the current value of the input
    let phoneValue = phoneInput.value;

    // Allow only numbers (remove any non-digit characters)
    phoneValue = phoneValue.replace(/\D/g, '');

    // Update the input with the cleaned value
    phoneInput.value = phoneValue;

    // Check if the phone number exceeds 11 characters
    if (phoneValue.length > 11) {
        errorMessage.style.display = 'inline';
        errorMessage.textContent = 'Phone number cannot exceed 11 digits.';
        phoneInput.value = phoneValue.substring(0, 11); // Trim to 11 digits
    } else {
        errorMessage.style.display = 'none'; // Hide the error message
    }
}
////////////////////////////////////////////////////

function validatePhoneInput(input) {
    // Remove non-digit characters (if any)
    input.value = input.value.replace(/\D/g, '');

    // Limit input to 11 digits
    if (input.value.length > 11) {
        input.value = input.value.slice(0, 11);
    }
}