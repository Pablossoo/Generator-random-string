<?php


namespace App;


class Helper
{
    public static function RemoveWhiteSpaceFromString(string $string = null)
    {
        return str_replace(' ', '', $string);
    }

    public static function RemoveAllWhiteSignFromString(string $string = null)
    {
        return preg_replace('/\s+/', '', $string);
    }
}