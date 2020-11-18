<?php

use Devbook\functions\Common;
use Devbook\models\Auth;

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();

Common::renderPartial('header', [
    'title' => 'Feed',
    'user' => $user
]);
Common::renderPartial('menu', ['activeMenu' => 'home']);
Common::renderPartial('footer');