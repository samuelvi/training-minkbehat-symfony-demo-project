<?php

namespace AppBundle\Utils;

class Files
{
    public static function getLinesAsArray($file)
    {
        return file($file, FILE_IGNORE_NEW_LINES);
    }
}