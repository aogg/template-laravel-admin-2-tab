<?php

namespace App\Models\Traits\Common;



/**
 * @property int status
 * @property-read string status_text
 * @property-read int status_yes
 * @property-read int status_no
 * @property-read int status_default
 * @property-read bool is_status_yes
 * @property-read bool is_status_no
 * @property-read bool is_status_default
 * @method $this whereStatusShow()
 * @method static $this whereStatusShow()
 */
trait StatusYesAndNoModelFieldTrait
{

    public static function statusYes()
    {
        return 1;
    }
    public static function statusNo()
    {
        return 0;
    }

    public static function statusDefault()
    {
        return 0;
    }

    /**
     * @see status_yes
     * @return int
     */
    public function getStatusYesAttribute()
    {
        return static::statusYes();
    }

    /**
     * @see status_no
     * @return int
     */
    public static function getStatusNoAttribute()
    {
        return static::statusNo();
    }

    /**
     * @see status_default
     * @return int
     */
    public static function getStatusDefaultAttribute()
    {
        return static::statusDefault();
    }

    public function initializeStatusYesAndNoModelFieldTrait()
    {
        $this->append(['status_text']);
    }

    public static function getStatusTitleArr()
    {
        return [
            static::statusYes() => '是',
            static::statusNo() => '否',
        ];
    }

    /**
     * @see is_status_yes
     * @return bool
     */
    public function getIsStatusYesAttribute()
    {
        return $this->status == static::statusYes();
    }

    /**
     * @see is_status_no
     * @return bool
     */
    public function getIsStatusNoAttribute()
    {
        return $this->status == static::statusNo();
    }

    /**
     * @see is_status_default
     * @return bool
     */
    public function getIsStatusDefaultAttribute()
    {
        return $this->status == static::statusDefault();
    }

    /**
     * @see status_text
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return static::getStatusTitleArr()[$this->status]??'';
    }

    public function scopeWhereStatusShow($query)
    {
        return $query->where(get_query_from_alias($query, true) . 'status', 1);
    }
}
