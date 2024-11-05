<?php

namespace App\Tools\Response;


class JsonFormat
{

    public static function format($code, $info, $data)
    {
        return compact('code', 'info', 'data');
    }

    public static function success($data = null)
    {
        return static::format(static::getCodeSuccess(), static::getCodeSuccessInfo(), $data);
    }

    public static function error($code = null, $info = null, $data = null)
    {
        return static::format($code??static::getCodeError(), $info??static::getCodeErrorInfo(), $data);
    }

    public static function errorMsg($info = null, $code = null, $data = null)
    {
        return static::format($code??static::getCodeError(), $info??static::getCodeErrorInfo(), $data);
    }


    public static function getCodeError()
    {
        return 400;
    }

    public static function getCodeErrorInfo()
    {
        return '错误';
    }



    public static function getCodeSuccess()
    {
        return 200;
    }

    public static function getCodeSuccessInfo()
    {
        return '成功';
    }

}
