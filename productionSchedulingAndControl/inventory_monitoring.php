<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="emergency-procedure-buttons">
    <button class='' data-file='productionSchedulingAndControl/performance_monitoring.php' onclick='loadPHP(this);'>CUSTOMER</button>
    <button class='' data-file='productionSchedulingAndControl/employee_monitoring.php' onclick='loadPHP(this);'>EMPLOYEE</button>
    <button class='' data-file='productionSchedulingAndControl/inventory_monitoring.php' onclick='loadPHP(this);' style='color: #666CAA;'>INVENTORY</button>
  </div>
  
  <div class="container">
    <div class="row">
        <div class="col">
            <canvas id="pieChart1"></canvas> 
        </div>
        <div class="col">
            <canvas id="pieChart2"></canvas> 
        </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Pie Chart 1 (performanceChartPie)
      var ctx1 = document.getElementById('performanceChartPie').getContext('2d');
      new Chart(ctx1, {
        type: 'pie',
        data: {
          labels: ['Red', 'Blue', 'Yellow'], // Data labels for the chart
          datasets: [{
            data: [300, 50, 100], // Data for each slice of the pie
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'], // Color of each slice
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'], // Border color for each slice
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            tooltip: {
              callbacks: {
                label: function(tooltipItem) {
                  return tooltipItem.label + ': ' + tooltipItem.raw;
                }
              }
            }
          }
        }
      });

      // Pie Chart 2 (performanceChartPie2)
      var ctx2 = document.getElementById('performanceChartPie2').getContext('2d');
      new Chart(ctx2, {
        type: 'pie',
        data: {
          labels: ['Green', 'Purple', 'Orange'], // Data labels for the chart
          datasets: [{
            data: [150, 200, 50], // Data for each slice of the pie
            backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'], // Color of each slice
            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'], // Border color for each slice
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            tooltip: {
              callbacks: {
                label: function(tooltipItem) {
                  return tooltipItem.label + ': ' + tooltipItem.raw;
                }
              }
            }
          }
        }
      });
    });
  </script>
</body>
</html>
