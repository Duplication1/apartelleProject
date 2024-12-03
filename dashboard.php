
<?php
session_start(); 

/*if (!isset($_SESSION['employee_id'])) {
  
    header('Location: login.php');
    exit(); 
}*/
?>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
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
    <button id="logoutButton" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
        </div>

        
    </header>
    <?php 
    include 'modals/logOutModal.html';
    ?>
    <div id="snackbar"></div>
    <div class="main-body">
    <div class="side-nav">
        <div class="side-nav-buttons-container">
        <button class="side-nav-button" onclick="highlightButton(this)" data-content="
        <div class='second-side-nav-div'>
        <h1 class='h1-second-nav'>INVENTORY MANAGEMENT</h1>
        </div>
        <button class='second-nav-button' data-file='inventoryManagement/stock_levels.php' onclick='highlightSecondNav(this); loadPHP(this);'>Stock Levels</button>
        <button class='second-nav-button' data-file='inventoryManagement/asset_tracking.php' onclick='highlightSecondNav(this); loadPHP(this);'>Asset Tracking</button>
        <button class='second-nav-button' data-file='inventoryManagement/reorder_alerts.php' onclick='highlightSecondNav(this); loadPHP(this);'>Reorder Alerts</button>
        ">
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
        <button class='second-nav-button' data-file='securityAndSafety/security_personnel.php' onclick='highlightSecondNav(this); loadPHP(this);'>Security</button>
        <button class='second-nav-button' data-file='securityAndSafety/incident_reporting.php' onclick='highlightSecondNav(this); loadPHP(this);'>Incident Reporting</button>">
        <img src="images/third-side-nav-icon.png" />
    </button>

    <button class="side-nav-button" onclick="highlightButton(this)" data-content="
        <div class='second-side-nav-div'>
        <h1 class='h1-second-nav'>PRODUCTION SCHEDULING & CONTROL</h1>
        </div>
        <button class='second-nav-button' data-file='productionSchedulingAndControl/resources_allocation.php' onclick='highlightSecondNav(this); loadPHP(this);'>Resources Allocation</button>
        <button class='second-nav-button' data-file='productionSchedulingAndControl/performance_monitoring.php' onclick='highlightSecondNav(this); loadPHP(this);'>Performance Monitoring</button>
      ">
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
        <button class='second-nav-button' data-file='inventoryManagement/reorder_alerts.php' onclick='highlightSecondNav(this); loadPHP(this);'>Reorder Alerts</button>
    </div>
    <div id="result" class="body">
        
    </div>
    </div>
    <script src="script.js"></script>
     <script src="js/updateQuantity.js"></script>
    <script src="js/assetTracking.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="js/submitIncident.js"></script>
<script src="js/cleaning.js"></script>
<script src="js/maintenance.js"></script>
<script src="js/reorder.js"></script>
<script src="js/updateSecurity.js"></script>
<script src="js/chart.js"></script>
<script>
    $(document).ready(function() {
    // Handle individual evaluation update
    $(document).on('click', '.update-evaluation-btn', function() {
        var evaluationId = $(this).data('id');

        // Get the updated values from the input fields
        var evaluationDate = $("input[name='evaluation_date_" + evaluationId + "']").val();
        var remarks = $("input[name='remarks_" + evaluationId + "']").val();
        var evaluatorName = $("input[name='evaluator_name_" + evaluationId + "']").val();

        // AJAX request to update the evaluation record
        $.ajax({
            url: 'productionSchedulingAndControl/update_evaluation.php', // This file will handle the update logic
            method: 'POST',
            data: {
                evaluation_id: evaluationId,
                evaluation_date: evaluationDate,
                remarks: remarks,
                evaluator_name: evaluatorName
            },
            success: function(response) {
                alert('Evaluation updated successfully!');
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const myChart = new Chart(ctx, {...});
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="dataTable.js"></script>   
</body>
</html>