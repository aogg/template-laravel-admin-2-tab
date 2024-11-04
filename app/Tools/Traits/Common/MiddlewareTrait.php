<?php

namespace App\Tools\Traits\Common;


trait MiddlewareTrait
{
    protected array $middlewares = [];


    public function addMiddleware(callable $middleware, $middlewaresRunKey = 'default')
    {

        if (!isset($this->middlewares[$middlewaresRunKey])) {
            $this->middlewares[$middlewaresRunKey] = [];
        }
        $this->middlewares[$middlewaresRunKey][] = $middleware;
        return $this;
    }

    /**
     * @param callable $callable
     * @return mixed
     */
    public function runMiddleware($middlewaresRunKey, $callable, ...$args)
    {
        return array_reduce(
            array_reverse(
                $this->middlewares[$middlewaresRunKey]??($this->middlewares['default']??[])
            ),
            function ($next, $middleware) {
                return function (...$args) use ($next, $middleware) {
                    return $middleware($next, ...$args);
                };
            },
            function (...$args) use($callable) {
                return call_user_func($callable, ...$args);
            }
        )(...$args);
    }


}
