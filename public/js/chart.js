document.addEventListener('DOMContentLoaded', function () {
    var analyticsButton = document.querySelector('.analytics-button');
    var analyticsDashboard = document.getElementById('analytics-dashboard');
    var chartInstance = null; 

    function toggleChartDisplay() {
        if (chartInstance !== null) {
            // destroy the current chart
            chartInstance.destroy();
            chartInstance = null;
            analyticsDashboard.style.display = 'none'; // hide the dashboard
        } else {
            analyticsDashboard.style.display = 'flex';
            fetchAndCreateChart();
        }
    }
    
    function fetchAndCreateChart() {
        fetch('../scripts/chart_script.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }

                if (chartInstance) {
                    chartInstance.destroy();
                }
                
                const ctx = document.getElementById('myChart').getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                alert('Error: ' + error.message);
            });
    }
    
    analyticsButton.addEventListener('click', toggleChartDisplay);
});

