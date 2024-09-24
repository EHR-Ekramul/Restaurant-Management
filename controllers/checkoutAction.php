<?php
session_start();

// Check if the user is logged in
if (!(isset($_COOKIE['user']) || isset($_SESSION['logged_in']))) {
    header("Location: ../views/login.php");
    exit();
}

include '../models/foodData.php'; // Include the food data model
include '../models/orderData.php'; // Include the order data model

// Get the user_id from the session (assuming user_id is stored in session)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}
$userId = $_SESSION['user_id'];

// Get data from the URL
if (isset($_GET['id']) && isset($_GET['quantity']) && isset($_GET['address'])) {
    $foodItemId = intval($_GET['id']); // Food item ID
    $orderQuantity = intval($_GET['quantity']); // Order quantity
    $deliveryAddress = htmlspecialchars(trim($_GET['address'])); // Delivery address (sanitize input)
} else {
    header("Location: ../views/dashboardAllFoods.php?error=missing_data");
    exit();
}

// Fetch the food item details from the database by item ID
$foodItem = fetchFoodItemById($foodItemId);
if (!$foodItem) {
    header("Location: ../views/dashboardAllFoods.php?error=item_not_found");
    exit();
}

// Check if sufficient quantity is available
if ($foodItem['itemQuantity'] < $orderQuantity) {
    header("Location: ../views/foodItemDetails.php?id=$foodItemId&error=insufficient_quantity");
    exit();
}

// Calculate the total order amount (price * quantity)
$orderAmount = $foodItem['itemPrice'] * $orderQuantity;

// Get the current date (order date)
$orderDate = date('Y-m-d H:i:s');

// Set the default order status
$orderStatus = 'pending';

// Insert the order into the `orders` table using orderData.php model
$insertResult = insertOrder($userId, $foodItemId, $orderDate, $orderQuantity, $orderAmount, $deliveryAddress, $orderStatus);

if ($insertResult) {
    // Decrease the food item quantity in the database
    $newQuantity = $foodItem['itemQuantity'] - $orderQuantity;
    $updateQuantityResult = updateFoodQuantity($foodItemId, $newQuantity);
    
    if ($updateQuantityResult) {
        // Redirect to the order page with a success message
        header("Location: ../views/dashboardMyOrder.php?order_success=1");
        exit();
    } else {
        // Handle quantity update error
        header("Location: ../views/foodItemDetails.php?id=$foodItemId&error=quantity_update_failed");
        exit();
    }
} else {
    // Handle insertion error
    header("Location: ../views/foodItemDetails.php?id=$foodItemId&error=order_failed");
    exit();
}
