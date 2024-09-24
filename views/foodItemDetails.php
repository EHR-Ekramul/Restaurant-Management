<?php
session_start();
if (!(isset($_COOKIE['user']) || isset($_SESSION['logged_in']))) {
    header("Location: login.php");
    exit();
}

include '../models/foodData.php'; // Include the food data model
$foodItem = null;
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
        /* Address field styling */
        .address-field {
            margin-top: 20px;
        }
        .address-field label {
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }
        .address-field textarea {
            width: 100%;
            min-height: 80px;
            resize: vertical;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
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

                    <!-- Address Field -->
                    <div class="address-field">
                        <label for="delivery-address">Delivery Address:</label>
                        <textarea id="delivery-address" name="deliveryAddress" placeholder="Enter your delivery address"></textarea>
                        <p id="address-error" class="error-message" style="display: none;">Address must be at least 10 characters long.</p>
                    </div>

                    <!-- Checkout Button inside food-info -->
                    <button type="button" class="checkout-button" onclick="validateAndCheckout(<?php echo $itemId; ?>)">Checkout</button>
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
        }

        function validateAndCheckout(itemId) {
            var quantity = document.getElementById('order-quantity').value;
            var address = document.getElementById('delivery-address').value.trim();
            var addressError = document.getElementById('address-error');
            
            // Minimum length for address
            var minAddressLength = 10;
            
            // Check if address is empty or too short
            if (address === "" || address.length < minAddressLength) {
                addressError.style.display = "block";
                return;
            } else {
                addressError.style.display = "none";
            }

            // Confirmation before checkout
            var confirmation = window.confirm(`You are about to order ${quantity} item(s). Do you want to proceed with this order?`);
            
            if (confirmation) {
                // Redirect to checkout
                window.location.href = `../controllers/checkoutAction.php?id=${itemId}&quantity=${quantity}&address=${encodeURIComponent(address)}`;
            }
        }

    </script>

    <?php include "partials/footer.php"; // Include footer ?>
</body>
</html>
