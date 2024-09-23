<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Registration</title>
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/registration.js"></script>

  <script>
    $(document).ready(function () {
      $('#username').on('blur', function () {
        var username = $(this).val();
        $.ajax({
          type: "POST",
          url: "../controllers/checkRegistrationData.php",
          data: { username: username },
          dataType: "json",
          success: function (response) {
            if (response.usernameExists) {
              $('#rusererr').text('Username already exists.');
            } else {
              $('#rusererr').text('');
            }
          }
        });
      });

      $('#email').on('blur', function () {
        var email = $(this).val();
        $.ajax({
          type: "POST",
          url: "../controllers/checkRegistrationData.php",
          data: { email: email },
          dataType: "json",
          success: function (response) {
            if (response.emailExists) {
              $('#remailerr').text('Email already exists.');
            } else {
              $('#remailerr').text('');
            }
          }
        });
      });

      $('#phone').on('blur', function () {
        var phone = $(this).val();
        $.ajax({
          type: "POST",
          url: "../controllers/checkRegistrationData.php",
          data: { phone: phone },
          dataType: "json",
          success: function (response) {
            if (response.phoneExists) {
              $('#rphoneerr').text('Phone number already exists.');
            } else {
              $('#rphoneerr').text('');
            }
          }
        });
      });
    });
  </script>

<style>
    .role-buttons {
      display: flex;
      margin-bottom: 20px;
    }

    .role-button {
      flex: 1; /* Make buttons take equal width */
      padding: 15px; /* Adjust padding for better height */
      background-color: #f0f0f0;
      border: none; /* Remove default borders */
      cursor: pointer;
      text-align: center;
      position: relative; /* For positioning the bottom border */
      transition: background-color 0.3s; /* Smooth transition */
    }

    .role-button:hover {
      background-color: #e0e0e0; /* Change background on hover */
    }

    .role-button.active {
      color: #333; /* Text color for active button */
    }

    .role-button.active::after {
      content: "";
      display: block;
      width: 100%;
      height: 3px; /* Height of the indicator */
      background-color: #333; /* Color of the indicator */
      position: absolute;
      bottom: -3px; /* Position just below the button */
      left: 0; /* Align to the left */
    }
  </style>

</head>

<body>
  <div class="container">
    <div class="role-buttons">
      <a class="role-button active" href="registration.php">Be a Customer</a>
      <a class="role-button" href="registrationEmployee.php">Be an Employee</a>
    </div>

    <form action="../controllers/registrationAction.php" method="POST" novalidate onsubmit="return isValid(this)" class="registration-form">
      <h2>Register as Customer</h2>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?php echo empty($_SESSION["username"]) ? "" : $_SESSION["username"]; ?>" required>
      <span id="rusererr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["username_error"]) ? "" : $_SESSION["username_error"]; ?></span>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo empty($_SESSION["email"]) ? "" : $_SESSION["email"]; ?>" required>
      <span id="remailerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["email_error"]) ? "" : $_SESSION["email_error"]; ?></span>

      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" value="<?php echo empty($_SESSION["phone"]) ? "" : $_SESSION["phone"]; ?>" required>
      <span id="rphoneerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["phone_error"]) ? "" : $_SESSION["phone_error"]; ?></span>

      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname" value="<?php echo empty($_SESSION["fullname"]) ? "" : $_SESSION["fullname"]; ?>" required>
      <span id="rnameerr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["fullname_error"]) ? "" : $_SESSION["fullname_error"]; ?></span>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <span id="rpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"></span>

      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      <span id="rcpasserr" style="color: red; font-size: 12px; display: block; margin-bottom: 7px;"><?php echo empty($_SESSION["password_error"]) ? "" : $_SESSION["password_error"]; ?></span>

      <button type="submit">Register</button>

      <p class="login-text">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>

</html>
