<?php

require_once 'db.php';

class Customer {
    public static function getTotalCustomers() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) AS total FROM customers");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
