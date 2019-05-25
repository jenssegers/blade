<?php

namespace Jenssegers\Blade;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\ViewServiceProvider;

class Blade
{
    /**
     * @var array|string
     */
    private $viewPaths;

    /**
     * @var string
     */
    private $cachePath;

    /**
     * @var Container
     */
    protected $container;

    public function __construct($viewPaths, string $cachePath, ContainerInterface $container = null)
    {
        $this->viewPaths = $viewPaths;
        $this->cachePath = $cachePath;
        $this->container = $container ?: new Container;

        $this->setupContainer();

        (new ViewServiceProvider($this->container))->register();

        $this->engineResolver = $this->container->make('view.engine.resolver');
    }

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
                'view.paths' => (array) $this->viewPaths,
                'view.compiled' => $this->cachePath,
            ];
        }, true);
    }

    public function render(string $view, array $data = [], array $mergeData = []): string
    {
        return $this->make($view, $data, $mergeData)->render();
    }

    public function make(string $view, array $data = [], array $mergeData = []): View
    {
        return $this->container['view']->make($view, $data, $mergeData);
    }

    public function compiler(): BladeCompiler
    {
        return $this->container['blade.compiler'];
    }

    public function directive(string $name, callable $handler)
    {
        $this->compiler()->directive($name, $handler);
    }

    public function __call(string $method, array $params)
    {
        return call_user_func_array([$this->container['view'], $method], $params);
    }
}
