<?php
session_start();
header('Content-Type: application/json');
require_once 'dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

function getDatesBetween($startDate, $endDate) {
    $dates = array();

    // Convert the provided strings to DateTime objects
    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    // Add 1 day to the end date so that it's inclusive
    $endDate->modify('+1 day');

    // Create a DatePeriod object to iterate over the dates
    $dateRange = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);

    // Iterate over each date in the range and add it to the array
    foreach ($dateRange as $date) {
        $dates[] = $date->format('Y-m-d');
    }

    return $dates;
}

// prevent bad navigation, admins only 
if ($_SESSION['utype'] != 1) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

if (isset($_POST['sDate']) && isset($_POST['eDate'])) {
    $sDate = $_POST['sDate'];
    $eDate = $_POST['eDate'];
    $dates = getDatesBetween($sDate, $eDate);
    // array to initialize chart data
    $chartData = [
        'labels' => $dates,
        'datasets' => [
            [
                'label' => 'likes',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'data' => [],
                'fill' => false
            ],
            [
                'label' => 'posts',
                'borderColor' => 'rgba(255, 159, 64, 1)',
                'data' => [],
                'fill' => false
            ],
            [
                'label' => 'comments',
                'borderColor' => 'rgba(255, 205, 86, 1)',
                'data' => [],
                'fill' => false
            ]
        ]
    ];

    try {
        foreach ($dates as $date) {
            // the total number of user accounts created
            $sql = "SELECT COUNT(*) FROM Likes WHERE likeDate = DATE(?);";
            $prstmt = $conn->prepare($sql);
            $prstmt->bind_param('s', $date);
            $prstmt->execute();
            $prstmt->bind_result($likecount);
            $chartData['datasets'][0]['data'][] = (int)$likecount;

            $sql = "SELECT COUNT(*) FROM posts WHERE postDate = DATE(?);";
            $prstmt = $conn->prepare($sql);
            $prstmt->bind_param('s', $date);
            $prstmt->execute();
            $prstmt->bind_result($postcount);
            $chartData['datasets'][1]['data'][] = (int)$postcount;

            $sql = "SELECT COUNT(*) FROM comments WHERE comDate = DATE(?);";
            $prstmt = $conn->prepare($sql);
            $prstmt->bind_param('s', $date);
            $prstmt->execute();
            $prstmt->bind_result($comcount);
            $chartData['datasets'][2]['data'][] = (int)$comcount;
        }
        echo json_encode(['data' => $chartData]);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
    } finally {
        $conn->close();
    }
} else {
    exit(header('Location: ../index.php'));
}
