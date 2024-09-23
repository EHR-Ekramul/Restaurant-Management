<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant"; // Change to your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all user info based on username
function fetchUserByUsername($username) {
    global $conn;
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_fetch_assoc($result);
}

// Fetch all user info based on ID
function fetchUserById($id) {
    global $conn;
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_fetch_assoc($result);
}

// Check if an account exists for an email
function accountExistsByEmail($email) {
    global $conn;
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_num_rows($result) > 0;
}

// Check if an account exists for a phone number
function accountExistsByPhone($phone) {
    global $conn;
    $sql = "SELECT * FROM users WHERE phone = '$phone'";
    $result = mysqli_query($conn, $sql);
    
    // Close the connection
    mysqli_close($conn);
    
    return mysqli_num_rows($result) > 0;
}
?>
