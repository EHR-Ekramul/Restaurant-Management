<?php
// Fetch all orders
function fetchAllOrders() {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM orders";
    $result = mysqli_query($conn, $sql);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

    // Close the connection
    mysqli_close($conn);
    
    return $orders;
}

// Fetch order info by order ID
function fetchOrderById($orderId) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM orders WHERE orderId = '$orderId'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_fetch_assoc($result);
}

// Fetch orders by user ID
function fetchOrdersByUserId($userId) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM orders WHERE userId = '$userId'";
    $result = mysqli_query($conn, $sql);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

    // Close the connection
    mysqli_close($conn);
    
    return $orders;
}

// Fetch orders by order status
function fetchOrdersByStatus($orderStatus) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM orders WHERE orderStatus = '$orderStatus'";
    $result = mysqli_query($conn, $sql);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

    // Close the connection
    mysqli_close($conn);
    
    return $orders;
}

// Fetch orders by food item ID
function fetchOrdersByFoodItemId($foodItemId) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM orders WHERE foodItemId = '$foodItemId'";
    $result = mysqli_query($conn, $sql);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

    // Close the connection
    mysqli_close($conn);
    
    return $orders;
}

// Insert a new order into the orders table
function insertOrder($userId, $foodItemId, $orderDate, $orderQuantity, $orderAmount, $deliveryAddress, $orderStatus) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL query to insert the order
    $sql = "INSERT INTO orders (userId, foodItemId, orderDate, orderQuantity, orderAmount, deliveryAddress, orderStatus) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters to the query (integer and string types)
        mysqli_stmt_bind_param($stmt, "iisiiss", $userId, $foodItemId, $orderDate, $orderQuantity, $orderAmount, $deliveryAddress, $orderStatus);
        
        // Execute the prepared statement
        $result = mysqli_stmt_execute($stmt);
        
        // Close the statement
        mysqli_stmt_close($stmt);
        
        // Close the connection
        mysqli_close($conn);

        // Return true if the query executed successfully, false otherwise
        return $result;
    } else {
        mysqli_close($conn);
        return false;
    }
}


?>
