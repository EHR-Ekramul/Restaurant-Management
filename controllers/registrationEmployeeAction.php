<?php
session_start();
require "../models/userData.php"; // Ensure this path is correct

// Initialize error variables
$_SESSION["username_error"] = '';
$_SESSION["email_error"] = '';
$_SESSION["phone_error"] = '';
$_SESSION["fullname_error"] = ''; // New error variable
$_SESSION["password_error"] = '';
$_SESSION["registration_error"] = '';

// Initialize input variables
$_SESSION["username"] = '';
$_SESSION["email"] = '';
$_SESSION["phone"] = '';
$_SESSION["fullname"] = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize form inputs
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $fullname = sanitize($_POST['fullname']);
    $password = sanitize($_POST['password']);

    // Store input in session variables
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $email;
    $_SESSION["phone"] = $phone;
    $_SESSION["fullname"] = $fullname;

    // Validate inputs
    if (empty($username)) {
        $_SESSION["username_error"] = "Username is required.";
    } elseif (!preg_match('/^[A-Za-z0-9]+$/', $username)) {
        $_SESSION["username_error"] = "Username can only contain letters and numbers.";
    }

    if (empty($email)) {
        $_SESSION["email_error"] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["email_error"] = "Invalid email format.";
    }

    if (empty($phone)) {
        $_SESSION["phone_error"] = "Phone number is required.";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $_SESSION["phone_error"] = "Phone number must be between 10 to 15 digits.";
    }

    if (empty($fullname)) { // New validation for full name
        $_SESSION["fullname_error"] = "Full name is required.";
    }

    if (empty($password)) {
        $_SESSION["password_error"] = "Password is required.";
    }

    // If there are errors, redirect back to the registration page
    if (!empty($_SESSION["username_error"]) || 
        !empty($_SESSION["email_error"]) || 
        !empty($_SESSION["phone_error"]) || 
        !empty($_SESSION["fullname_error"]) || // Include new error check
        !empty($_SESSION["password_error"])) {
        header("Location: ../views/registrationEmployee.php");
        exit();
    }

    // Check if email, username, or phone already exists in the database
    if (accountExistsByEmail($email)) {
        $_SESSION["email_error"] = "Email already exists.";
    }
    if (fetchUserByUsername($username)) {
        $_SESSION["username_error"] = "Username already exists.";
    }
    if (accountExistsByPhone($phone)) {
        $_SESSION["phone_error"] = "Phone number already exists.";
    }

    // If there are still errors, redirect back to the registration page
    if (!empty($_SESSION["email_error"]) || 
        !empty($_SESSION["username_error"]) || 
        !empty($_SESSION["phone_error"])) {
        header("Location: ../views/registrationEmployee.php");
        exit();
    }

    if (registerUser($username, $email, $phone, $fullname, $password, 'employee')) { // Set role to 'employee'
        // Registration successful, clear input session variables
        unset($_SESSION["username"]);
        unset($_SESSION["email"]);
        unset($_SESSION["phone"]);
        unset($_SESSION["fullname"]);
        unset($_SESSION["username_error"]);
        unset($_SESSION["email_error"]);
        unset($_SESSION["phone_error"]);
        unset($_SESSION["fullname_error"]);
        unset($_SESSION["password_error"]);

        // Registration successful
        header("Location: ../views/login.php");
        exit();
    } else {
        $_SESSION["registration_error"] = "Failed to register user. Please try again.";
    }

    // Redirect back if there's an error
    header("Location: ../views/registrationEmployee.php");
    exit();
}

// Function to sanitize input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
