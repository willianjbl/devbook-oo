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
        if (!empty($type) && !empty($message)) {
            Session::set('FLASH', ['message' => $message, 'type' => $type]);
        }
    }

    public static function getFlash(): array
    {
        $flash = [];

        if (!empty(Session::get('FLASH'))) {
            $flash = Session::get('FLASH');
            Session::remove('FLASH');
        }
        return $flash;
    }

    public static function renderPartial(string $path, array $data = []): void
    {
        if (!empty($data) ) {
            if (!empty(array_keys($data))) {
                foreach ($data as $key => $value) {
                    $$key = $value;
                }
            }
        } else {
            unset($data);
        }

        require "partials/$path.php";
    }
}
