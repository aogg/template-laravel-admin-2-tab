<?php

namespace Unit;

class SerializableClosureTest extends \Tests\TestCase
{

    public static function test__Serializable()
    {
        $func = function (){
            echo 1;

            return 2;
        };
        $a = new \Opis\Closure\SerializableClosure($func);
        $a = serialize($a);
        var_dump($a);
        /** @var \Opis\Closure\SerializableClosure $wrapper */
        $wrapper = unserialize($a);

        var_dump($wrapper->getClosure()());

        self::assertIsString($a);

    }

    public static function test__Serializable_laravel()
    {
        $func = function (){
            echo 1;

            return 2;
        };
        $a = new \Laravel\SerializableClosure\SerializableClosure($func);
        $a = serialize($a);
        var_dump($a);
        /** @var \Opis\Closure\SerializableClosure $wrapper */
        $wrapper = unserialize($a);

        var_dump($wrapper->getClosure()());

        self::assertIsString($a);

    }

}
