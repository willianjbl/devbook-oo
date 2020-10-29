<?php

namespace Devbook\models;

class Session
{
    public function __construct()
    {
        $this->initialize();
    }

    private function initialize()
    {
        session_start();
    }

    public static function get(string $key): string
    {
        return $_SESSION[$key];
    }

    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        session_regenerate_id(true);
        session_destroy();
    }
}
