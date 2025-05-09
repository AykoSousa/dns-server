<?php
session_start();

use Controllers\DNSDomainController;

$router = Flight::router();

$router->get('/panel', function() {
    if (!isset($_SESSION['user'])) {
        Flight::redirect('/login');
        return;
    }

    $controller = new DNSDomainController(Flight::db());
    $domains = $controller->getAllDomains();
    Flight::render('index', ['domains' => $domains]);
});