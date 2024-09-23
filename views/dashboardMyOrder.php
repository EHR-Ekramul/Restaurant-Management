<?php
session_start();
if (!(isset($_COOKIE['user']) || isset($_SESSION['logged_in']))) {
    header("Location: login.php");
    exit();
}

include '../models/orderData.php'; // Include your order data model
include '../models/foodData.php'; // Include your food data model

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Fetch all orders for the logged-in user
$userOrders = fetchOrdersByUserId($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - My Orders</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .order-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin: 10px 0;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .order-item img {
            width: 100px;
            height: auto;
            margin-right: 15px;
        }
        .order-details {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #333;
        }
        .order-info {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .order-meta {
            margin-left: 20px;
            flex: 1;
        }
        .order-meta span {
            display: block;
            margin-bottom: 5px;
        }
        .order-status {
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            text-align: center;
            width: 100px;
            margin-left: 15px;
        }
        .status-pending {
            background-color: #e6a08a; /* Badami color */
        }
        .status-completed {
            background-color: green;
        }
        .status-canceled {
            background-color: red;
        }
        .order-feedback {
            margin-top: 5px;
            color: red;
        }
        .filter-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
            background-color: #f1f1f1; /* Light background for contrast */
            padding: 10px;
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .filter-container label {
            margin-right: 10px; /* Spacing between labels and inputs */
            font-weight: bold; /* Bold labels for emphasis */
        }

        .filter-container select,
        .filter-container input[type="date"],
        .filter-container input[type="number"] {
            padding: 8px; /* Padding for inputs */
            margin-right: 15px; /* Spacing between inputs */
            border: 1px solid #ccc; /* Border styling */
            border-radius: 4px; /* Rounded corners */
            font-size: 14px; /* Font size */
        }

        .filter-container input[type="date"] {
            width: 150px; /* Width for date input */
        }

        .filter-container button {
            padding: 8px 15px; /* Padding for button */
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            border: none; /* No border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth transition */
        }

        .filter-container button:hover {
            background-color: #45a049; /* Darker green on hover */
        }


    </style>
</head>
<body>
    <?php include "partials/header.php"; ?>
    <div class="dashboard-container">
        <?php include "partials/sidebar.php"; ?>
        <main class="main-content">
        <h1 style="text-align: center;">My Orders</h1>
        <p style="text-align: center;">Here you can view and track all your orders.</p>

        <div class="filter-container">
            <form action="" method="GET" style="display: inline-block;">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="completed" <?php echo (isset($_GET['status']) && $_GET['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="canceled" <?php echo (isset($_GET['status']) && $_GET['status'] === 'canceled') ? 'selected' : ''; ?>>Canceled</option>
                </select>

                <label for="date">Date:</label>
                <input type="date" name="date" id="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>">

                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" placeholder="Max Amount" value="<?php echo isset($_GET['amount']) ? $_GET['amount'] : ''; ?>">

                <button type="submit">Filter</button>
            </form>
        </div>


        <?php
        // Filter orders based on the selected criteria
        $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
        $dateFilter = isset($_GET['date']) ? $_GET['date'] : '';
        $amountFilter = isset($_GET['amount']) ? $_GET['amount'] : '';

        if (!empty($statusFilter) || !empty($dateFilter) || !empty($amountFilter)) {
            $userOrders = array_filter($userOrders, function ($order) use ($statusFilter, $dateFilter, $amountFilter) {
                $matchesStatus = empty($statusFilter) || $order['orderStatus'] === $statusFilter;
                $matchesDate = empty($dateFilter) || date("Y-m-d", strtotime($order['orderDate'])) === $dateFilter;
                $matchesAmount = empty($amountFilter) || $order['orderAmount'] <= $amountFilter;

                return $matchesStatus && $matchesDate && $matchesAmount;
            });
        }
        ?>

        <?php if (empty($userOrders)): ?>
            <p>No orders found.</p>
        <?php else: ?>
            <?php foreach ($userOrders as $order): 
                // Fetch food item details for each order
                $foodItem = fetchFoodItemById($order['foodItemId']); // Get food item info
            ?>
                <div class="order-item">
                    <img src="../assets/food_images/<?php echo $foodItem['itemFileName']; ?>" alt="<?php echo htmlspecialchars($foodItem['itemName']); ?>">
                    <div class="order-details">
                        <div class="order-info">
                            <strong><?php echo htmlspecialchars($foodItem['itemName']); ?><br><span><?php echo "ID: ".htmlspecialchars($order['orderId']); ?></span></strong> <!-- Food item title and ID -->
                        </div>
                        <div class="order-meta">
                            <span>Date: <?php echo date("d-M-Y", strtotime($order['orderDate'])); ?></span> <!-- Date -->
                            <span>Address: <?php echo htmlspecialchars($order['deliveryAddress']); ?></span> <!-- Delivery address -->
                            <?php if ($order['orderStatus'] == 'canceled'): ?>
                                <span class="order-feedback">Feedback: <?php echo htmlspecialchars($order['orderFeedback']); ?></span> <!-- Order feedback if canceled -->
                            <?php endif; ?>
                        </div>
                        <div class="order-info">
                            <span>Amount: <?php echo htmlspecialchars($order['orderAmount']) . " BDT"; ?></span> <!-- Order amount -->
                        </div>
                    </div>
                    <div class="order-status 
                        <?php 
                            if ($order['orderStatus'] == 'pending') echo 'status-pending'; 
                            elseif ($order['orderStatus'] == 'completed') echo 'status-completed'; 
                            elseif ($order['orderStatus'] == 'canceled') echo 'status-canceled'; 
                        ?>">
                        <?php echo htmlspecialchars(ucfirst($order['orderStatus'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>


    </div>
    <?php include "partials/footer.php"; ?>
</body>
</html>
