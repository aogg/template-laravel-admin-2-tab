<?php

namespace App\Models\Traits\Common;

/**
 * @property array json_data
 */
trait JsonDataModelFieldTrait
{

    public function initializeJsonDataModelFieldTrait()
    {
        $this->mergeCasts([
            'json_data' => 'array',
        ]);
    }

    /**
     * 增加json_data数据
     *
     * @param $merge
     * @return $this
     */
    public function mergeJsonData($merge = [])
    {
        $this->json_data = array_merge($this->json_data?:[], $merge);

        return $this;
    }

}
