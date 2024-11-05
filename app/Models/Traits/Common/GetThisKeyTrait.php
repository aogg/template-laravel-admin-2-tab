<?php

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */


namespace App\Models\Traits\Common;



/**
 * 返回当前对象的属性名称
 * 必须第一个，否则hyperf会报错
 *
 * Trait GetThisKey
 * @package App\Model\Traits
 */
trait GetThisKeyTrait
{
    protected $getThisKeyClass;

    /**
     * @return GetThisKeyReturn|$this
     * @noinspection PhpReturnDocTypeMismatchInspection
     */
    public function getThisKey()
    {
        if ($this->getThisKeyClass) {
            return $this->getThisKeyClass;
        }

        return $this->getThisKeyClass = new GetThisKeyReturn();
    }

    /**
     * @return GetThisKeyReturn|$this
     * @noinspection PhpReturnDocTypeMismatchInspection
     */
    public static function getThisKeyStatic()
    {
        return new GetThisKeyReturn();
    }

    /**
     * @return GetThisArrKeyReturn|$this
     * @noinspection PhpReturnDocTypeMismatchInspection
     */
    public function getThisArrKey()
    {
        return new GetThisArrKeyReturn();
    }

    /**
     * @return GetThisArrKeyReturn|$this
     * @noinspection PhpReturnDocTypeMismatchInspection
     */
    public static function getThisArrKeyStatic()
    {
        return new GetThisArrKeyReturn();
    }

}


class GetThisKeyReturn {

    public function __get($name)
    {
        return $name;
    }

    public function __call($name, $args = [])
    {
        return $name;
    }


}

/**
 * 返回data_get的key
 * .链接
 *
 * Class GetThisArrKeyReturn
 * @package app\common\model\traits\common
 */
class GetThisArrKeyReturn {
    protected $nameArr = [];

    public function __get($name)
    {
        $this->nameArr[] = $name;

        return $this;
    }

    public function __call($name, $args = [])
    {
        $this->nameArr[] = $name;

        return $this;
    }

    public function toArrKey()
    {
        return join('.', $this->nameArr);
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->toArrKey();
    }

    /**
     * @inheritDoc
     *
     * @example \AdminModel::getThisArrKeyStatic()->adminData()->websitData()()
     */
    public function __invoke()
    {
        return $this->toArrKey();
    }


}
