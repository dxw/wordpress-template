<?php

namespace Theme\Theme;

describe(Scripts::class, function () {
    beforeEach(function () {
        allow('esc_url')->toBeCalled()->andRun(function ($a) {
            return '_'.$a.'_';
        });
        $this->helpers = new \Dxw\Iguana\Theme\Helpers();
        $this->scripts = new Scripts($this->helpers);
    });

    it('is registrable', function () {
        expect($this->scripts)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('registers nav scripts', function () {
            allow('add_action')->toBeCalled();
            expect('add_action')->toBeCalled()->with('wp_enqueue_scripts', [$this->scripts, 'wpEnqueueScripts']);
            expect('add_action')->toBeCalled()->with('wp_print_scripts', [$this->scripts, 'wpPrintScripts']);

            $this->scripts->register();
        });
    });

    describe('->getAssetPath()', function () {
        it('gets the path of the assets', function () {
            allow('get_stylesheet_directory_uri')->toBeCalled()->with()->andReturn('http://foo.bar.invalid/cat/dog');
            expect($this->scripts->getAssetPath('meow'))->toEqual('http://foo.bar.invalid/cat/static/meow');
        });
    });

    describe('->assetPath()', function () {
        it('echos the path of the assets', function () {
            allow('get_stylesheet_directory_uri')->toBeCalled()->with()->andReturn('http://foo.bar.invalid/cat/dog');
            expect(function () {
                $this->scripts->assetPath('meow');
            })->toEcho('_http://foo.bar.invalid/cat/static/meow_');
        });
    });

    describe('->wpEnqueueScripts()', function () {
        it('enqueues some of the JavaScript files', function () {
            allow('get_stylesheet_directory_uri')->toBeCalled()->with()->andReturn('http://a.invalid/zzz');

            allow('wp_deregister_script')->toBeCalled();
            expect('wp_deregister_script')->toBeCalled()->with('jquery');

            allow('wp_enqueue_script')->toBeCalled();
            expect('wp_enqueue_script')->toBeCalled()->with('jquery', 'http://a.invalid/static/lib/jquery.min.js');

            expect('wp_enqueue_script')->toBeCalled()->with('modernizr', 'http://a.invalid/static/lib/modernizr.min.js');

            expect('wp_enqueue_script')->toBeCalled()->with('main', 'http://a.invalid/static/main.min.js', ['jquery', 'modernizr'], '', true);

            allow('wp_enqueue_style')->toBeCalled();
            expect('wp_enqueue_style')->toBeCalled()->with('main', 'http://a.invalid/static/main.min.css');

            $this->scripts->wpEnqueueScripts();
        });
    });

    describe('->wpPrintScripts()', function () {
        it('prints some elements tags directly', function () {
            allow('get_stylesheet_directory_uri')->toBeCalled()->with()->andReturn('http://a.invalid/zzz');
            expect(function () {
                $this->scripts->wpPrintScripts();
            })->toMatchEcho('/<meta .*>/');
            expect(function () {
                $this->scripts->wpPrintScripts();
            })->toMatchEcho('/<link .*>/');
        });
    });
});
