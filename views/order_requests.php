<?php
require_once '../models/order.php'; 
require_once '../controllers/usercontroller.php'; 
$orders = Order::getAllOrders(); 

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../views/css/style.css"> 
    <title>Orders</title>
</head>
<body>

<div class="header">
    <h1>AMERICAN DINE</h1>
</div>

<div class="sidebar">
    <ul>
        
        <li><a href="../views/home.php" class="<?php echo $current_page == 'home.php' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="../views/order_requests.php" class="<?php echo $current_page == 'order_requests.php' ? 'active' : ''; ?>">Orders</a></li>
    </ul>
    <div class="logout-container">
        <a class="logout-button" href="../logout.php">Logout</a>
    </div>
</div>

<div class="order-requests">
    <fieldset>
        <legend>Pending Orders</legend>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Item</th>
                <th>Action</th>
                <th>Notes</th>
            </tr>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['orderId']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_name'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($order['item_name'] ?? 'N/A'); ?></td>
                    <td>
                        <button onclick="acceptOrder(<?php echo $order['orderId']; ?>)">Accept</button>
                        <button onclick="rejectOrder(<?php echo $order['orderId']; ?>)">Reject</button>
                    </td>
                    <td>
                        <textarea id="note-<?php echo $order['orderId']; ?>" placeholder="Add rejection note here..."></textarea>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No pending orders found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </fieldset>
</div>

<div class="footer">
    <p>&copy; <?php echo date('Y'); ?> AMERICAN DINE Ltd.</p>
</div>

<script src="../views/js/script.js"></script>

</body>
</html>
