function updateQuantity(stockId) {
    var newQuantity = document.getElementById('quantity_' + stockId).value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "inventoryManagement/update_quantity.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    // Parse the JSON response
                    var response = JSON.parse(xhr.responseText);

                    // Show the snackbar with the response message
                    showSnackbar(response.message, response.success);

                    // If successful, update the displayed quantity in the table
                    if (response.success) {
                        document.getElementById('display_quantity_' + stockId).textContent = newQuantity;
                    }
                } catch (error) {
                    // Handle unexpected response format
                    showSnackbar("Unexpected response from the server.", false);
                }
            } else {
                // Handle server errors
                showSnackbar("An error occurred. Please try again.", false);
            }
        }
    };
    xhr.send("stock_id=" + stockId + "&quantity=" + newQuantity);
}

// Snackbar function remains unchanged
function showSnackbar(message, isSuccess = true) {
    const snackbar = document.getElementById('snackbar');
    snackbar.innerHTML = message;
    snackbar.style.backgroundColor = isSuccess ? "#4CAF50" : "#f44336"; // Green for success, red for error
    snackbar.className = "show";

    // Hide after 3 seconds
    setTimeout(function () {
        snackbar.className = snackbar.className.replace("show", "");
    }, 3000);
}
