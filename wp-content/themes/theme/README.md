# whippet-theme-template

A template with everything you need to make a modern WordPress theme.

## Installation

Generate a new theme via [whippet](https://github.com/dxw/whippet)

- `whippet generate theme --d=directory-name`

## Health warning

This theme template is primarily made for dxw's needs, but we hope that it will be of some use to other WordPress developers. We'd love it if you want to have a play and give us your thoughts - and pull requests are gratefully received.

## iguana

This theme template makes use of [iguana](https://github.com/dxw/iguana) for dependency injection and auto-registration, [iguana-theme](https://github.com/dxw/iguana-theme) for helper functions, and [iguana-extras](https://github.com/dxw/iguana-extras) for other little modules.

## Code layout

- PHP for templates lives in `templates/`, everything else lives in `app/` and is tested with [Peridot](http://peridot-php.github.io/) tests that live in `spec/`.
- The main JavaScript file is `assets/js/main.js`. It is compiled into `static/main.min.js` with [browserify](http://browserify.org/) so `main.js` is typically just a list of `require()`s.
- The main SCSS file is `assets/scss/main.scss`. It is compiled into `static/main.min.css` with [SASS](http://sass-lang.com/) so `main.scss` is typically just a list of `@import`s.
- Images live in `assets/img/`. They are pre-processed/minified into `static/img/`.

## SASS Libraries

- [Normalize.css](http://necolas.github.io/normalize.css/) - makes browsers render all elements more consistently
- [Bourbon](http://bourbon.io/) - lightweight mixin library
- [Neat](http://neat.bourbon.io/) - lightweight and flexible grid


## Commands

Run PHP tests:

    vendor/bin/peridot spec

Build JS/CSS:

    yarn run grunt

Build JS/CSS upon file modification:

    yarn run grunt watch

## Guide

### Calling some functions when the theme is loaded

In vanilla WordPress, you would add this to the end of `functions.php`:

```
register_post_type('abc', [ /* ... */ ]);
function my_theme_init() {
    // ...
}
add_action('init', 'my_theme_init');
```

In an iguana-style theme, you would put this in an new file, say `app/RegisterStuff.php`:

```
<?php

namespace Theme;

class RegisterStuff implements \Dxw\Iguana\Registerable
{
    public function register()
    {
        register_post_type('abc', [ /* ... */  ]);
        add_action('init', [$this, 'init']);
    }

    public function init()
    {
        // ...
    }
}
```

And add a line to the end of `app/di.php` to instantiate this class:

```
$registrar->addInstance(\Theme\RegisterStuff::class, new \Theme\RegisterStuff());
```

### Adding a new helper function

In vanilla WordPress you might add a helper functions to the end of `functions.php` like so:

```
function foo()
{
    ...
}
```

But with iguana, we define that in a class too, say `app/HelperFunctions.php`:

```
<?php

namespace Theme;

class HelperFunctions
{
    public function __construct(\Dxw\Iguana\Theme\Helpers $helpers)
    {
        $helpers->registerFunction('foo', [$this, 'foo']);
    }

    public function foobar()
    {
        // ...
    }
}
```

And then we add a line like this to `app/di.php`:

```
$registrar->addInstance(\Theme\HelperFunctions::class, new \Theme\HelperFunctions(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));
```

And instead of using `foo()` in your template code, use `h()->foo()`.

## Licence

[MIT](COPYING.md)
