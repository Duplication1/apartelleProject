// Function to show the snackbar
function showSnackbar(message, isSuccess = true) {
    const snackbar = document.getElementById('snackbar');
    snackbar.textContent = message;
    snackbar.style.backgroundColor = isSuccess ? '#4CAF50' : '#f44336'; // Green for success, red for error
    snackbar.className = "show";

    // Hide snackbar after 3 seconds
    setTimeout(() => {
        snackbar.className = snackbar.className.replace("show", "");
    }, 3000);
}

// Function to show item details when an item is clicked
function showItemDetails(itemId, itemName, latestTrack, status) {
    document.getElementById("itemIdValue").innerHTML = itemId;
    document.getElementById("itemNameValue").innerHTML = itemName;
    document.getElementById("latestTrackValue").innerHTML = latestTrack;
    document.getElementById("currentStatusValue").innerHTML = status;

    // Update the active node in the tracking visual
    const nodes = document.querySelectorAll(".noded");
    nodes.forEach(node => {
        node.classList.remove("active");
        if (node.id === `node${status.replace(/\s+/g, '')}`) {
            node.classList.add("active");
        }
    });

    // Fetch status history
    fetchStatusHistory(itemId);
}

// Function to fetch and display the status history
function fetchStatusHistory(itemId) {
    $.ajax({
        type: "POST",
        url: "inventoryManagement/fetch_status_history.php", // Adjust this path if necessary
        data: { item_id: itemId },
        success: function(response) {
            const historyHtml = response.split(",");
            const historyContainer = document.getElementById("statusHistory");
            historyContainer.innerHTML = "";

            historyHtml.forEach(history => {
                const historyElement = document.createElement("p");
                historyElement.textContent = history;
                historyContainer.appendChild(historyElement);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching status history:", error);
            showSnackbar("Error fetching status history", false); // Show error snackbar
        }
    });
}

$(document).ready(function() {
    // Handle new order form submission with delegation
    $(document).on('submit', '#newOrderForm', function(e) {
        e.preventDefault(); // Prevent default form submission
        $.ajax({
            type: 'POST',
            url: 'inventoryManagement/asset_tracking.php', // Submit to the same page
            data: $(this).serialize(),
            success: function(response) {
                const data = JSON.parse(response);
                showSnackbar(data.message, data.success); // Show snackbar based on success
                if (data.success) {
                    // Reload to update the list
                    location.reload(); 
                }
            },
            error: function(xhr, status, error) {
                console.error("Error submitting new order:", error);
                showSnackbar("Error submitting new order", false); // Show error snackbar
            }
        });
    });

    // Handle status update form submission with delegation
    $(document).on('submit', 'form.updateStatusForm', function(e) {
        e.preventDefault(); // Prevent default form submission
        const form = $(this); // Get the form that triggered the event
        $.ajax({
            type: 'POST',
            url: 'inventoryManagement/asset_tracking.php', // Submit to the same page
            data: form.serialize(),
            success: function(response) {
                const data = JSON.parse(response);
                showSnackbar(data.message, data.success); // Show snackbar based on success
                if (data.success) {
                    // Update the status in the table row without reloading the page
                    const newStatus = data.new_status;  // Get the new status from the response
                    const latestTrack = data.latest_track; // Get the new latest track timestamp from the response
                    const row = form.closest('tr');
                    row.find('td:nth-child(4)').text(newStatus); // Update status cell
                    row.find('td:nth-child(3)').text(latestTrack); // Update latest track with the new timestamp
                }
            },
            error: function(xhr, status, error) {
                console.error("Error updating status:", error);
                showSnackbar("Error updating status", false); // Show error snackbar
            }
        });
    });
});
