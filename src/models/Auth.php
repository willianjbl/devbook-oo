<?php

namespace Devbook\models;

use PDO;

class Auth
{
    private PDO $pdo;
    private string $base;

    public function __construct(PDO $pdo, string $base)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
        $this->base = $base;
    }

    public function checkLogin()
    {

    }
}
