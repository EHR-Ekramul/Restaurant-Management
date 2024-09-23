<?php
session_start();
require "../models/userData.php"; // Make sure this path is correct

// Initialize variables
$_SESSION["username_error"] = '';
$_SESSION["password_error"] = '';
$_SESSION["login_page_error"] = '';
$_SESSION["logged_in"] = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize form inputs
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);
    $remember = isset($_POST['remember']);

    // Validate inputs
    if (empty($username)) {
        $_SESSION["username_error"] = "Username is required.";
    }
    if (empty($password)) {
        $_SESSION["password_error"] = "Password is required.";
    }

    // If there are errors, redirect back to the login page
    if (!empty($_SESSION["username_error"]) || !empty($_SESSION["password_error"])) {
        header("Location: ../views/login.php");
        exit();
    }

    // Validate against the database
    $result = fetchUserByUsername($username); // Assuming this function returns user info or false

    if (!$result || !($password === $result['password'])) { // Use password_verify for hashed passwords
        $_SESSION["login_page_error"] = "Invalid username or $password . {$result['password']}";
        header("Location: ../views/login.php");
        exit(); // Ensure no further code is executed
    } else {
        // If the user is valid, set the cookie if "Remember Me" is checked
        if ($remember) {
            setcookie("user", $result['userId'], time() + (30 * 24 * 60 * 60), "/");
        }

        // Clear error messages
        unset($_SESSION["username_error"]);
        unset($_SESSION["password_error"]);
        unset($_SESSION["login_page_error"]);
        $_SESSION["logged_in"] = true;

        // Redirect to dashboard
        if($result['userRole'] == 'customer'){
            header("Location: ../views/dashboardHome.php");
        } else {
            header("Location: ../views/employeeDashboard.php");
        }
        exit();
    }
}

// Function to sanitize input
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
