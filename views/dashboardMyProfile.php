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
    <title>Dashboard - My Profile</title>
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
        .profile-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            max-width: 700px;
            margin: 0 auto;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }
        .profile-container h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }
        .edit-button {
            position: absolute;
            top: 20px;
            right: 30px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-button.cancel {
            background-color: #dc3545;
        }
        .edit-button:hover {
            background-color: #218838;
        }
        .edit-button.cancel:hover {
            background-color: #c82333;
        }
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #007bff;
        }
        .profile-info {
            margin-top: 20px;
            width: 100%;
        }
        .profile-info input, .profile-info span {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            color: #555;
        }
        .profile-info input[readonly], .profile-info input[disabled] {
            background-color: #f8f9fa;
        }
        .save-button {
            display: none;
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .save-button:hover {
            background-color: #0056b3;
        }
        .save-button.active {
            display: inline-block;
        }
        .profile-info input:focus {
            border-color: #007bff;
            outline: none;
        }
        .profile-container h2 {
            color: #555;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .profile-container p {
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php include "partials/header.php"; ?>
    <div class="dashboard-container">
        <?php include "partials/sidebar.php"; ?>
        <main class="main-content">
            <div class="profile-container">
                <h1>My Profile</h1>
                <!-- Edit Profile Button -->
                <button id="editProfileButton" class="edit-button">Edit Profile</button>

                <!-- Profile Image -->
                <img src="../assets/user_profile/<?php echo htmlspecialchars($userInfo['profileFileName']); ?>" alt="Profile Image" class="profile-image">

                <!-- Username and User ID -->
                <h2><?php echo htmlspecialchars($userInfo['username']); ?></h2>
                <p>User ID: <?php echo htmlspecialchars($userInfo['userId']); ?></p>

                <!-- Profile Info Section -->
                <form action="../controllers/updateProfileAction.php" method="POST" id="profileForm" novalidate>
                    <div class="profile-info">
                        <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($userInfo['fullName']); ?>" readonly>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>" readonly>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($userInfo['phoneNumber']); ?>" readonly>
                        <input type="text" name="userStatus" value="Status: <?php echo htmlspecialchars($userInfo['userStatus']); ?>" readonly disabled>
                        <input type="text" name="created_at" value="Joined: <?php echo date('d-M-Y', strtotime($userInfo['created_at'])); ?>" readonly disabled>

                        <!-- Save Button -->
                        <button type="submit" id="saveButton" class="save-button">Update Profile</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <?php include "partials/footer.php"; ?>

    <script>
        const editButton = document.getElementById('editProfileButton');
        const saveButton = document.getElementById('saveButton');
        const editableFields = document.querySelectorAll('.profile-info input:not([disabled])');
        
        const fullName = document.getElementById('fullName');
        const email = document.getElementById('email');
        const phoneNumber = document.getElementById('phoneNumber');

        editButton.addEventListener('click', function() {
            const isEditing = editButton.classList.contains('cancel');

            if (isEditing) {
                // Cancel editing: disable inputs and hide the save button
                editableFields.forEach(field => field.readOnly = true);
                editButton.textContent = 'Edit Profile';
                editButton.classList.remove('cancel');
                saveButton.classList.remove('active');

                fullName.value = '<?php echo htmlspecialchars($userInfo['fullName']); ?>';
                email.value = '<?php echo htmlspecialchars($userInfo['email']); ?>';
                phoneNumber.value = '<?php echo htmlspecialchars($userInfo['phoneNumber']); ?>';
            } else {
                // Enable editing: enable inputs and show the save button
                editableFields.forEach(field => field.readOnly = false);
                editButton.textContent = 'Cancel';
                editButton.classList.add('cancel');
                saveButton.classList.add('active');
            }
        });
    </script>
</body>
</html>
