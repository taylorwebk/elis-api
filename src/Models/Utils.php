<?php
namespace Models;
class Utils
{
    public static function validateData($data, $fields)
    {
        foreach ($fields as $value) {
        if (! isset($data[$value])) {
            return false;
        }
        }
        return true;
    }
    public static function implodeFields($fields) {
        return 'No se reconocen uno o varios de los campos: '. implode(', ', $fields);
    }
}
