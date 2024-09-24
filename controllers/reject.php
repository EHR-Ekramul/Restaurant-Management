<?php
require_once '../models/db.php'; 
require_once '../models/order.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $note = $_POST['note'];

    // Update order status and add feedback
    $db = Database::connect();
    $stmt = $db->prepare("UPDATE orders SET orderStatus = 'canceled', orderFeedback = :feedback WHERE orderId = :orderId");
    $stmt->bindParam(':feedback', $note);
    $stmt->bindParam(':orderId', $orderId);
    
    if ($stmt->execute()) {
        echo "Order rejected successfully.";
    } else {
        echo "Error rejecting order.";
    }
}
?>
