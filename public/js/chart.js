document.addEventListener('DOMContentLoaded', function () {
    const form_data = new URLSearchParams(window.location.search);
    let sDate = form_data.get('start-date');
    let eDate = form_data.get('end-date');
    let category = form_data.get('category');

    $(document).ready(function() {
        $('.category-button').click(function() {
            let category = $(this).data('category');
            $('#category-' + category).prop('checked', true);
            $('.category-button').removeClass('active'); 
            $(this).addClass('active'); 
        });
    });
    
    $(document).ready(function() {
        $('.category-button').click(function() {
            $('.category-button').removeClass('active'); //remove active class from  buttons
            $(this).addClass('active'); //add active class to  clicked button
        });
    });

    document.querySelector('.analytics-button').addEventListener('click', toggleAnalyticsChartDisplay);
    var analyticsDashboard = document.getElementById('analytics-dashboard');
    var chartInstance = null;
    var type = null;

    if (sDate != undefined || eDate != undefined || category != undefined) { 
        createLineChart(sDate, eDate, category);
    }

    $('.line-container').on('submit', function (e) { 
        let startDate = new Date($('#start-date').val());
        let endDate = new Date($('#end-date').val());
        if (startDate >= endDate) {
            e.preventDefault();
            alert("Start date must be before end date.");
        }
    });

    function toggleAnalyticsChartDisplay() {
        if (chartInstance !== null) {
            // destroy the current chart
            chartInstance.destroy();
            if (type == "bar") {
                chartInstance = null;
                analyticsDashboard.style.display = 'none'; // hide the dashboard
            } else {
                analyticsDashboard.style.display = 'flex';
                fetchAndCreateChart();
            }
        } else {
            analyticsDashboard.style.display = 'flex';
            fetchAndCreateChart();
        }
    }
    
    function fetchAndCreateChart() {
        fetch('../scripts/chart_script.php')
            .then(response => response.json())
            .then(data => {
                type = "bar";
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

    function createLineChart(sDate, eDate, category) {
        $.ajax({
            type: "POST",
            url: "../scripts/linechart.php",
            data: {sDate: sDate, eDate: eDate, category: category},
            success: function (data) {
                type = "line";
                chartInstance = new Chart(ctx, {
                    type: 'line',
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
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
});

