<?php

use Devbook\models\Auth;

require 'config/config.php';

$auth = new Auth($pdo);
$auth->verifyToken();
