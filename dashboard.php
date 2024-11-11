<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
   
</head>

<body>
    <header class="main-nav">
        <button class="burger-button" id="toggleButton"><img src="images/burger.png"/></button>
        <div class="logo-container">
            <img src="images/apartelle-logo.png"/>
            <img src="images/apartelle-name.png"/>
        </div>
        <button class="profile-button" id="profileButton"><p>Hello, Kim</p>
        <img src="images/face.png" alt="Profile Face"/></button>
            
        <div id="dropdownMenu" class="dropdown-content">
            <a href="#">Profile</a>
            <a href="#">Settings</a>
            <a href="logout.php">Logout</a>
        </div>
        
    </header>
    <div class="main-body">
    <div class="side-nav">
        <div class="side-nav-buttons-container">
        <button class="side-nav-button" onclick="highlightButton(this)" data-content="
        <div class='second-side-nav-div'>
        <h1 class='h1-second-nav'>INVENTORY MANAGEMENT</h1>
        </div>
        <button class='second-nav-button' data-file='inventoryManagement/stock_levels.php' onclick='highlightSecondNav(this); loadPHP(this);'>Stock Levels</button>
        <button class='second-nav-button' data-file='inventoryManagement/asset_tracking.php' onclick='highlightSecondNav(this); loadPHP(this);'>Asset Tracking</button>">
        <img src="images/first-side-nav-icon.png" />
    </button>   

    <button class="side-nav-button" onclick="highlightButton(this)" data-content="
        <div class='second-side-nav-div'>
        <h1 class='h1-second-nav'>HOUSEKEEPING & MAINTENANCE</h1>
        </div>
        <button class='second-nav-button' data-file='housekeepingAndMaintenance/task_assignment.php' onclick='highlightSecondNav(this); loadPHP(this);'>Task Assignment</button>
        <button class='second-nav-button' data-file='housekeepingAndMaintenance/cleaning_schedule.php' onclick='highlightSecondNav(this); loadPHP(this);'>Cleaning Schedule</button>
        <button class='second-nav-button' data-file='housekeepingAndMaintenance/maintenance_alerts.php' onclick='highlightSecondNav(this); loadPHP(this);'>Maintenance Alerts</button>
        <button class='second-nav-button' data-file='housekeepingAndMaintenance/other.php' onclick='highlightSecondNav(this); loadPHP(this);'></button>">
        <img src="images/second-side-nav-icon.png" />
    </button>

    <button class="side-nav-button" onclick="highlightButton(this)" data-content="
        <div class='second-side-nav-div'>
        <h1 class='h1-second-nav' style='font-size: 33px;'>SECURITY & SAFETY</h1>
        </div>
        <button class='second-nav-button' data-file='securityAndSafety/access_control.php' onclick='highlightSecondNav(this); loadPHP(this);'>Access Control System</button>
        <button class='second-nav-button' data-file='securityAndSafety/emergency_procedure.php' onclick='highlightSecondNav(this); loadPHP(this);'>Emergency Procedure</button>
        <button class='second-nav-button' data-file='securityAndSafety/safety_inspection.php' onclick='highlightSecondNav(this); loadPHP(this);'>Safety Inspection</button>
        <button class='second-nav-button' data-file='securityAndSafety/incident_reporting.php' onclick='highlightSecondNav(this); loadPHP(this);'>Incident Reporting</button>">
        <img src="images/third-side-nav-icon.png" />
    </button>

    <button class="side-nav-button" onclick="highlightButton(this)" data-content="
        <div class='second-side-nav-div'>
        <h1 class='h1-second-nav'>PRODUCTION SCHEDULING & CONTROL</h1>
        </div>
        <button class='second-nav-button' data-file='productionSchedulingAndControl/task_scheduling.php' onclick='highlightSecondNav(this); loadPHP(this);'>Task Scheduling</button>
        <button class='second-nav-button' data-file='productionSchedulingAndControl/resources_allocation.php' onclick='highlightSecondNav(this); loadPHP(this);'>Resources Allocation</button>
        <button class='second-nav-button' data-file='productionSchedulingAndControl/performance_monitoring.php' onclick='highlightSecondNav(this); loadPHP(this);'>Performance Monitoring</button>
        <button class='second-nav-button' data-file='productionSchedulingAndControl/quality_control.php' onclick='highlightSecondNav(this); loadPHP(this);'>Quality Control Measures</button>">
        <img src="images/fourth-side-nav-icon.png" />
    </button>
        </div>
    </div>
    <div class="second-side-nav">
        <div class='second-side-nav-div'>
        <h1 class='h1-second-nav'>INVENTORY MANAGEMENT</h1>
        </div>
        <button class='second-nav-button' data-file='inventoryManagement/stock_levels.php' onclick='highlightSecondNav(this); loadPHP(this);'>Stock Levels</button>
        <button class='second-nav-button' data-file='inventoryManagement/asset_tracking.php' onclick='highlightSecondNav(this); loadPHP(this);'>Asset Tracking</button>
    </div>
    <div id="result" class="body">
        
    </div>
    </div>
    <script src="script.js">
     
    </script>
     <script>
