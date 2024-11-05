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

}
