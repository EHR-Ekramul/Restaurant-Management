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
    <title>Dashboard - Change Password</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include "partials/header.php"; ?>
    <div class="dashboard-container">
        <?php include "partials/sidebar.php"; ?>
        <main class="main-content">
            <h2>Change Password</h2>
            <p>Update your account password here.</p>
            <!-- Change password form goes here -->
        </main>
    </div>
    <?php include "partials/footer.php"; ?>
</body>
</html>
