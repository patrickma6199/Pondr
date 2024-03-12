<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Admin Dashboard - Pondr</title>
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <?php require_once '../scripts/header.php'; //for dynamic header ?>
    <div class="admin-container">
        <section class="user-management">
            <h2>User Management</h2>
            <form method="POST" action="search_results.php">
                <input type="text" name="user_search" placeholder="Search by name, email" />
                <button type="submit" class="button">Search Users</button>
            </form>
            <div id="user-list">
                <div class="list-user">
                    <div>
                        <h3>John Doe <i class = "fas fa-trash-alt" style="margin-left: 10px;" onclick=""></i></h3>
                        <p>Username: JohnDoe1234</p>
                    </div>
                    <img src="../img/pfp-3.jpg">
                </div>
                <div class="list-user">
                    <div>
                        <h3>Egg Fella <i class = "fas fa-trash-alt" style="margin-left: 10px;" onclick=""></i></h3>
                        <p>Username: EggFella1234</p>
                    </div>
                    <img src="../img/pfp-2.png">
                </div>
                <div class="list-user">
                    <div>
                        <h3>User Name <i class = "fas fa-trash-alt" style="margin-left: 10px;" onclick="g
                        t"></i></h3>
                        <p>Username: username</p>
                    </div>
                    <img src="../img/pfp.png">
                </div>
            </div>
        </section>

        <section class="data-analytics">
            <h2>Data Analytics</h2>
            <div id="analytics-dashboard">

               
                <div>
                    <canvas id="myChart"></canvas>
                  </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <script>
                    const ctx = document.getElementById('myChart');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                        labels: ['Accounts Created', 'Accounts Flagged','Accounts Deleted','Posts Made', 'Posts Flagged', 'Posts Deleted'],
                        datasets: [{
                            label: 'Dashboard',
                            data: [20, 7, 3, 40, 2, 3],
                            borderWidth: 1,
                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 159, 64, 1)',
                                                'rgba(255, 205, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(201, 203, 207, 1)'
                                                ],
                        }],
                        borderColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(255, 159, 64)',
                                        'rgb(255, 205, 86)',
                                        'rgb(75, 192, 192)',
                                        'rgb(54, 162, 235)',
                                        'rgb(153, 102, 255)',
                                        'rgb(201, 203, 207)'
                                        ]
                        },
                        options: {
                        scales: {
                            y: {
                            beginAtZero: true
                            }
                        }
                        }
                    });
                </script>
                

            </div>
        </section>    
    </div>
</body>
</html>
