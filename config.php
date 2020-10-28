<?php

require 'constants.php';

$pdo = new PDO('mysql:dbname=' . DB_NAME . 'host=' . DB_HOST, DB_USER, DB_PASS);
