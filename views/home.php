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
    <meta name="viewport" content="qqwidth=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../views/css/style.css"> 
    
    <title>Dashboard</title>
</head>
<body>

<?php include 'partials/employeeHeader.php'; ?>

<div class="sidebar">
    <ul>
        
        <li><a href="../views/home.php" class="<?php echo $current_page == 'home.php' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="../views/order_requests.php" class="<?php echo $current_page == 'order_requests.php' ? 'active' : ''; ?>">Orders</a></li>
    </ul>
    <div class="logout-container">
        <a class="logout-button" href="../controllers/logoutAction.php">Logout</a>
    </div>
</div>


<div class="home">
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
