<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Performance Monitoring</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    #performanceChart {
      max-width: 100%;
      height: 400px;
    }
  </style>
</head>
<body>
  <div class="emergency-procedure-buttons">
    <button class='' data-file='securityAndSafety/emergency_procedure.php' onclick=' loadPHP(this); ' style='color: #666CAA;'>CUSTOMER</button>
    <button class='' data-file='securityAndSafety/fire-safety.php' onclick=' loadPHP(this);'>EMPLOYEE</button>
    <button class='' data-file='securityAndSafety/fire-safety.php' onclick=' loadPHP(this);'>INVENTORY</button>
  </div>
  <div class="container perfomance-monitoring-container">
    <h1>CUSTOMER SATISFACTION</h1>
    <div class="perfomance-monitoring-top-container col">
      <canvas id="performanceChart"></canvas>
    </div>
    <div class="perfomance-monitoring-bottom-container col">
    <h1>RESULT BREAKDOWN</h1>
      <table>
      <thead>
            <tr>
                <th>Year</th>
                <th>Guests</th>
                <th>Average Satisfied</th>
                <th>Ave. Dissatisfied</th>
                <th>Ave. Neutral</th>
                <th>Ave. Score</th>
            </tr>
        </thead>
      </table>
    </div>
  </div>
  <script>
    
  </script>
</body>
</html>
