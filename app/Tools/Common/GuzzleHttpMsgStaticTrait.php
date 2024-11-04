<?php

namespace App\Tools\Common;


/**
 * 扩展guzzle请求的类，记录异常
 */
trait GuzzleHttpMsgStaticTrait
{

    /**
     * @var \Exception|\GuzzleHttp\Exception\ClientException|\GuzzleHttp\Exception\ServerException
     */
    public static $requestException = null;
    public static $requestExceptionMsg = '';
    public static $requestExceptionBody = '';

    public static function initException()
    {

        static::$requestException = null;
        static::$requestExceptionMsg = '';
    }

    /**
     * @param \Exception $e
     * @return void
     */
    public static function setException($e)
    {
        static::$requestException = $e;
        if ($e instanceof \GuzzleHttp\Exception\ServerException) {
            static::$requestExceptionMsg = $e->getResponse()->getBody()->getContents();
            static::$requestExceptionBody = $e->getResponse()->getBody()->getContents();
        }else if ($e instanceof \GuzzleHttp\Exception\ClientException) {
            static::$requestExceptionMsg = $e->getMessage();
            static::$requestExceptionBody = $e->getResponse()->getBody()->getContents();
        }else{
            static::$requestExceptionMsg = $e->getMessage();
        }


    }

}
