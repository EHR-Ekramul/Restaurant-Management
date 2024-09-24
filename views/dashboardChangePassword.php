<?php
session_start();
if (!(isset($_COOKIE['user']) || isset($_SESSION['logged_in']))) {
    header("Location: login.php");
    exit();
}

include '../models/userData.php'; // Include the user data model

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Fetch user details by userId from the database
$userInfo = fetchUserById($userId);

if (!$userInfo) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Change Password</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* Add your CSS styles here */
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
        .change-password-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            max-width: 700px;
            margin: 0 auto;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #007bff;
        }
        .username {
            font-size: 24px;
            color: #333;
            margin: 10px 0;
        }
        .user-id {
            font-size: 16px;
            color: #888;
            margin-bottom: 20px;
        }
        .change-password-form input {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .change-password-button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .change-password-button:hover {
            background-color: #0056b3;
        }
        .change-password-container h1 {
            padding: 20px 0;
        }
    </style>
    <script>
        function validateForm(event) {
            // Prevent the form from submitting
            event.preventDefault();

            // Get input values
            var currentPassword = document.querySelector('input[name="currentPassword"]').value;
            var newPassword = document.querySelector('input[name="newPassword"]').value;

            // Reset error messages
            document.getElementById('dcpasserr').textContent = '';
            document.getElementById('dccpasserr').textContent = '';

            // Validation checks
            if (currentPassword.trim() === '' || newPassword.trim() === '') {
                if (currentPassword.trim() === '') {
                    document.getElementById('dcpasserr').textContent = 'Current Password is required.';
                }
                if (newPassword.trim() === '') {
                    document.getElementById('dccpasserr').textContent = 'New Password is required.';
                }
                return; // Stop if validation fails
            }

            if (currentPassword === newPassword) {
                document.getElementById('dccpasserr').textContent = 'New Password must be different from Current Password.';
                return; // Stop if validation fails
            }

            // AJAX call to check current password
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../controllers/checkCurrentPassword.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // If current password is correct, submit the form
                        document.querySelector('.change-password-form').submit();
                    } else {
                        // Show error if current password is incorrect
                        document.getElementById('dcpasserr').textContent = response.message;
                    }
                }
            };
            xhr.send("currentPassword=" + encodeURIComponent(currentPassword));
        }
    </script>
</head>
<body>
    <?php include "partials/header.php"; ?>
    <div class="dashboard-container">
        <?php include "partials/sidebar.php"; ?>
        <main class="main-content">
            <div class="change-password-container">
                <h1>Change Password</h1>
                <!-- Profile Image -->
                <img src="../assets/user_profile/<?php echo htmlspecialchars($userInfo['profileFileName']); ?>" alt="Profile Image" class="profile-image">

                <!-- Username and User ID -->
                <h2 class="username"><?php echo htmlspecialchars($userInfo['username']); ?></h2>
                <p class="user-id">User ID: <?php echo htmlspecialchars($userInfo['userId']); ?></p>

                <!-- Change Password Form -->
                <form action="../controllers/changePasswordAction.php" method="POST" class="change-password-form" novalidate onsubmit="validateForm(event)">
                    <input type="password" name="currentPassword" placeholder="Current Password" required>
                    <span id="dcpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["pass_error"]) ? "" : $_SESSION["pass_error"]; ?></span>
                    <input type="password" name="newPassword" placeholder="New Password" required>
                    <span id="dccpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["confirmPass_error"]) ? "" : $_SESSION["confirmPass_error"]; ?></span>
                    <button type="submit" class="change-password-button">Change Password</button>
                </form>
            </div>
        </main>
    </div>
    <?php include "partials/footer.php"; ?>
</body>
</html>
