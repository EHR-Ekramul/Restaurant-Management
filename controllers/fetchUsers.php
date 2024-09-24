<?php
require_once '../models/db.php'; 
class UserControl {
    public static function getAllUsers() {
        try {
            $db = Database::connect();
            $query = "SELECT userId, fullName FROM users"; 
            $stmt = $db->query($query);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($users);
        } catch (PDOException $e) {
            
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

header('Content-Type: application/json'); 
UserControl::getAllUsers();
