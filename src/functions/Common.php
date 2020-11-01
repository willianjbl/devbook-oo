<?php

namespace Devbook\functions;

class Common
{
    public static function redirect(string $location): void
    {
        header('Location: ' . BASE . "/$location.php");
        exit;
    }
}
