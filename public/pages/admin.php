<?php
session_start();
ini_set('display_errors', 1);
$utype = $_SESSION['utype'] ?? "";
if ($utype != 1) {
    exit(header('./index.php')); // bad navigation
}
$pageTitle = "IGNORE";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Dashboard - Pondr</title>
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <?php require_once '../scripts/header.php';  ?>
    <?php require_once '../scripts/dbconfig.php';
    

    $userListHTML = '';
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    if (!empty($searchTerm)) {
        
        $query = "SELECT userId, fName, lName, uName, email, pfp FROM users WHERE fName LIKE ? OR lName LIKE ? OR email LIKE ?";
        $stmt = $conn->prepare($query);
        $searchTerm = '%' . $searchTerm . '%';
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $uName = $row["uName"]; 
                $userListHTML .= '<div class="list-user"><div>';
                $userListHTML .= '<h3><a href="./profile.php?uName=' . urlencode($uName) . '">' . $row["fName"] . " " . $row["lName"] . '</a>';
                $userListHTML .= '<i style="margin-left: 10px;"></i></h3>';
                $userListHTML .= '<p>Username: ' . $uName . '</p></div>';
                $userListHTML .= '<img src="../img/' . $row["pfp"] . '"></div>';
            }
        } else {
            $userListHTML = "No users found.";
        }
        
    $stmt->close();

    } else {
    
    $query = "SELECT userId, fName, lName, uName, email, pfp FROM users";
    $stmt = $conn->prepare($query);
}
  
    ?>
    <main class="main-container">
        <section class="side-container">
            <h2>User Management</h2>
            <form method="GET" action="admin.php">
                <?php $userSearchValue = isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES) : ''; ?>
                <input type="text" name="search" placeholder="Search by Username" value = "<?php echo $userSearchValue; ?>"/>
                <button type="submit" class="form-button">Search</button>
            </form>
            <div id="user-list"> 
                <?php echo $userListHTML;?> 
            </div>
        </section>

    <section class="chart-container">
            <h2>Pondr Analytics</h2>
            <div id="analytics-dashboard">
                <canvas id="myChart" aria-label="Analytics Chart" role= "img"></canvas>
            </div>               
        </section>    
    </main>
</body>
</html>
