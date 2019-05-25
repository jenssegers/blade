<?php

use Jenssegers\Blade\Blade;
use PHPUnit\Framework\TestCase;

class BladeTest extends TestCase
{
    /**
     * @var Blade
     */
    private $blade;

    public function setUp()
    {
        $this->blade = new Blade('tests/views', 'tests/cache');

        $this->blade->directive('datetime', function ($expression) {
            return "<?php echo with({$expression})->format('F d, Y g:i a'); ?>";
        });
    }

    public function testBasic()
    {
        $output = $this->blade->make('basic')->render();
        $this->assertEquals('hello world', trim($output));
    }

    public function testVariables()
    {
        $output = $this->blade->make('variables', ['name' => 'John Doe'])->render();
        $this->assertEquals('hello John Doe', trim($output));
    }

    public function testNonBlade()
    {
        $output = $this->blade->make('plain')->render();
        $this->assertEquals('this is plain php', trim($output));
    }

    public function testRenderAlias()
    {
        $output = $this->blade->render('basic');
        $this->assertEquals('hello world', trim($output));
    }

    public function testDirective()
    {
        $output = $this->blade->render('directive', ['birthday' => new DateTime('1989/08/19')]);
        $this->assertEquals('Your birthday is August 19, 1989 12:00 am', trim($output));
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

        $output = $this->blade->render('other', [
            'users' => $users,
            'name' => '<strong>John</strong>',
            'authenticated' => false,
        ]);

        $this->write($output, 'other');

        $this->assertEquals($output, $this->expected('other'));
    }

    public function testExtends()
    {
        $output = $this->blade->make('extends')->render();

        $this->write($output, 'extends');

        $this->assertEquals($output, $this->expected('extends'));
    }

    private function write(string $output, string $file)
    {
        $file_path = __DIR__ . '/expected/' . $file . '.html';

        file_put_contents($file_path, $output);
    }

    private function expected(string $file): string
    {
        $file_path = __DIR__ . '/expected/' . $file . '.html';

        return file_get_contents($file_path);
    }
}
