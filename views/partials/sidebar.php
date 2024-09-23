<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="sidebar">
    <ul>
        <li><a href="dashboardHome.php" class="<?= $currentPage == 'dashboardHome.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="dashboardAllFoods.php" class="<?= $currentPage == 'dashboardAllFoods.php' ? 'active' : '' ?>">All Foods</a></li>
        <li><a href="dashboardMyOrder.php" class="<?= $currentPage == 'dashboardMyOrder.php' ? 'active' : '' ?>">My Order</a></li>
        <li><a href="dashboardMyProfile.php" class="<?= $currentPage == 'dashboardMyProfile.php' ? 'active' : '' ?>">My Profile</a></li>
        <li><a href="dashboardChangePassword.php" class="<?= $currentPage == 'dashboardChangePassword.php' ? 'active' : '' ?>">Change Password</a></li>
        <li class="logout"><a href="../controllers/logoutAction.php">Logout</a></li>
    </ul>
</nav>
