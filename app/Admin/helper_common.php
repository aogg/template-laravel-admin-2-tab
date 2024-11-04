<?php


use Illuminate\Support\Arr;

/**
 * 自动点击刷新按钮
 *
 * @return void
 */
function admin_grid_auto_refresh(){
    \Dcat\Admin\Admin::script(
        <<<JS
(function (){
    let uncheckBool = false;
    setTimeout(function (){
        if (uncheckBool){
            return;
        }

        console.log('自动刷新')
        $('button.grid-refresh').click();
    }, 10 * 1000);

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
 * 根据路由名称查找url
 *
 * @param $name
 * @param $parameters
 * @param $absolute
 * @return string
 */
function admin_url_route($name, $parameters = [], $absolute = true){
    return url()->route('dcat.' . config('admin.route.prefix') . '.' . $name, $parameters, $absolute);
}

if (! function_exists('user_admin_config')) {
    function user_admin_config($key = null, $value = null)
    {
        $cache = cache();

        $cacheKey = 'admin:config:' . \Dcat\Admin\Admin::user()?->id;
        if (! $config = $cache->get($cacheKey)) {
            $config = [];
            $config['layout'] = config('admin.layout');
            $config['helpers'] = config('admin.helpers');

            $config['lang'] = config('app.locale');
        }

        if (is_array($key)) {
            // 保存
            foreach ($key as $k => $v) {
                Arr::set($config, $k, $v);
            }

            $cache->set($cacheKey, $config);

            return;
        }

        if ($key === null) {
            return $config;
        }

        return Arr::get($config, $key, $value);
    }
}
