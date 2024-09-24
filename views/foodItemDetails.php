<?php
session_start();
if (!(isset($_COOKIE['user']) || isset($_SESSION['logged_in']))) {
    header("Location: login.php");
    exit();
}

include '../models/foodData.php'; // Include the food data model
$foodItem=null;
// Fetch food item details based on the ID passed in the URL
if (isset($_GET['id'])) {
    $itemId = intval($_GET['id']);
    $foodItem = fetchFoodItemById($itemId); // This function should fetch food details based on ID
} else {
    // Redirect to an error page or handle the error as necessary
    header("Location: dashboardAllFoods.php");
    exit();
}

include "partials/header.php"; // Include header
include "partials/sidebar.php"; // Include sidebar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Item Details</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            display: flex;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .food-details {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            margin: 0 auto;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%; /* Full width */
            display: flex; /* Use flexbox */
        }
        .food-image {
            flex: 1; /* Take up available space */
            margin-right: 20px; /* Space between image and details */
        }
        .food-image img {
            width: 100%; /* Full width of the container */
            height: auto;
            border-radius: 10px;
        }
        .food-info {
            flex: 1; /* Take up available space */
            display: flex;
            flex-direction: column; /* Arrange children in a column */
        }
        .food-info h2 {
            color: #333;
            margin: 0; /* Reset margin */
        }
        .food-info p {
            color: #555;
            margin: 10px 0;
        }
        .quantity-controls {
            margin-top: auto; /* Push quantity controls to the bottom */
        }
        .quantity-controls button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .quantity-controls button:hover {
            background-color: #0056b3;
        }
        .quantity-controls input {
            width: 50px;
            text-align: center;
            margin: 0 10px;
        }
        .checkout-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 20px; /* Space from the above content */
        }
        .checkout-button:hover {
            background-color: #218838;
        }
        .breadcrumb {
            margin-bottom: 20px; /* Space below breadcrumb */
        }
        .product-title {
            font-size: 30px;
            display: flex;
            align-items: center;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px; /* Space below product title */
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
        <h2 class="product-title">Food Item Details</h2> <!-- Product Details Heading -->

            <!-- Navigation Breadcrumb -->
            <nav class="breadcrumb">
                <a href="dashboardAllFoods.php">All Foods</a> > Details
            </nav>
            <div class="food-details">
                
                <div class="food-image">
                    <img src="../assets/food_images/<?php echo $foodItem['itemFileName']; ?>" alt="<?php echo htmlspecialchars($foodItem['itemName']); ?>">
                </div>

                <div class="food-info">
                    <h2><?php echo htmlspecialchars($foodItem['itemName']); ?></h2>
                    <p><?php echo htmlspecialchars($foodItem['itemDescription']); ?></p>
                    <p>Available Quantity: <strong><?php echo htmlspecialchars($foodItem['itemQuantity']); ?></strong></p>
                    <p style="float: right;">
                        Price: <strong>BDT <?php echo number_format($foodItem['itemPrice'], 2); ?></strong>
                    </p>

                    <div style="clear: both;" class="quantity-controls">
                        <label for="order-quantity">Order Quantity:</label>
                        <button type="button" onclick="changeQuantity(-1)">-</button>
                        <input type="number" id="order-quantity" value="1" min="1" max="<?php echo htmlspecialchars($foodItem['itemQuantity']); ?>">
                        <button type="button" onclick="changeQuantity(1)">+</button>
                    </div>

                    <!-- Checkout Button inside food-info -->
                    <form action="checkout.php" method="POST">
                        <input type="hidden" name="itemId" value="<?php echo $itemId; ?>">
                        <input type="hidden" name="orderQuantity" id="orderQuantityInput" value="1">
                        <!-- Checkout Button -->
                    <button type="button" class="checkout-button" 
                        onclick="redirectToCheckout(<?php echo $itemId; ?>)">Checkout</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function changeQuantity(amount) {
            var quantityInput = document.getElementById('order-quantity');
            var currentValue = parseInt(quantityInput.value);
            var maxQuantity = parseInt(quantityInput.max);

            // Update quantity based on the button clicked
            if (amount === 1 && currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
            } else if (amount === -1 && currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
            if(currentValue > maxQuantity){
                quantityInput.value = maxQuantity;
            }
        }
        function redirectToCheckout(itemId) {
            var quantity = document.getElementById('order-quantity').value;
            window.location.href = `checkout.php?id=${itemId}&quantity=${quantity}`;
        }
    </script>

    <?php include "partials/footer.php"; // Include footer ?>
</body>
</html>
