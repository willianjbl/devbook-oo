<?php

namespace Devbook\utility;

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
