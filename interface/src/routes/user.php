<?php

$router = Flight::router();

$router->get('/', function() {
    Flight::redirect('/login', 303);
});