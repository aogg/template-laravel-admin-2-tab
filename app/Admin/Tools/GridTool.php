<?php

namespace App\Admin\Tools;

class GridTool
{

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
}
