<?php
session_start();
if (!(isset($_COOKIE['user']) || isset($_SESSION['logged_in']))) {
    header("Location: login.php");
    exit();
}

include '../models/foodData.php'; // Include your food data model

// Fetch all food items
$foodItems = fetchAllFoodItems();

// Handle search
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchTerm !== '') {
    $foodItems = array_filter($foodItems, function($item) use ($searchTerm) {
        return stripos($item['itemName'], $searchTerm) !== false; // Case-insensitive search
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - All Foods</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .food-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin: 10px 0;
            background-color: #f9f9f9; /* Light gray background */
            border: 1px solid #ddd; /* Light border */
            border-radius: 5px; /* Rounded corners */
        }
        .food-item img {
            width: 100px;
            height: auto;
            margin-right: 15px; /* Space between image and text */
        }
        .food-details {
            flex: 1; /* Allow this section to grow */
            display: flex;
            justify-content: space-between; /* Space out item name and price */
            align-items: center; /* Center vertically */
            color: #333; /* Darker text color for visibility */
        }
        .food-item .btn {
            background-color: green; /* Button color */
            color: white; /* Text color */
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px; /* Rounded button */
            margin-left: 10px; /* Space between price and button */
        }
        .food-item .btn:hover {
            background-color: darkgreen; /* Darker shade on hover */
        }
        .search-container {
            text-align: right;
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-container input[type="submit"] {
            padding: 8px 12px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 5px; /* Space between input and button */
        }
        .search-container input[type="submit"]:hover {
            background-color: darkgreen; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <?php include "partials/header.php"; ?>
    <div class="dashboard-container">
        <?php include "partials/sidebar.php"; ?>
        <main class="main-content">
            <h1 style="text-align: center;">All Foods</h1>
            <p style="text-align: center;">List of all foods available in your restaurant.</p>

            <div class="search-container">
                <form action="" method="GET" style="display: inline-block;">
                    <input type="text" name="search" placeholder="Search for food items..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <input type="submit" value="Search">
                    <input type="button" value="Clear" onclick="window.location.href='dashboardAllFoods.php';" style="padding: 8px 12px; background-color: red; color: white; border: none; border-radius: 4px; margin-left: 5px;">
                </form>
            </div>


            <?php foreach ($foodItems as $item): ?>
                <div class="food-item">
                    <img src="../assets/food_images/<?php echo $item['itemFileName']; ?>" alt="<?php echo $item['itemName']; ?>">
                    <div class="food-details">
                        <strong><?php echo htmlspecialchars($item['itemName']); ?></strong>
                        <span>Price: <?php echo htmlspecialchars($item['itemPrice']); ?> BDT</span>
                    </div>
                    <a href="foodItemDetails.php?id=<?php echo $item['itemId']; ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        </main>
    </div>
    <?php include "partials/footer.php"; ?>
</body>
</html>
