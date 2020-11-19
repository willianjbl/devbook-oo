<?php

namespace Devbook\functions;

class CommonValidation
{
    public static function validateQuery(\PDOStatement $query): bool
    {
        try {
            return $query->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}
