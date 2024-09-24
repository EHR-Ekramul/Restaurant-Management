<?php
require_once '../models/db.php'; 

class UserControl {
    public static function getTotalUsers() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) AS total FROM users");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    ///////////// Get total number of food items
    public static function getTotalFoodItems() {
        $db = Database::connect();
        $stmt = $db->query("SELECT COUNT(*) AS total FROM food_items"); 
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    ///////////// Get total number of pending requests
public static function getTotalPendingRequests() {
    $db = Database::connect();
    $stmt = $db->query("SELECT COUNT(*) AS total FROM orders WHERE orderStatus = 'pending'"); 
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}


 

}
