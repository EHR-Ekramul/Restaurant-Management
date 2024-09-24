<?php

require_once 'controllers/HomeController.php';
require_once 'controllers/OrderController.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    case 'orders':
        $controller = new OrderController();
        $controller->listOrders();
        break;
    case 'accept_order':
        $controller = new OrderController();
        $controller->acceptOrder($_POST['orderId']);
        break;
    case 'reject_order':
        $controller = new OrderController();
        $controller->rejectOrder($_POST['orderId'], $_POST['note']);
        break;
    case 'logout':
        // Handle logout
        break;
    default:
        echo "Page not found.";
}
