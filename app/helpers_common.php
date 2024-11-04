<?php

// 公共方法



if (!function_exists('datetime')) {

    /**
     * 将时间戳转换为日期时间
     * @param int $time 时间戳
     * @param string $format 日期时间格式
     * @return string
     */
    function datetime($time = 0, $format = 'Y-m-d H:i:s')
    {
        $time = is_numeric($time) ? ($time?:time()) : strtotime($time);

        return date($format, $time);
    }
}


{
    /**
     * 是否本地环境
     *
     * @return bool|string
     */
    function is_local()
    {
        return app()->environment('local');
    }

    function is_pro()
    {
        return app()->environment('pro');
    }
}

/**
 * 多语言key
 * 支持多个
 *
 * @param ...$keys
 * @return string
 */
function trans_arr(...$keys){
    $getLocale = app('translator')->getLocale();

    $arr = [];
    foreach ($keys as $key) {
        $arr[] = trans($key);
    }

    return in_array($getLocale, ['es', 'en'])?join(' ', $arr):join('', $arr);
}


if (!function_exists('get_exception_laravel_array')) {

    /**
     * 转为可存储的数组
     *
     * @param \Throwable $exception
     * @return array
     */
    function get_exception_laravel_array($exception)
    {
        $exception_json = [
            'exception_class_name' => get_class($exception),
            'getMessage' => $exception->getMessage(),
            'getFile' => $exception->getFile(),
            'getCode' => $exception->getCode(),
            'getTrace' => $exception->getTrace(),
        ];


//        if ($exception instanceof \think\db\exception\PDOException) {
//            $exception_json['PDOException_data'] = $exception->getData();
//        }

        return $exception_json;
    }
}

if (!function_exists('get_query_from_alias')) {

    /**
     * 获取别名
     */
    function get_query_from_alias($query, $appendBool = false)
    {

        $arr = explode(' ', get_query($query)->from ?? '');

        return end($arr) . ($appendBool ? '.' : '');
    }
}


if (!function_exists('get_query')) {

    function get_query($query)
    {
        if ($query instanceof \Illuminate\Database\Eloquent\Model) { // 需要加下@mixin
            return $query->getQuery();
        } else if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            return $query->getQuery();
        }

        return $query;
    }
}
