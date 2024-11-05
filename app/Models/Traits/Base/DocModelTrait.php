<?php

namespace App\Models\Traits\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;


/**
 * model类
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @method static $this|Builder|QueryBuilder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static $this|Builder|QueryBuilder whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static bool insert(array $values)   // 支持多组数据 看\Illuminate\Database\Query\Builder::insert
 * @method static $this create(array $values)
 * @method static $this|Builder|QueryBuilder orderBy($column, $direction = 'asc')
 * @method static $this|Builder|QueryBuilder firstOrNew(array $attributes = [], array $values = [])
 * @method static $this|mixed|QueryBuilder|null find($id, $columns = ['*'])
 * @method static $this|mixed|QueryBuilder findOrFail($id, $columns = ['*']) 查找数据，如果没有就报错
 * @method static $this|mixed|QueryBuilder findOrNew($id, $columns = ['*']) 查找数据，没有就创建，并带有where条件的值
 * @method static $this|Builder|QueryBuilder updateOrCreate(array $where = [], array $save = [])
 * @method static $this forceCreate(array $attributes)
 * @method static QueryBuilder|$this from($table, $as = null)
 *
 * @method \Illuminate\Database\Eloquent\Collection|$this[] get($columns = ['*']) 查找列表数据
 * @method $this[]|\Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null) 分页
 * @method $this[]|\Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null) 分页，不count
 *
 * @package App\Repositories\Common\Traits\Doc
 */
trait DocModelTrait
{

}
