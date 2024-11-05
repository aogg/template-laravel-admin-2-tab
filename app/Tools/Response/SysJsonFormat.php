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


}
