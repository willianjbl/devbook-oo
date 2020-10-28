<?php

namespace models;

class Auth
{
    private PDO $pdo;
    private string $base;

    public function __construct(PDO $pdo, string $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;
    }

    public function checkLogin()
    {

    }
}
