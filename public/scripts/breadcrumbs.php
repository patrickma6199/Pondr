<?php
// for breadcrumbs
echo '<ul class="breadcrumb">';
if (!isset ($_SESSION['bc_title'])) {
    $_SESSION['bc_title'] = ['Home'];
    $_SESSION['bc_link'] = ['./landing.php'];
}

$lastIndex = array_search($pageTitle, array_reverse($_SESSION['bc_title'], true));
if ($lastIndex !== false) {
    $_SESSION['bc_title'] = array_slice($_SESSION['bc_title'], 0, $lastIndex + 1);
    $_SESSION['bc_link'] = array_slice($_SESSION['bc_link'], 0, $lastIndex + 1);
} else {
    array_push($_SESSION['bc_title'],$pageTitle);
    array_push($_SESSION['bc_link'],$_SERVER['REQUEST_URI']);
}

for($i = 0; $i < count($_SESSION['bc_title']); $i++) {
    if ($i > 0) {
        echo '<span>&nbsp;&gt;&nbsp;</span>';
    }
    $title = $_SESSION['bc_title'][$i];
    $link = $_SESSION['bc_link'][$i];
    echo "<li><a href=\"$link\">$title</a></li>";
}

echo '</ul>';
?>