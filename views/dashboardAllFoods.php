<!-- dashboardAllFoods.php -->

<?php
session_start();
if (!(isset($_COOKIE['user']) || isset($_SESSION['logged_in']))) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - All Foods</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include "partials/header.php"; ?>
    <div class="dashboard-container">
        <?php include "partials/sidebar.php"; ?>
        <main class="main-content">
            <h2>All Foods</h2>
            <p>List of all foods available in your restaurant.</p>
        </main>
    </div>
    <?php include "partials/footer.php"; ?>
</body>
</html>
