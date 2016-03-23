Blade
=====

[![Latest Stable Version](http://img.shields.io/github/release/jenssegers/blade.svg)](https://packagist.org/packages/jenssegers/blade) [![Build Status](http://img.shields.io/travis/jenssegers/blade.svg)](https://travis-ci.org/jenssegers/blade) [![Coverage Status](http://img.shields.io/coveralls/jenssegers/blade.svg)](https://coveralls.io/r/jenssegers/blade)

The standalone version of [Laravel's Blade templating engine](http://laravel.com/docs/5.1/blade) for use outside of Laravel.

<p align="center">
<img src="https://jenssegers.com/uploads/images/blade2.png" height="200">
</p>

Installation
------------

Install using composer:

```bash
composer require jenssegers/blade
```

Usage
-----

Create a Blade instance by passing it the folder(s) where your view files are located, and a cache folder. Render a template by calling the `make` method. More information about the Blade templating engine can be found on http://laravel.com/docs/5.1/blade.

```php
use Jenssegers\Blade\Blade;

$blade = new Blade('views', 'cache');

echo $blade->make('homepage', ['name' => 'John Doe']);
```

Now you can easily create a directive by calling the ``compiler()`` function

```php
$blade->compiler()->directive('datetime', function ($expression) {
    return "<?php echo with({$expression})->format('F d, Y g:i a'); ?>";
});

{{-- In your Blade Template --}}
<?php $dateObj = new DateTime('2017-01-01 23:59:59') ?>
@datetime($dateObj)
```

The Blade instances passes all methods to the internal view factory. So methods such as `exists`, `file`, `share`, `composer` and `creator` are available as well. Check out the [original documentation](http://laravel.com/docs/5.2/views) for more information.

Integrations
-----

- [Phalcon Slayer Framework](https://github.com/phalconslayer/slayer) comes out of the box with Blade.
