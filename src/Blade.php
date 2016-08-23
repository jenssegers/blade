<?php
namespace Jenssegers\Blade;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\ViewServiceProvider;

class Blade
{

    /**
     * Container instance.
     *
     * @var Container
     */
    protected $container;

    /**
     * Engine Resolver
     *
     * @var
     */
    protected $engineResolver;

    /**
     * Constructor.
     *
     * @param array     $viewPaths
     * @param string    $cachePath
     * @param Container $container
     */
    public function __construct($viewPaths, $cachePath, ContainerInterface $container = null)
    {
        $this->viewPaths = $viewPaths;
        $this->cachePath = $cachePath;
        $this->container = $container ?: new Container;

        $this->setupContainer();

        (new ViewServiceProvider($this->container))->register();

        $this->engineResolver = $this->container->make('view.engine.resolver');
    }

    /**
     * Bind required instances for the service provider.
     */
    protected function setupContainer()
    {
        $this->container->bindIf('files', function () {
            return new Filesystem;
        }, true);

        $this->container->bindIf('events', function () {
            return new Dispatcher;
        }, true);

        $this->container->bindIf('config', function () {
            return [
                'view.paths'    => (array) $this->viewPaths,
                'view.compiled' => $this->cachePath,
            ];
        }, true);
    }

    /**
     * Render shortcut.
     *
     * @param  string $view
     * @param  array  $data
     * @param  array  $mergeData
     *
     * @return string
     */
    public function render($view, $data = [], $mergeData = [])
    {
        return $this->container['view']->make($view, $data, $mergeData)->render();
    }

    /**
     * Get the compiler
     *
     * @return mixed
     */
    public function compiler()
    {
        $bladeEngine = $this->engineResolver->resolve('blade');

        return $bladeEngine->getCompiler();
    }

    /**
     * Pass any method to the view factory instance.
     *
     * @param  string $method
     * @param  array  $params
     * @return mixed
     */
    public function __call($method, $params)
    {
        return call_user_func_array([$this->container['view'], $method], $params);
    }

}
