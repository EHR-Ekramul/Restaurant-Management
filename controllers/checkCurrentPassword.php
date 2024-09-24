<?php
session_start();
include '../models/userData.php'; // Include the user data model

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user ID from the session
    $userId = $_SESSION['user_id'];
    
    // Sanitize the input
    $currentPassword = sanitize($_POST['currentPassword']);
    
    // Fetch user details from the database
    $userInfo = fetchUserById($userId);

    // Check if the current password matches the one in the database
    if ($userInfo && ($currentPassword=== $userInfo['password'])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
    }
}

// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
