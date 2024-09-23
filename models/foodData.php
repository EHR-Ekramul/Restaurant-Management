<?php
// Fetch all food items
function fetchAllFoodItems() {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM food_items";
    $result = mysqli_query($conn, $sql);
    
    $foodItems = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $foodItems[] = $row;
    }

    // Close the connection
    mysqli_close($conn);
    
    return $foodItems;
}

// Fetch food item info by food ID
function fetchFoodItemById($foodId) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM food_items WHERE itemId = '$foodId'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_fetch_assoc($result);
}

// Update quantity of an item based on ID
function updateFoodQuantity($foodId, $newQuantity) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE food_items SET itemQuantity = '$newQuantity' WHERE itemId = '$foodId'";
    
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        mysqli_close($conn);
        return false;
    }
}
?>
