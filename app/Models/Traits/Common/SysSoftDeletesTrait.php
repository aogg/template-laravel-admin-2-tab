<?php

namespace App\Models\Traits\Common;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SysSoftDeletingScope extends \Illuminate\Database\Eloquent\SoftDeletingScope{

    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull($model->getQualifiedDeletedAtColumn($builder));
    }
}

/**
 * 处理无法识别别名问题
 *
 * @example
 * public static function fromAlias($alias)
 * {
 * $model = new static;
 * $table = $model->getTable();
 *
 * // 如果通过from，就无法解决软删除，无法识别别名
 * $query = $model->setTable($table . ' as ' . $alias)
 * ->from(static::getTableStatic(), $alias)
 * ;
 *
 * $model->setTable($table);
 *
 * return $query;
 * }
 *
 */
trait SysSoftDeletesTrait
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SysSoftDeletingScope);
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedDeletedAtColumn($builder = null)
    {
        return get_query_from_alias($builder??$this, true) . $this->getDeletedAtColumn();
    }
}
