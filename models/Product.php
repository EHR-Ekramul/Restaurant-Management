<?php
require_once 'db.php';

class Product {
    public static function getTotalProducts() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) AS total FROM products");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function getTotalOrders() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) AS total FROM orders"); // Adjust table name if necessary
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function getTotalCustomers() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) AS total FROM customers"); // Adjust table name if necessary
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
