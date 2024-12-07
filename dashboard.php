
<?php
session_start(); 

/*if (!isset($_SESSION['employee_id'])) {
  
    header('Location: login.php');
    exit(); 
}*/
 include 'controller/dashboardStockController.php';
 include 'controller/dashboardAssetTrackingController.php';
 include 'controller/dashboardReorderAlertsController.php';
 include 'controller/dashboardCleaningController.php';
 include 'controller/dashboardMaintenanceController.php';
 include 'controller/dashboardIncidentController.php'; 
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
        <a class='second-nav-button dashboard-link' href='dashboard.php' data-file='dashboard.php'>Dashboard</a>
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
        <a class='second-nav-button' href='dashboard.php' data-file='dashboard.php'>Dashboard</a>
        <button class='second-nav-button' data-file='inventoryManagement/stock_levels.php' onclick='highlightSecondNav(this); loadPHP(this);'>Stock Levels</button>
        <button class='second-nav-button' data-file='inventoryManagement/asset_tracking.php' onclick='highlightSecondNav(this); loadPHP(this);'>Asset Tracking</button>
        <button class='second-nav-button' data-file='inventoryManagement/reorder_alerts.php' onclick='highlightSecondNav(this); loadPHP(this);'>Reorder Alerts</button>
    </div>
    <div id="result" class="body">
        <div class="container dashboard-container">
            <div class="row dashboard-row">
                <div class="col dashboard-col">
                        <img src="images/stock-level-img.png" alt="stock-image" width="50px" height="50px" />
                        <h5 class="summary-img">Total Stock Quantity</h3>
                        <form method="POST" action="">
                            <label for="filter">Select Item Type: </label>
                            <select name="filter" id="filter" onchange="this.form.submit()">
                                <option value="All">All</option>
                                <option value="Bathroom" <?php echo ($filterType == 'Bathroom') ? 'selected' : ''; ?>>Bathroom</option>
                                <option value="Bedroom" <?php echo ($filterType == 'Bedroom') ? 'selected' : ''; ?>>Bedroom</option>
                                <option value="Staff" <?php echo ($filterType == 'Staff') ? 'selected' : ''; ?>>Staff</option>
                                <option value="Electricity" <?php echo ($filterType == 'Electricity') ? 'selected' : ''; ?>>Electricity</option>
                                <option value="Water" <?php echo ($filterType == 'Water') ? 'selected' : ''; ?>>Water</option>
                            </select>
                        </form>
                        <span id="totalQuantity">Stocks Total Quantity: <?php echo $totalQuantity; ?></span>
                </div>
                <div class="col dashboard-col">
                <img src="images/stock-img.png" alt="stock-image" width="50px" height="50px"/>
                <h5 class="summary-img"> Order Tracking</h5>
                <div class="dashboard-summary">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Asset ID</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($dashboard_result->num_rows > 0) {
                                        while ($row = $dashboard_result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['id']}</td>
                                                    <td>{$row['status']}</td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='2'>No data found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
            <div class="row dashboard-row">
                <div class="col dashboard-col">
                <img src="images/reorder-alert.png" alt="stock-image" width="50px" height="50px"/>
                <h5 class="summary-img">Reorder Summary</h1>
                <div class="dashboard-summary reorder">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Reorder ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Initialize variables to sum quantity and total price
                        $total_quantity = 0;
                        $total_price = 0;

                        // Check if there are any orders
                        if ($result_orders->num_rows > 0) {
                            while ($row = $result_orders->fetch_assoc()) {
                                // Display each row with the order details
                                echo "<tr>
                                        <td>{$row['order_id']}</td>
                                        <td>{$row['status']}</td>
                                    </tr>";
                                
                            }
                        } else {
                            // No orders found
                            echo "<tr><td colspan='4'>No orders found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                    </div>
                </div>
            </div>
            <div class="row dashboard-row">
                <div class="col dashboard-col">
                    <img src="images/cleaning-img.png" alt="stock-image" width="50px" height="50px" />
                    <h5 class="summary-img">Cleaning Schedules</h5>
                    <div class="dashboard-summary">
                    <?php
                        // Display the cleaning schedules table
                        displayCleaningSchedulesTable();
                    ?>
                    </div>
                </div>
                <div class="col dashboard-col">
                <img src="images/maintenance-img.png" alt="stock-image" width="50px" height="50px" />
                <h5 class="summary-img">Maintenance Schedules</h5>
                        <div class="dashboard-summary">
                            
                            <?php
                                // Display the maintenance schedules table
                                displayMaintenanceSchedulesTable();
                            ?>
                        </div>
                    </div>
                <div class="col dashboard-col">
                <img src="images/incident-img.png" alt="stock-image" width="50px" height="50px"/>
                <h5>Incident Reports</h5>
                    <div class="dashboard-summary">
                        <?php
                            // Display the incident reports table
                            displayIncidentReportsTable();
                        ?>
                    </div>
                </div>
            </div>
            <div class="row dashboard-row">
                <div class="col dashboard-col">

                </div>
            </div>
        </div>
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
<script src="js/updateEvaluation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const myChart = new Chart(ctx, {...});
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>


</script>
<script>
    // Get the query string from the URL

</script> 
</body>
</html>