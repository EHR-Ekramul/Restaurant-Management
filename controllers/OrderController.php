<?php
require_once 'Order.php';

class OrderController {
    public function index() {
        $orders = Order::getAllOrders(); 
        $totalOrders = Order::getTotalOrders(); 
        include 'views/order_requests.php'; 
    }

    public function accept($id) {
        Order::accept($id); 
        header('Location: order_requests.php'); 
    }

    public function reject($id, $note) {
        Order::reject($id, $note); 
        header('Location: order_requests.php'); 
    }
}
