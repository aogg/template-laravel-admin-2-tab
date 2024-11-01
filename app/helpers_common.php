<?php

// 公共方法

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
