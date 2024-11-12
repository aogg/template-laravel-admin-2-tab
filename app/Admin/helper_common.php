<?php


use Illuminate\Support\Arr;

/**
 * 处理attribute写法复杂问题
 *
 * @param $gridOrShow
 * @param $fieldOrigin
 * @param $showField
 * @return void
 */
function admin_handle_attribute($gridOrShow, $fieldOrigin, $showField){
    if ($gridOrShow instanceof \Dcat\Admin\Grid) {
        $gridOrShow->column($fieldOrigin)->display(function ()use($showField){
            return $this->{$showField};
        });
    }else if ($gridOrShow instanceof \Dcat\Admin\Show){
        $gridOrShow->field($fieldOrigin)->as(function ()use($showField){
            return $this->{$showField};
        });
    }
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
