<?php

use Devbook\models\{
    Auth,
    Session
};

require 'config/config.php';

Session::initialize();

$auth = new Auth($pdo);
$auth->verifyToken();
