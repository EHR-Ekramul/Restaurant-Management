<?php
require_once '../controllers/UserController.php'; 
require_once '../models/db.php';

$totalUsers = UserControl::getTotalUsers();
$totalFoodItems = UserControl::getTotalFoodItems();
$totalPendingRequests = UserControl::getTotalPendingRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../views/css/style.css"> 
    
    <title>Dashboard</title>
</head>
<body>

<div class="header">
    <h1>AMERICAN DINE</h1>
</div>

<div class="sidebar">
    <ul>
        <li><a href="home.php" class="active">Home</a></li>
        <li><a href="order_requests.php">Orders</a></li>
    </ul>
    <div class="logout-container">
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</div>

<div class="home">
    <h2>welcome, admin</h2>
    <fieldset>
        <legend>DASHBOARD</legend>
        <div class="box-container">
            <div class="box" id="total-users-box" style="cursor: pointer;">
                <h3>Total Users</h3>
                <p><?php echo htmlspecialchars($totalUsers); ?></p>
            </div>
            <div class="box">
                <h3>Total Food Items</h3>
                <p><?php echo htmlspecialchars($totalFoodItems); ?></p>
            </div>
            <div class="box">
                <h3>Total Pending Requests</h3>
                <p><?php echo htmlspecialchars($totalPendingRequests); ?></p>
            </div>
        </div>
    </fieldset>
</div>

<div id="userModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>User List</h3>
        <table id="userListTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
            
        </table>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> AMERICAN DINE Ltd.</p>
</div>

<script src="../views/js/script.js"></script>

</body>
</html>
