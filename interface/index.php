<?php
require './vendor/autoload.php';
require './src/config/db.php';
require './src/models/UserModel.php';
require './src/models/DNSDomainModel.php';
require './src/controllers/UserController.php';
require './src/controllers/DNSDomainController.php';
require './src/routes/user.php';
require './src/routes/register.php';
require './src/routes/login.php';
require './src/routes/logout.php';
require './src/routes/panel.php';
require './src/routes/domains.php';

Flight::start();