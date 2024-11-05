<?php

namespace App\Tools\Traits\Common;



/**
 * 单例类
 */
trait Singleton
{
    protected static $instance = null;


    /**
     * 单例
     *
     * @param array $args
     * @return static
     */
    public static function instance(...$args)
    {
        $key = md5(var_export(['class' => static::class, 'args' => $args], true));
        if (!isset(self::$instance[$key])){
            self::$instance[$key] = new static(...$args);
        }

        return self::$instance[$key];
    }

    /**
     * 实例化对象
     *
     * @param array ...$args
     * @return static
     */
    public static function instanceNew(...$args)
    {
        return new static(...$args);
    }

    /**
     * 设置默认实例化对象
     *
     * @param $object
     * @return mixed
     */
    public static function instanceSetDefault($object)
    {
        $key = md5(var_export(['class' => static::class, 'args' => []], true));

        return self::$instance[$key] = $object;
    }

    /**
     * 默认实例化对象
     *
     * @param array $args
     * @return mixed
     */
    public static function instanceDefault(...$args)
    {
        return static::instanceSetDefault(static::instance(...$args));
    }

    /**
     * 实例化对象通过传入的对象进行保存
     *
     * @param object $callObject 保存单例的对象
     * @param mixed ...$args
     * @return static
     */
    public static function instanceThis($callObject, ...$args)
    {
        $key = md5(var_export(['class' => static::class, 'args' => $args], true));

        if (!property_exists($callObject, $key)) {
            $instance = static::instanceNew(...$args);
            $callObject->$key = $instance;
        }

        return $callObject->$key;
    }
}
