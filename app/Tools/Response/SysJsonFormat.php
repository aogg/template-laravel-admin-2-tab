<?php

namespace App\Tools\Response;

class SysJsonFormat extends JsonFormat
{

    public static function getCodeErrorInfo()
    {
        return trans_arr_global('error');
    }

    public static function getCodeSuccessInfo()
    {
        return trans_arr_global('success');
    }

    public static function throw($msg)
    {
        if (defined('IS_ADMIN') && IS_ADMIN) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(\Dcat\Admin\Admin::json()->error($msg)->send())
            ;
        }else{
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json(static::errorMsg($msg)));
        }

    }

}
