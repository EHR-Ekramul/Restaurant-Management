<?php
session_start();
include '../models/userData.php'; // Include the user data model

// Sanitize function
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $currentPassword = isset($_POST['currentPassword']) ? sanitize($_POST['currentPassword']) : '';
    $newPassword = isset($_POST['newPassword']) ? sanitize($_POST['newPassword']) : '';

    // Initialize error messages
    $_SESSION['pass_error'] = '';
    $_SESSION['newPass_error'] = '';
    $isValid = true; // Flag to track overall validation status

    // Check for empty fields
    if (empty($currentPassword) || empty($newPassword)) {
        if (empty($currentPassword)) {
            $_SESSION['pass_error'] = "Current password is required.";
        }
        if (empty($newPassword)) {
            $_SESSION['newPass_error'] = "New password is required.";
        }
        $isValid = false; // Set flag to false if there are empty fields
    }

    

    // If not valid, redirect back with errors
    if ($isValid) {
        // Fetch user details from the database
        $userInfo = fetchUserById($userId);

        // Check if user is found
        if (!($currentPassword === $userInfo['password'])) {
            $_SESSION['pass_error'] = "Current password is incorrect.";
        }
        elseif ($currentPassword === $newPassword) {
            $_SESSION['newPass_error'] = "New password cannot be the same as the current password.";
        }else{
            // If all checks pass, proceed to update the password
            if (updateUserPassword($userId, $newPassword)) { // Assuming you have a function to update the password
                $_SESSION['pass_success'] = "Password changed successfully.";
                unset($_SESSION['pass_error']);
                unset($_SESSION['newPass_error']);
                header("Location: ../views/dashboardHome.php");
        exit();
            } else {
                $_SESSION['pass_error'] = "Failed to change the password. Please try again.";
            }
        }
        header("Location: ../views/dashboardChangePassword.php");
        exit();
    }
    // Redirect back to the change password page
    header("Location: ../views/dashboardChangePassword.php");
    exit();
}

// Redirect to the change password page if accessed directly
header("Location: ../views/dashboardChangePassword.php");
exit();
?>
