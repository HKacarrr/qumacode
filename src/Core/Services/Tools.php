<?php

namespace App\Core\Services;

class Tools
{
    public static function getDayFromDate($date): int
    {
        $date = \DateTime::createFromFormat('Y-m-d', $date);
        return (int) $date->format('w');
    }
}
