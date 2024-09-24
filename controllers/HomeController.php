<?php
require_once 'Product.php';

class HomeController {
    public function index() {
        $totalProducts = Product::getTotalProducts();
        $totalOrders = Product::getTotalOrders();
        $totalCustomers = Product::getTotalCustomers();

        include 'views/home.php';
    }
}
