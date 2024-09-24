<?php

require_once '../models/db.php';

class Order {
    public static function getTotalOrders() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) AS total FROM orders");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function getAllOrders() {
        $db = Database::connect();
        $stmt = $db->query("SELECT o.orderId, u.fullName AS user_name, f.itemName AS item_name, f.itemFileName AS item_image 
                            FROM orders o
                            JOIN users u ON o.userId = u.userId
                            JOIN food_items f ON o.foodItemId = f.itemId
                            WHERE o.orderStatus = 'pending'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function accept($orderId) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE orders SET orderStatus = 'accepted' WHERE orderId = ?");
        $stmt->execute([$orderId]);
    }

    public static function reject($orderId, $note) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE orders SET orderStatus = 'rejected', note = ? WHERE orderId = ?");
        $stmt->execute([$note, $orderId]);
    }
}
