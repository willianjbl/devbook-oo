<?php

namespace Devbook\functions;

use Devbook\models\Session;

class Common
{
    public static function redirect(string $location = ''): void
    {
        $location = !empty($location) ? "/$location.php" : '';
        header('Location: ' . BASE . $location);
        exit;
    }

    public static function flash(string $type, string $message): void
    {
        Session::set('FLASH_TYPE', $type);
        Session::set('FLASH_MESSAGE', $message);
    }

    public static function getFlash(): array
    {
        $tempMessage = [];

        if (!empty(Session::get('FLASH_MESSAGE'))) {
            $tempMessage['type'] = Session::get('FLASH_TYPE');
            $tempMessage['message'] = Session::get('FLASH_MESSAGE');
            Session::remove('FLASH_MESSAGE');
            Session::remove('FLASH_TYPE');
        }
        return $tempMessage;
    }
}
