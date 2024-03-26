<?php
session_start();
header('Content-Type: application/json');
require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

// prevent bad navigation, admins only 
if ($_SESSION['utype'] != 1) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// array to initialize chart data
$chartData = [
    'labels' => ['Accounts Created', 'Total Likes', 'Accounts Deleted', 'Posts Made', 'Total Comments', 'Admins Available'],
    'datasets' => [
        [
            'label' => 'Counts',
            'backgroundColor' => [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            'borderColor' => [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            'borderWidth' => 1,
            'data' => [] // Data points will go here
        ]
    ]
];

try {
    // the total number of user accounts created
    $query = "SELECT COUNT(*) AS total FROM users WHERE utype = 0";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $chartData['datasets'][0]['data'][] = (int)$row['total'];

    // total number of likes
    $result = $conn->query("SELECT COUNT(*) AS total FROM likes");
    $row = $result->fetch_assoc();
    $chartData['datasets'][0]['data'][] = (int)$row['total'];

    // total number of posts made
    $query = "SELECT COUNT(*) AS total FROM posts";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $chartData['datasets'][0]['data'][] = (int)$row['total'];

    // total number of comments
    $result = $conn->query("SELECT COUNT(*) AS total FROM comments");
    $row = $result->fetch_assoc();
    $chartData['datasets'][0]['data'][] = (int)$row['total'];

    // Total number of admins
    $result = $conn->query("SELECT COUNT(*) AS total FROM users WHERE utype = 1");
    $row = $result->fetch_assoc();
    $chartData['datasets'][0]['data'][] = (int)$row['total'];

    // posts deleted
    $chartData['datasets'][0]['data'][] = 1; 

    echo json_encode($chartData);

} catch (Exception $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
    exit;

} finally {
    $conn->close();
}