<?php

namespace App\Models\Traits\Base;

/**
 * 将数组转为model
 */
trait ArrayToModelTrait
{
    /**
     * @param $list
     * @return \Illuminate\Database\Eloquent\Collection|$this[]
     */
    public static function arrayToModelCollection($list)
    {
        foreach ($list as &$item) {
            $item = (new static())->forceFill($item);
        }

        return \Illuminate\Database\Eloquent\Collection::make($list);
    }

}
