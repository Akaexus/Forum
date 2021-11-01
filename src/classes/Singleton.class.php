<?php
abstract class Singleton
{
    public static $instances;

    static function i()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static;
        }
        return static::$instances[$class];
    }
}
