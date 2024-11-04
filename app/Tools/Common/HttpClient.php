<?php

namespace App\Tools\Common;




abstract class HttpClient
{
    use GuzzleHttpMsgStaticTrait;
    use \App\Tools\Traits\Common\MiddlewareTrait;

    public $client;
    public const CONFIG = [];

    public $response = [];
    public $responseOriginStr = '';
    public $request = [];

    protected $clientConfig = [];

    public function getClientConfig()
    {
        return array_merge(static::CONFIG, $this->clientConfig);
    }

    protected function createClient()
    {
        return new \GuzzleHttp\Client($this->getClientConfig());
    }

    public function make()
    {
        try {
            return $this->runMiddleware('make', function () {
                return $this->createClient();
            });
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage(), 500);

        }
    }

    protected function init()
    {

    }

    public static function new(...$args)
    {
        $ob = new static(...$args);

        $ob->init();

        return $ob;
    }

    /**
     * @return \GuzzleHttp\Client
     * @throws \Exception
     */
    public function getClient()
    {
        $this->client = $this->make();
        return $this->client;
    }

    public function post($url, $option)
    {
        return $this->requestUrl($url, $option, 'post');
    }

    public function get($url, $option = [])
    {
        return $this->requestUrl($url, $option, 'get');
    }

    /**
     * @param $url
     * @param $option
     * @param 'get'|'post' $method
     * @return $this
     */
    public function requestUrl($url, $option, $method)
    {
        static::initException();

        try {

            $this->runMiddleware('requestUrl', function ($url, $option) use ($method) {
                $this->runMiddleware($method, function ($url, $option) use ($method) {
                    try {
                        $this->request = compact('url', 'option');

                        $response = $this->getClient()->{$method}($url, $option);
                        $body = $response->getBody();
                        // Implicitly cast the body to a string and echo it

                        // Explicitly cast the body to a string
                        $stringBody = (string)$body;

                        $this->responseOriginStr = $stringBody;
                        $this->response = $this->handRet($stringBody);
                    } catch (\Throwable $throwable) {
                        static::setException($throwable);

                        throw $throwable;
                    }
                }, $url, $option);
            }, $url, $option);
        } catch (\Throwable $throwable) {

        }

        return $this;
    }

    //处理响应结果
    public abstract function handRet($str);

    public function setClientConfig(array $clientConfig)
    {
        $this->clientConfig = $clientConfig;

        return $this;
    }


    public function getResponseLog()
    {
        $response = $this->response?:[];
        $getHttpExceptionBody = $this::$requestExceptionBody;
        $getHttpExceptionBody = $getHttpExceptionBody?json_decode($getHttpExceptionBody, true):[];
        $response['exceptionArr'] = $getHttpExceptionBody;
        $response['exceptionMsg'] = static::$requestExceptionMsg;
        $response['request'] = $this->request;

        return $response;
    }

}
