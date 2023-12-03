<?php

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Illuminate\View\ViewFinderInterface;
use Jenssegers\Blade\Blade;
use PHPUnit\Framework\TestCase;

class BladeTest extends TestCase
{
    /**
     * @var Blade
     */
    private $blade;

    protected function setUp(): void
    {
        $this->blade = new Blade('tests/views', 'tests/cache');

        $this->blade->directive('datetime', function ($expression) {
            return "<?php echo with({$expression})->format('F d, Y g:i a'); ?>";
        });

        $this->blade->if('ifdate', function ($date) {
            return $date instanceof DateTime;
        });
    }

    public function testCompilerGetter()
    {
        $this->assertInstanceOf(BladeCompiler::class, $this->blade->compiler());
    }

    public function testBasic()
    {
        $output = $this->blade->make('basic');
        $this->assertEquals('hello world', trim($output));
    }

    public function testExists()
    {
        $this->assertFalse($this->blade->exists('nonexistentview'));
    }

    public function testVariables()
    {
        $output = $this->blade->make('variables', ['name' => 'John Doe']);
        $this->assertEquals('hello John Doe', trim($output));
    }

    public function testNonBlade()
    {
        $output = $this->blade->make('plain');
        $this->assertEquals('{{ this is plain php }}', trim($output));
    }

    public function testFile()
    {
        $output = $this->blade->file('tests/views/basic.blade.php');
        $this->assertEquals('hello world', trim($output));
    }

    public function testShare()
    {
        $this->blade->share('name', 'John Doe');

        $output = $this->blade->make('variables');
        $this->assertEquals('hello John Doe', trim($output));
    }

    public function testComposer()
    {
        $this->blade->composer('variables', function (View $view) {
            $view->with('name', 'John Doe and '.$view->offsetGet('name'));
        });

        $output = $this->blade->make('variables', ['name' => 'Jane Doe']);
        $this->assertEquals('hello John Doe and Jane Doe', trim($output));
    }

    public function testCreator()
    {
        $this->blade->creator('variables', function (View $view) {
            $view->with('name', 'John Doe');
        });
        $this->blade->composer('variables', function (View $view) {
            $view->with('name', 'Jane Doe and '.$view->offsetGet('name'));
        });

        $output = $this->blade->make('variables');
        $this->assertEquals('hello Jane Doe and John Doe', trim($output));
    }

    public function testRenderAlias()
    {
        $output = $this->blade->render('basic');
        $this->assertEquals('hello world', trim($output));
    }

    public function testDirective()
    {
        $output = $this->blade->make('directive', ['birthday' => new DateTime('1989/08/19')]);
        $this->assertEquals('Your birthday is August 19, 1989 12:00 am', trim($output));
    }

    public function testIf()
    {
        $output = $this->blade->make('if', ['birthday' => new DateTime('1989/08/19')]);
        $this->assertEquals('Birthday August 19, 1989 12:00 am detected', trim($output));
    }

    public function testAddNamespace()
    {
        $this->blade->addNamespace('other', 'tests/views/other');

        $output = $this->blade->make('other::basic');
        $this->assertEquals('hello other world', trim($output));
    }

    public function testReplaceNamespace()
    {
        $this->blade->addNamespace('other', 'tests/views/other');
        $this->blade->replaceNamespace('other', 'tests/views/another');

        $output = $this->blade->make('other::basic');
        $this->assertEquals('hello another world', trim($output));
    }

    public function testViewGetter()
    {
        /** @var Factory $view */
        $view = $this->blade;

        $this->assertInstanceOf(ViewFinderInterface::class, $view->getFinder());
    }

    public function testOther()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@doe.com',
            ],
            [
                'id' => 2,
                'name' => 'Jen Doe',
                'email' => 'jen.doe@example.com',
            ],
            [
                'id' => 3,
                'name' => 'Jerry Doe',
                'email' => 'jerry.doe@doe.com',
            ],
        ];

        $output = $this->blade->make('other', [
            'users' => $users,
            'name' => '<strong>John</strong>',
            'authenticated' => false,
        ]);

        $this->assertEquals($output, $this->expected('other'));
    }

    private function expected(string $file): string
    {
        $file_path = __DIR__.'/expected/'.$file.'.html';

        return file_get_contents($file_path);
    }

    public function testExtends()
    {
        $output = $this->blade->make('extends');

        $this->assertEquals($output, $this->expected('extends'));
    }
}
