<?php
use Controllers\DNSDomainController;

$router = Flight::router();

$router->post('/domains', function() {
    $user = $_SESSION['user'];
    if (!$user) {
        Flight::redirect('/login');
    }

    $domain = $_POST['domain'];

    if (empty($domain)) {
        $_SESSION['error'] = 'Domain cannot be empty';
        return;
    }

    $controller = new DNSDomainController(Flight::db());
    $result = $controller->addDomain($domain);

    if (isset($result['error'])) {
        $_SESSION['error'] = $result['message'];
        return;
    }
    
    $_SESSION['success'] = $result['message'];

    Flight::redirect('/panel', 303);

});

$router->post('/domains/delete', function() {
    $user = $_SESSION['user'];
    if (!$user) {
        Flight::redirect('/login');
    }

    $domainId = $_POST['domainId'];

    $controller = new DNSDomainController(Flight::db());
    $result = $controller->removeDomain($domainId);

    if (isset($result['error'])) {
        $_SESSION['error'] = $result['message'];
        return;
    }
    
    $_SESSION['success'] = $result['message'];

    Flight::redirect('/panel', 303);

});