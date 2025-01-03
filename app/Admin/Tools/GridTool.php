<?php

namespace App\Admin\Tools;

class GridTool
{
    /**
     * 图片
     *
     * @see \Dcat\Admin\Grid\Displayers\Image::display
     * @param $src
     * @param $width
     * @param $height
     * @return string
     */
    public static function imageHtml($src, $width = 200, $height = 200, $tag = 'img')
    {
        return "<img data-action='preview-img' src='$src' style='max-width:{$width}px;max-height:{$height}px;cursor:pointer' class='img img-thumbnail' />";
    }

    /**
     * 自动点击刷新按钮
     *
     * @return void
     */
    public static function autoRefresh($seconds = 10)
    {
        \Dcat\Admin\Admin::script(
            <<<JS
(function (){
    let uncheckBool = false;
    setTimeout(function (){
        if (uncheckBool){
            return;
        }

        let localTime = window['admin_grid_auto_refresh_time'];

        if(localTime && (localTime + 10 * 1000) > Date.now()) {
            return;
         }
        window['admin_grid_auto_refresh_time'] = Date.now();

        console.log('自动刷新--' + localTime)
        $('button.grid-refresh').click();
    }, $seconds * 1000);

function checkVisibility() {
    if (document.hidden) {
        console.log("当前窗口不可见");
        uncheckBool = true;
    } else {
        console.log("当前窗口可见");
        uncheckBool = false;
    }
}

// 监听可见性变化事件
document.addEventListener("visibilitychange", checkVisibility);

// 初始检查
checkVisibility();
})()
JS

        );
    }

    /**
     * 列表--整形在线编辑
     *
     * @param \Dcat\Admin\Grid $grid
     * @param ...$columnArr
     * @return void
     */
    public static function columnEditableInteger($grid, ...$columnArr)
    {

        $grid->column(...$columnArr)->editable([
            'mask' => [
                'alias' => 'integer',
            ],
        ]);
    }

    /**
     * 显示json内字段，并且可以在线编辑
     *
     * @param $grid
     * @param $key
     * @return void
     */
    public static function columnDataKeyInput($grid, $key)
    {
        $key = strval($key);

        $field = $grid->column(str_replace('.', '__', $key))->display(function ()use(&$field, $key){
            $field->setOriginal(data_get($this, $key)?:'');
            return data_get($this, $key)?:'';
        })->editable();
    }

    /**
     * 将columnDataKeyInput里的key转为json数据
     *
     * 可以写在
     * $form->submitted
     *
     * @see columnDataKeyInput
     * @param \Dcat\Admin\Form $form
     * @return void
     */
    public static function handleFormDataKeyJson($form)
    {
        $form->submitted(function ($form) {
            /** @var \Dcat\Admin\Form $form */
            foreach ($form->input() as $key => $item) {
                if (strpos($key, '__') > 0) {
                    $form->input(join('.', explode('__', $key)), $item);
                }
            }
        });
    }

    /**
     * 处理attribute写法复杂问题
     *
     * @param $gridOrShow
     * @param $fieldOrigin
     * @param $showField
     * @return \Dcat\Admin\Grid|\Dcat\Admin\Show|null|object
     */
    public static function admin_handle_attribute($gridOrShow, $fieldOrigin, $showField)
    {
        if ($gridOrShow instanceof \Dcat\Admin\Grid) {
            return ($column = $gridOrShow->column($fieldOrigin))->display(function () use ($showField, &$column) {
                $column->setAttributes([
                    'title' => data_get($this, $showField)?:'',
                ]);

                return data_get($this, $showField);
            });
        } else if ($gridOrShow instanceof \Dcat\Admin\Show) {
            $gridOrShow->field($fieldOrigin)->as(function () use ($showField) {
                return data_get($this, $showField);
            });
        }
    }

}
