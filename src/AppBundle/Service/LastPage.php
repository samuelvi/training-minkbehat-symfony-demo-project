<?php

namespace AppBundle\Service;

class LastPage
{
    public static function encodeParameters($parameters)
    {
        return base64_encode(serialize($parameters));
    }

    public static function decodeParameters($parameters)
    {
        return unserialize(base64_decode($parameters));
    }
}