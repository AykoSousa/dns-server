<?php
use Controllers\UserController;

$router = Flight::router();

$router->get('/login', function() {
    if(isset($_SESSION['user'])) {
        Flight::redirect('/panel');
    }

    Flight::render('login');
});

$router->post('/login', function() {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username and password are required.';
        Flight::redirect('/login', 303);
        return;
    }

    $userController = new UserController(Flight::db());
    $user = $userController->getUserByUsernameOrEmail($username, $password);

    if (isset($user['error'])) {
        Flight::redirect('/login?error=1');
        return;
    }

    $_SESSION['user'] = $user;
    Flight::redirect('/panel', 303);
});