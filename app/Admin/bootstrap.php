<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */


include_once __DIR__ . '/helpers.php';

$adminConfig = user_admin_config();
config(['admin' => array_merge(config('admin'), $adminConfig)]);
config(['app.locale' => config('admin.lang') ?: config('app.locale')]);


// ajax请求不执行
if (! \Dcat\Admin\Support\Helper::isAjaxRequest()) {


    \Dcat\Admin\Admin::navbar(function ($navbar){

        $navbar->right(App\Admin\Actions\AdminSetting::make()->render());

        /** @var \Dcat\Admin\Layout\Navbar $navbar */
//        $navbar->right(view('admin.navbar.navbar', [
//            'current' => request()->cookie('language', config('app.fallback_locale')),
//            'list' => [
//                'zh_CN' => 'zh_CN',
//                'es' => 'es',
//            ],
//        ]));
//        $navbar->right(
//            (new \Dcat\Admin\Form\Field\Tags(''))
//                ->placeholder(trans('translation'))
//                ->options([1 => 2])
//        );

    });
}
