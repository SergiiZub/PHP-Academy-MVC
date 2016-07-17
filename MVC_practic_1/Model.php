<?php

abstract class Model
{
    static private $instance;

    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }


}