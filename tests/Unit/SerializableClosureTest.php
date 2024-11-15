<?php

namespace Unit;

class SerializableClosureTest extends \Tests\TestCase
{

    public static function test__Serializable()
    {
        $func = function (){
            echo 1;
        };
        $a = new \Opis\Closure\SerializableClosure($func);
        $a = serialize($a);
        var_dump($a);

        self::assertIsString($a);

    }

}
