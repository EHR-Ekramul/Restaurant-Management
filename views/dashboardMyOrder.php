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
    <title>Dashboard - My Orders</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include "partials/header.php"; ?>
    <div class="dashboard-container">
        <?php include "partials/sidebar.php"; ?>
        <main class="main-content">
            <h2>My Orders</h2>
            <p>Here you can view and track all your orders.</p>
            <!-- Order details or logic to display user-specific order info goes here -->
        </main>
    </div>
    <?php include "partials/footer.php"; ?>
</body>
</html>
