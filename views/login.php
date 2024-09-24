<?php
session_start(); 
require "../models/userData.php";
if(isset($_SESSION["logged_in"])&& $_SESSION['logged_in'] && isset($_COOKIE["user"])){
    $result = fetchUserById($_COOKIE["user"]);
    if($result["userRole"] == "customer"){
        header("Location: dashboardHome.php");
    } else {
        header("Location: employeeDashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">

    <!-- Link to external JavaScript file -->
    <script src="js/login.js"></script>
</head>

<body>
    <div class="container">
        <form action="../controllers/loginAction.php" method="POST" novalidate class="login-form" onsubmit="return isValid(this)">
            <h2>Login</h2>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <span id="lusernameerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["username_error"]) ? "" : $_SESSION["username_error"]; ?></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span id="lpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["password_error"]) ? "" : $_SESSION["password_error"]; ?></span>
            </div>

            <div class="form-group remember-me" style="display: flex; align-items: bottom; margin-bottom: 15px;">
                <input type="checkbox" id="remember" name="remember" style="margin-right: -160px; margin-left: -170px">
                <label for="remember" style="color: #555;">Remember Me</label>
            </div>




            <button type="submit">Login</button>

            <!-- Error message -->
            <p class="error-message" style="color: red;"><?php echo empty($_SESSION["login_page_error"]) ? "" : $_SESSION["login_page_error"]; ?></p>

            <!-- Forgot password Link -->
            <!-- <p class="forgot-password-text"><a href="forgot.php">Forgot Password?</a></p> -->

            <!-- Link to registration page -->
            <p class="register-text">Don't have an account? <a href="registration.php">Register</a></p>
        </form>
    </div>
</body>

</html>
