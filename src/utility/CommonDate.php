<?php

namespace Devbook\utility;

class CommonDate
{
    public static function americanDateConvert(string $date): string
    {
        try {
            $date = explode('/', $date);
            if (count($date) === 3) {
                $date = "{$date[2]}-{$date[1]}-{$date[0]}";
                if (strtotime($date)) {
                    return $date;
                }
            }
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    public static function brazilianDateConvert(string $date): string
    {
        try {
            $date = explode('-', $date);
            if (count($date) === 3) {
                $date = "{$date[2]}/{$date[1]}/{$date[0]}";
                return $date;
            }
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    public static function brazilianDateTimeConvert(string $date): string
    {
        try {
            $date = new \DateTime($date);
            return $date->format('d/m/Y H:i:s');
        } catch (\Throwable $e) {
            return '';
        }
    }

    public static function getAge(string $date): ?int
    {
        try {
            $birthDate = new \DateTime($date);
            $currentDate = new \DateTime();
            return $birthDate->diff($currentDate)->y;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
