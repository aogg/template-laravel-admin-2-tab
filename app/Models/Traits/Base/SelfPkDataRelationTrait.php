<?php

namespace App\Models\Traits\Base;

/**
 * @property-read $this selfPkData
 */
trait SelfPkDataRelationTrait
{

    public function selfPkData()
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        return $this->hasOne(static::class, $this->getKeyName(), $this->getKeyName());
    }

}
