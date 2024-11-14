<?php

namespace App\Admin\Forms;

use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;

class AdminSetting extends Form implements LazyRenderable
{
    use LazyWidget;

    /**
     * 主题颜色.
     *
     * @var array
     */
    protected $colors = [
//        'default'    => '深蓝',
//        'blue'       => '蓝',
////        'blue-light' => '浅蓝',
////        'blue-dark'  => '深蓝',
//        'green'      => '绿',
    ];

    public function __construct($data = [], $key = null)
    {
        parent::__construct($data, $key);

        // 主题颜色
        $this->colors = [
            'default'    => trans_arr_global('deep_blue'),
            'blue'       => trans_arr_global('blue'),
//        'blue-light' => '浅蓝',
//        'blue-dark'  => '深蓝',
            'green'      => trans_arr_global('green'),
        ];
    }


    /**
     * 处理表单请求.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
//        $input['layout']['horizontal_menu'] = in_array('horizontal_menu', $input['layout']['body_class'], true);

        foreach (Arr::dot($input) as $k => $v) {
            $this->update($k, $v);
        }

        return $this->response()->success(trans_arr_global('setting', 'success'));
    }

    /**
     * 构建表单.
     */
    public function form()
    {
//        if (\Dcat\Admin\Admin::user()->isAdministrator()) {
//            $this->text('name')->required()->help('网站名称');
//            $this->text('logo')->required()->help('logo设置');
//            $this->text('logo-mini', 'Logo mini')->required();
//        }


        $this->radio('lang', trans_arr_global('language'))->required()->options([
            'en' => 'English', 'zh_CN' => '简体中文'
        ]);
        $this->radio('layout.color', trans_arr_global('topic'))
            ->required()
            ->help(trans('admin-full.admin_setting_topic_help'))
            ->options($this->colors);

        $this->radio('layout.sidebar_style', trans_arr_global('menu', 'style'))
            ->options(['light' => 'Light', 'primary' => 'Primary'])
            ->help(trans_arr_global('handover', 'menu_bar', 'style'));

//        $this->checkbox('layout.body_class', trans_arr_global('menu', 'layout'))
//            ->options([
//                'horizontal_menu' => 'Horizontal',
//                'sidebar-separate' => 'sidebar-separate',
//            ])
//            ->help(trans_arr_global('handover', 'menu', 'layout'));
//        $this->switch('https', '启用HTTPS');

        if (\Dcat\Admin\Admin::user()->isAdministrator()) {
            $this->switch('helpers.enable', trans_arr_global('development', 'tools'));
        }
    }

    /**
     * 设置接口保存成功后的回调JS代码.
     *
     * 1.2秒后刷新整个页面.
     *
     * @return string|void
     */
    public function savedScript()
    {
        return <<<'JS'
    if (data.status) {
        setTimeout(function () {
          location.reload()
        }, 1200);
    }
JS;
    }

    /**
     * 返回表单数据.
     *
     * @return array
     */
    public function default()
    {
        $arr = user_admin_config();

//        if (\Dcat\Admin\Admin::user()->isAdministrator()) {
//            $arr = array_merge([
//                'name' => config('admin.name'),
//                'logo' => config('admin.logo'),
//                'logo-mini' => config('admin.logo-mini'),
//            ], $arr);
//        }

        return $arr;
    }

    /**
     * 更新配置.
     *
     * @param string $key
     * @param string $value
     */
    protected function update($key, $value)
    {
        user_admin_config([$key => $value]);
    }
}
