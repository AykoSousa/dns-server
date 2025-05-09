<?php

$router = Flight::router();

$router->get('/logout', function() {
    unset($_SESSION['user']);
    unset($_SESSION['success']);
    unset($_SESSION['error']);

    Flight::redirect('/login', 303);
});