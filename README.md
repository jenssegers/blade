# Blade

[![Latest Stable Version](http://img.shields.io/github/release/jenssegers/blade.svg)](https://packagist.org/packages/jenssegers/blade) [![Build Status](http://img.shields.io/travis/jenssegers/blade.svg)](https://travis-ci.org/jenssegers/blade) [![Coverage Status](http://img.shields.io/coveralls/jenssegers/blade.svg)](https://coveralls.io/r/jenssegers/blade)

The standalone version of [Laravel's Blade templating engine](https://laravel.com/docs/5.8/blade) for use outside of Laravel.

<p align="center">
<img src="https://jenssegers.com/uploads/images/blade2.png" height="200">
</p>

## Installation

Install using composer:

```bash
composer require jenssegers/blade
```

## Usage

Create a Blade instance by passing it the folder(s) where your view files are located, and a cache folder. Render a template by calling the `make` method. More information about the Blade templating engine can be found on http://laravel.com/docs/5.8/blade.

```php
use Jenssegers\Blade\Blade;

$blade = new Blade('views', 'cache');

echo $blade->make('homepage', ['name' => 'John Doe']);
```

You can also extend Blade using the `directive()` function:

```php
$blade->directive('datetime', function ($expression) {
    return "<?php echo with({$expression})->format('F d, Y g:i a'); ?>";
});
```

Which allows you to use the following in your blade template:

```
Current date: @datetime($date)
```

The Blade instances passes all methods to the internal view factory. So methods such as `exists`, `file`, `share`, `composer` and `creator` are available as well. Check out the [original documentation](https://laravel.com/docs/5.8/views) for more information.

## Integrations

- [Phalcon Slayer Framework](https://github.com/phalconslayer/slayer) comes out of the box with Blade.

## Contributors

### Code Contributors

This project exists thanks to all the people who contribute. [[Contribute](CONTRIBUTING.md)].
<a href="https://github.com/jenssegers/blade/graphs/contributors"><img src="https://opencollective.com/jenssegers-blade/contributors.svg?width=890&button=false" /></a>

### Financial Contributors

Become a financial contributor and help us sustain our community. [[Contribute](https://opencollective.com/jenssegers-blade/contribute)]

#### Individuals

<a href="https://opencollective.com/jenssegers-blade"><img src="https://opencollective.com/jenssegers-blade/individuals.svg?width=890"></a>

#### Organizations

Support this project with your organization. Your logo will show up here with a link to your website. [[Contribute](https://opencollective.com/jenssegers-blade/contribute)]

<a href="https://opencollective.com/jenssegers-blade/organization/0/website"><img src="https://opencollective.com/jenssegers-blade/organization/0/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/1/website"><img src="https://opencollective.com/jenssegers-blade/organization/1/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/2/website"><img src="https://opencollective.com/jenssegers-blade/organization/2/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/3/website"><img src="https://opencollective.com/jenssegers-blade/organization/3/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/4/website"><img src="https://opencollective.com/jenssegers-blade/organization/4/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/5/website"><img src="https://opencollective.com/jenssegers-blade/organization/5/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/6/website"><img src="https://opencollective.com/jenssegers-blade/organization/6/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/7/website"><img src="https://opencollective.com/jenssegers-blade/organization/7/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/8/website"><img src="https://opencollective.com/jenssegers-blade/organization/8/avatar.svg"></a>
<a href="https://opencollective.com/jenssegers-blade/organization/9/website"><img src="https://opencollective.com/jenssegers-blade/organization/9/avatar.svg"></a>