function updateQuantity(stockId) {
    var newQuantity = document.getElementById('quantity_' + stockId).value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "inventoryManagement/update_quantity.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText); // Handle the response from the server
            // Update the displayed quantity in the table
            document.getElementById('display_quantity_' + stockId).textContent = newQuantity;
        }
    };
    xhr.send("stock_id=" + stockId + "&quantity=" + newQuantity);
}
function updateButton(value) {
            document.getElementById('dropdownMenuButton').innerText = value;
        }
</script>
<script>
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
                alert(data.message);
                if (data.success) {
                    // Reload to update the list
                    location.reload(); 
                }
            },
            error: function(xhr, status, error) {
                console.error("Error submitting new order:", error);
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
                alert(data.message);
                if (data.success) {
                    // Update the status in the table row without reloading the page
                    const newStatus = form.find('select[name="new_status"]').val();
                    const latestTrack = data.latest_track; // Get the new latest track timestamp
                    const row = form.closest('tr');
                    row.find('td:nth-child(4)').text(newStatus); // Update status cell
                    row.find('td:nth-child(3)').text(latestTrack); // Update latest track with the new timestamp
                }
            },
            error: function(xhr, status, error) {
                console.error("Error updating status:", error);
            }
        });
    });
});



</script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
     $(document).on('click', '#submitButton', function() {
    var formData = new FormData($('#incidentReportForm')[0]);

    $.ajax({
        type: 'POST',
        url: 'securityAndSafety/submit_incident.php', // Ensure this path is correct
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response); // Log the response for debugging
            $('#responseMessage').html('<div class="alert alert-success">Incident reported successfully!</div>');
            $('#incidentReportForm')[0].reset(); // Reset the form
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error); // Log error for debugging
            $('#responseMessage').html('<div class="alert alert-danger">Error reporting incident: ' + error + '</div>');
        }
    });
});



    </script>
<script>
      $(document).ready(function() {
            $('#submitButton').on('click', function() {
                var formData = new FormData($('#incidentReportForm')[0]);

                $.ajax({
                    type: 'POST',
                    url: 'securityAndSafety/submit_incident.php', // Path to your PHP script
                    data: formData,
                    processData: false, 
                    contentType: false,
                    success: function(response) {
                        $('#responseMessage').html('<div class="alert alert-success">Incident reported successfully!</div>');
                        $('#incidentReportForm')[0].reset(); // Reset the form
                        location.reload(); // Reload the page to show the updated list
                    },
                    error: function(xhr, status, error) {
                        $('#responseMessage').html('<div class="alert alert-danger">Error reporting incident: ' + error + '</div>');
                    }
                });
            });

            // Update status on change
            $(document).on('change', '.status-select', function() {
                var status = $(this).val();
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: 'securityAndSafety/update_status.php', // Path to your PHP script to update the status
                    data: { id: id, status: status },
                    success: function(response) {
                        $('#responseMessage').html('<div class="alert alert-success">Status updated successfully!</div>');
                    },
                    error: function(xhr, status, error) {
                        $('#responseMessage').html('<div class="alert alert-danger">Error updating status: ' + error + '</div>');
                    }
                });
            });
        });
</script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#example').DataTable();

    // Handle individual status update
    $(document).on('click', '.btn-update', function() {
        var status = $(this).closest('tr').find('.status-dropdown').val();
        var roomId = $(this).data('id');

        $.ajax({
            url: 'housekeepingAndMaintenance/update_schedule.php',  // URL to your PHP backend that handles the status update
            method: 'POST',
            data: {
                id: roomId,
                status: status
            },
            success: function(response) {
                alert('Status updated successfully!');
                location.reload();  // Reload the page to show the updated data
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    // Handle update all dates
    $('#btn-update-all').on('click', function() {
        var newDate = $('#updateDateInput').val();

        if (!newDate) {
            alert('Please select a date before updating all rooms.');
            return;
        }

        $.ajax({
            url: 'housekeepingAndMaintenance/update_schedule.php',  // URL to your PHP backend that handles updating all dates
            method: 'POST',
            data: {
                newDate: newDate
            },
            success: function(response) {
                alert('All cleaning dates updated successfully!');
                location.reload();  // Reload the page to show the updated data
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $(document).on('change', '.assignee-dropdown', function() {
    var schedule_id = $(this).data('schedule-id');  // Get the schedule ID from the data attribute
    var assignee_id = $(this).val();  // Get the selected assignee ID from the dropdown

    // Make sure assignee_id is not empty
    if (assignee_id) {
        $.ajax({
            url: 'housekeepingAndMaintenance/update_assignee.php',  // PHP script to update the assignee
            type: 'POST',
            data: {
                schedule_id: schedule_id,
                assignee_id: assignee_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);  // Show success message
                } else {
                    alert(response.message);  // Show error message
                }
            },
            error: function() {
                alert('An error occurred while updating the assignee.');
            }
        });
    } else {
        alert("Please select a valid assignee.");
    }
});
});


</script>   
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
</body>
</html>