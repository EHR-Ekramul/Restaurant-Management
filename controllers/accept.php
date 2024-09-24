<?php
require_once '../models/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];

    $db = Database::connect();
    $stmt = $db->prepare("UPDATE orders SET orderStatus = 'completed' WHERE orderId = ?");
    $stmt->execute([$orderId]);

    if ($stmt) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}
?>
