<?php

use Jenssegers\Blade\Blade;

class BladeTest extends PHPUnit_Framework_TestCase
{
    private $blade;

    public function setUp()
    {
        $this->blade = new Blade('tests/views', 'tests/cache');

        $this->blade->compiler()->directive('datetime', function ($expression) {
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

    public function testExtenderBlade()
    {
        $users = require __DIR__.'/data/users.php';

        $blade_name = 'extender';

        $output = $this->blade
            ->make($blade_name, $users)
            ->render();

        # uncomment if you want to update the sample output
        // $this->write($output, $blade_name);

        $this->assertEquals(
            $output,
            $this->read($blade_name)
        );
    }

    /**
     * Html Writer on sample_output folder
     *
     * @param string $output The HTML output
     * @param string $blade_name The blade file name/path
     *
     * @return void
     */
    private function write($output, $blade_name)
    {
        $file_path = __DIR__.'/sample_output/'.$blade_name.'.html';

        file_put_contents($file_path, $output);
    }

    /**
     * HTML Reader on sample_output folder
     *
     * @param string $blade_name The blade file name/path
     * @return string
     */
    private function read($blade_name)
    {
        $file_path = __DIR__.'/sample_output/'.$blade_name.'.html';

        return file_get_contents($file_path);
    }
}
