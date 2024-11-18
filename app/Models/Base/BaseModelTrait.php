<?php

namespace App\Models\Base;

trait BaseModelTrait
{
    use \App\Models\Traits\Common\GetThisKeyTrait;
    use \App\Models\Traits\Base\DocModelTrait;

    use \App\Models\Traits\Base\SelfPkDataRelationTrait;
    use \App\Models\Traits\Base\ArrayToModelTrait;

}
