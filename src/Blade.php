<?php

namespace Jenssegers\Blade;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory;
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

    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var BladeCompiler
     */
    private $compiler;

    public function __construct($viewPaths, string $cachePath, ContainerInterface $container = null)
    {
        $this->viewPaths = $viewPaths;
        $this->cachePath = $cachePath;
        $this->container = $container ?: new Container;

        $this->setupContainer();
        (new ViewServiceProvider($this->container))->register();

        $this->factory = $this->container->get('view');
        $this->compiler = $this->container->get('blade.compiler');
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
        return $this->factory->make($view, $data, $mergeData);
    }

    public function compiler(): BladeCompiler
    {
        return $this->compiler;
    }

    public function directive(string $name, callable $handler)
    {
        $this->compiler->directive($name, $handler);
    }

    public function __call(string $method, array $params)
    {
        return call_user_func_array([$this->factory, $method], $params);
    }
}
