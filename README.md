Blade
=====

[![Latest Stable Version](http://img.shields.io/github/release/jenssegers/blade.svg)](https://packagist.org/packages/jenssegers/blade) [![Build Status](http://img.shields.io/travis/jenssegers/blade.svg)](https://travis-ci.org/jenssegers/blade) [![Coverage Status](http://img.shields.io/coveralls/jenssegers/blade.svg)](https://coveralls.io/r/jenssegers/blade)

The standalone version of [Laravel's Blade templating engine](http://laravel.com/docs/5.1/blade) for use outside of Laravel.

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

The Blade instances passes all methods to the internal view factory. So methods such as `exists`, `file`, `share`, `composer` and `creator` are available as well. Check out the [original documentation](http://laravel.com/docs/5.1/views) for more information.
