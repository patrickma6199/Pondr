document.addEventListener('DOMContentLoaded', function() {
    // context for the chart
    const ctx = document.getElementById('myChart').getContext('2d');

    fetch('../scripts/chart_script.php') 
        .then(response => response.json())
        .then(data => {
            console.log(data);

            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }

            // create chart using db data
            new Chart(ctx, {
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
        });
});
