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


if (!function_exists('try_func_lock')) {

    /**
     * 锁，匿名函数执行
     *
     * @param string $cacheKey
     * @param callable $func
     * @param array $args
     * @param int $expireTime 最大超时时间
     * @param bool $delete 运行结束是否删除锁
     * @return false|mixed|null
     */
    function try_func_lock($cacheKey, $func, $args = [], $expireTime = null, $delete = true)
    {
        $cacheKey = $cacheKey . ':lock';
        $result = null;

        /** @var \Redis $redis */
        $redis = \Illuminate\Support\Facades\Redis::client();

        $bool = false;
        try {
            if ($redis->set($cacheKey, time(), isset($expireTime) ? ['nx', 'ex' => $expireTime] : ['nx'])) {
                $bool = true;
                $result = call_user_func_array($func, $args) ?? true;
            }
        } catch (\Exception|\Throwable $exception) {
        }
        if ($bool) {
            if ($delete || isset($exception)) { // 异常也删除
                $redis->del($cacheKey);
            }
        }
        if (isset($exception)) {
            throw $exception;

        }
        return $result;
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
            'getLine' => $exception->getLine(),
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

if (!function_exists('text_to_image')) {

    /**
     * 文字转图片
     *
     * @param $text
     * @param $width
     * @param $height
     * @return string
     */
    function text_to_image($text, $fontPath, $width = 200, $height = 200)
    {

// 创建图像画布
//        $width = 800; // 设置图像宽度
//        $height = 200; // 设置图像高度
        $image = imagecreatetruecolor($width, $height);

// 设置背景颜色（白色）
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $backgroundColor);

// 设置字体颜色（黑色）
        $textColor = imagecolorallocate($image, 0, 0, 0);

// 设置字体路径（确保路径正确）
//        $fontPath = 'path/to/your/font.ttf'; // 请替换为实际字体文件路径
        $fontSize = 24; // 初始字体大小

// 计算文本宽度
        do {
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = $bbox[2] - $bbox[0]; // 计算文本宽度
            if ($textWidth > $width - 40) { // 减去一些边距
                $fontSize--; // 如果文本太宽，则减小字体大小
            }
        } while ($textWidth > $width - 40);

// 计算文本的纵向位置
        $y = ($height / 2) + ($bbox[1] - $bbox[7]) / 2; // 垂直居中

// 在图像上绘制文本
        imagettftext($image, $fontSize, 0, ($width - $textWidth) / 2, $y, $textColor, $fontPath, $text);

// 将图像输出到一个变量
        ob_start(); // 启用输出缓冲区
//        header('Content-Type: image/png');
        imagepng($image); // 输出图像为 PNG 格式
//        exit;
        $imageData = ob_get_contents(); // 获取输出的内容
        ob_end_clean(); // 清理输出缓冲区
//        $imageData = stream_get_contents($image, null, 0);

        // 不要base64
        return $imageData;
    }
}
