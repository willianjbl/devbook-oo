<?php

use Devbook\models\Auth;

require 'config/config.php';
require 'vendor/autoload.php';

new Auth($pdo, BASE);
