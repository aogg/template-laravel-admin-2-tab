<?php

namespace App\Models\Traits\Common;

/**
 * status    tinyint default 0 not null comment '发送状态，1=成功，0=未处理, 2=失败',
 */
trait StatusSuccessAndErrorModelFieldTrait
{
    use StatusYesAndNoModelFieldTrait;


    public static function statusNo()
    {
        return 2;
    }

    public static function getStatusTitleArr()
    {
        return [
            static::statusYes() => trans_arr_global('success'),
            static::statusNo() => trans_arr_global('error'),
        ];
    }

}
