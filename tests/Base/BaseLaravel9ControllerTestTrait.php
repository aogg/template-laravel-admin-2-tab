<?php

namespace Tests\Base;


trait BaseLaravel9ControllerTestTrait
{

    /**
     * 调用控制器方法
     *
     * @param callable|array|string $classAction
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected static function callControllerAction($classAction)
    {
        if (is_string($classAction) && strpos($classAction, '::') !== false) {
            $classAction = explode('::', $classAction);
        }
        $controller = $classAction[0];
        $action = $classAction[1];
        $object = app($controller);
        $parameters = (new BaseControllerTestTraitTempUse)->resolveClassMethodDependenciesPublic([], $object, $action);
        return $object->{$action}(...array_values($parameters));
    }

    /**
     * 设置登录的账号
     *
     * @param $id
     * @return \App\Models\User|mixed
     */
    protected static function setAuthUserId($id)
    {
        request()->setUserResolver(function ()use($id){
            $auth = (new \Illuminate\Auth\AuthManager(app()));

            /** @var \Illuminate\Auth\EloquentUserProvider $provider */
            $provider = $auth->createUserProvider(config('auth.guards')[$auth->getDefaultDriver()]['provider']);
            return $provider->createModel()->find($id);
        });

        return request()->user();
    }


    protected static function setPostData($data)
    {
        request()->setMethod('POST');
        request()->merge($data);
    }

}


class BaseControllerTestTraitTempUse{

    use \Illuminate\Routing\RouteDependencyResolverTrait;
//    10用 \Illuminate\Routing\ResolvesRouteDependencies

    public $container;

    public function __construct()
    {
        $this->container = app();
    }


    public function resolveClassMethodDependenciesPublic(array $parameters, $instance, $method)
    {
        return $this->resolveClassMethodDependencies($parameters, $instance, $method);
    }
}
