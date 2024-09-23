<?php
session_start();
include '../models/userData.php'; // Include your database connection

$response = [
    'usernameExists' => false,
    'emailExists' => false,
    'phoneExists' => false
];

// Check if the request includes a phone number
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    // Check if the phone number already exists
    $response['phoneExists'] = accountExistsByPhone($phone);
}

// Check if the request includes an email
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    // Check if the email already exists
    $response['emailExists'] = accountExistsByEmail($email);
}

// Check if the request includes a username
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    // Check if the username already exists
    $response['usernameExists'] = fetchUserByUsername($username) !== null; // Assuming this method returns null if not found
}

// Return the response as JSON
echo json_encode($response);

?>
