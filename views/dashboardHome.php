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
    <title>Dashboard - Home</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <!-- Include header -->
    <?php include 'partials/header.php'; ?>

    <!-- Main Container -->
    <div class="dashboard-container">
        <!-- Include Sidebar -->
        <?php include 'partials/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <h2>Welcome to Food Zone</h2>
            <p>This is the Home section of your dashboard.</p>
        </main>
    </div>

    <!-- Include Footer -->
    <?php include 'partials/footer.php'; ?>
</body>
</html>
