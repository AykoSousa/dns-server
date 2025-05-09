<?php
use Controllers\UserController;

$router = Flight::router();

$router->get('/register', function() {
    Flight::render('register');
});

$router->post('/register', function() {
    $username = Flight::request()->data->username;
    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;

    if (empty($username) || empty($email) || empty($password)) {
        Flight::json(['error' => true, 'message' => 'All fields are required'], 400);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Flight::json(['error' => true, 'message' => 'Invalid email format'], 400);
        return;
    }

    if (strlen($password) < 6) {
        Flight::json(['error' => true, 'message' => 'Password must be at least 6 characters long'], 400);
        return;
    }

    if (strlen($username) < 3) {
        Flight::json(['error' => true, 'message' => 'Username must be at least 3 characters long'], 400);
        return;
    }

    $userController = new UserController(Flight::db());
    $newUser = $userController->createUser($username, $email, $password);

    if (isset($newUser['error'])) {
        Flight::json(['error' => true, 'message' => $newUser['message']], 500);
    } else {
        Flight::json(['success' => true, 'user' => $newUser], 201);
    }
});