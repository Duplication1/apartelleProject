
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
    <button class='' data-file='productionSchedulingAndControl/performance_monitoring.php' onclick=' loadPHP(this); ' style='color: #666CAA;'>CUSTOMER</button>
    <button class='' data-file='productionSchedulingAndControl/employee_monitoring.php' onclick=' loadPHP(this);'>EMPLOYEE</button>
    <button class='' data-file='productionSchedulingAndControl/inventory_monitoring.php' onclick=' loadPHP(this);'>INVENTORY</button>
  </div>
  <div class="container perfomance-monitoring-container">
    <h1>CUSTOMER SATISFACTION</h1>
    <div class="perfomance-monitoring-top-container row">
      <canvas id="performanceChart"></canvas>
    </div>
    <div class="perfomance-monitoring-bottom-container row">
    <h1>RESULT BREAKDOWN</h1>

<table class="table table-striped">
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
    <tbody>
        <tr>
            <td>2020</td>
            <td>150</td>
            <td>20%</td>
            <td>5%</td>
            <td>15%</td>
            <td>3.8</td>
        </tr>
        <tr>
            <td>2021</td>
            <td>200</td>
            <td>40%</td>
            <td>45%</td>
            <td>15%</td>
            <td>3.6</td>
        </tr>
        <tr>
            <td>2022</td>
            <td>250</td>
            <td>55%</td>
            <td>15%</td>
            <td>45%</td>
            <td>4.2</td>
        </tr>
        <tr>
            <td>2023</td>
            <td>300</td>
            <td>45%</td>
            <td>25%</td>
            <td>25%</td>
            <td>4.0</td>
        </tr>
        <tr>
            <td>2024</td>
            <td>350</td>
            <td>50%</td>
            <td>15%</td>
            <td>55%</td>
            <td>4.1</td>
        </tr>
    </tbody>
</table>

    </div>
  </div>
  <script>
    
  </script>
</body>
</html>
