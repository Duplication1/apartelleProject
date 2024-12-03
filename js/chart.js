function initializeChart() {
    // Line Chart
    const lineCtx = document.getElementById('performanceChart');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['2020', '2021', '2022', '2023', '2024'],
                datasets: [{
                    label: 'Satisfied',
                    data: [20, 40, 55, 45, 50],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.000001,
                },
                {
                    label: 'Dissatisfied',
                    data: [5, 45, 15, 25, 15],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.000001,
                    fill: false,
                },
                {
                    label: 'Neutral',
                    data: [15, 15, 45, 25, 55],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.000001,
                    fill: false,
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Year',
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Performance Value',
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // First Pie Chart
    const pieCtx1 = document.getElementById('pieChart1');
    if (pieCtx1) {
        new Chart(pieCtx1, {
            type: 'pie',
            data: {
                labels: ['Bathroom', 'Bedroom', 'Staff', 'Others'],
                datasets: [{
                    data: [30, 15, 25, 30],
                    backgroundColor: ['#2E236C', '#433D8B', '#C8ACD6', '#796CBA'],
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    }

    // Second Pie Chart
    const pieCtx2 = document.getElementById('pieChart2');
    if (pieCtx2) {
        new Chart(pieCtx2, {
            type: 'pie',
            data: {
                labels: ['Satisfied', 'Dissatisfied', 'Neutral'],
                datasets: [{
                    data: [30, 40, 30],
                    backgroundColor: ['rgba(75, 192, 192, 0.7)', 'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)'],
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    }
}