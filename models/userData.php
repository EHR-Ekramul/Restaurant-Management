<?php
// Fetch all user info based on username
function fetchUserByUsername($username) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_fetch_assoc($result);
}

function updateUserPassword($userId, $newPassword) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to update the password
    $sql = "UPDATE users SET password = '$newPassword' WHERE userId = '$userId'";
    
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        return true; // Return true if the update was successful
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        mysqli_close($conn);
        return false; // Return false if there was an error
    }
}

// Fetch all user info based on ID
function fetchUserById($id) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE userId = '$id'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_fetch_assoc($result);
}

// Check if an account exists for an email
function accountExistsByEmail($email) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_num_rows($result) > 0;
}
function accountExistsByEmailWithoutID($email, $userId) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE email = '$email' and userId <> $userId";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_num_rows($result) > 0;
}

// Check if an account exists for a phone number
function accountExistsByPhone($phone) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE phoneNumber = '$phone'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_num_rows($result) > 0;
}
function accountExistsByPhoneWithoutID($phone, $userId) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE phoneNumber = '$phone' and userId <> $userId";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_num_rows($result) > 0;
}

function registerUser($username, $email, $phone, $fullname, $password, $role) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO users (username, email, phoneNumber, fullName, password, userRole) VALUES ('$username', '$email', '$phone', '$fullname', '$password', '$role')";
    
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        mysqli_close($conn);
        return false;
    }
}

function updateUserProfile($userId, $fullName, $email, $phoneNumber) {
    $conn = mysqli_connect("localhost", "root", "", "restaurant");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement
    $sql = "UPDATE users SET fullName = '$fullName', email = '$email', phoneNumber = '$phoneNumber' WHERE userId = $userId";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        return true; // Indicate success
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        mysqli_close($conn);
        return false; // Indicate failure
    }
}


?>
