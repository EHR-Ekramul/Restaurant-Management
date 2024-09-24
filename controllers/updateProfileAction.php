<?php
session_start();
include '../models/userData.php'; // Include the user data model

$_SESSION["pfullName_error"] = "";
$_SESSION["email_error"] = "";
$_SESSION["phone_error"] = "";
$userId = $_SESSION['user_id'];
$isValid = true; // Validation flag

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input fields
    $fullName = sanitizeInput($_POST['fullName']);
    $email = sanitizeInput($_POST['email']);
    $phoneNumber = sanitizeInput($_POST['phoneNumber']);
    
    // Validate empty fields
    if (empty($fullName)) {
        $_SESSION["pfullName_error"] = "Full Name is required.";
        $isValid = false; // Set validation flag to false
    }
    
    if (empty($email)) {
        $_SESSION["email_error"] = "Email is required.";
        $isValid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["email_error"] = "Invalid email format.";
        $isValid = false;
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        $_SESSION["email_error"] = "Invalid email format.";
        $isValid = false;
    }
    
    if (empty($phoneNumber)) {
        $_SESSION["phone_error"] = "Phone Number is required.";
        $isValid = false;
    } elseif (!preg_match("/^[0-9]{10,14}$/", $phoneNumber)) { // Allow 10 to 14 digits only
        $_SESSION["phone_error"] = "Invalid phone number format. Must be 10 to 14 digits.";
        $isValid = false;
    }
    
    

    // Check for errors
    if ($isValid) {
        // Get the current email from the database
        $currentUserInfo = fetchUserById($userId);
        $isValid2 = true; // Validation flag

        // Check if email or phone number exists in the database
        if (accountExistsByEmailWithoutID($email, $userId)) {
            $_SESSION["email_error"] = "Email already exists.";
            $isValid2 = false;
        }
        if (accountExistsByPhoneWithoutID($phoneNumber, $userId)) {
            $_SESSION["phone_error"] = "Phone number already exists.";
            $isValid2 = false;
        }
        if($isValid2){
            // Update user information if all validations pass
            if(updateUserProfile($userId, $fullName, $email, $phoneNumber)){
                header("Location: ../views/dashboardHome.php");
                exit();
            } else {
                echo "Error updating record";
            }
        }else{
            header("Location: ../views/dashboardMyProfile.php");
            exit();
        }
    }else{
        header("Location: ../views/dashboardMyProfile.php");
        exit();
    }
}


// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}
?>
