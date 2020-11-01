<?php

use Devbook\models\Auth;

require 'config/config.php';
require 'vendor/autoload.php';

$auth = new Auth($pdo);
$auth->verifyToken();
