<?php
session_start();
include '../models/userData.php'; // Include the user data model

// Get the email and phone number from the AJAX request
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';

// Initialize response array
$response = [
    'emailExists' => false,
    'phoneExists' => false,
];

// Check if email exists in the database
if (!empty($email)) {
    $response['emailExists'] = accountExistsByEmail($email); // Implement this function in your userData.php
}

// Check if phone number exists in the database
if (!empty($phoneNumber)) {
    $response['phoneExists'] = accountExistsByPhone($phoneNumber); // Implement this function in your userData.php
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
