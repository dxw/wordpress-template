<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(Scripts::class, function () {
    beforeEach(function () {
        PHPMockery::mock(__NAMESPACE__, 'esc_url')->andReturnUsing(function ($a) {
            return '_'.$a.'_';
        });
        $this->helpers = new \Dxw\Iguana\Theme\Helpers();
        $this->scripts = new \Theme\Theme\Scripts($this->helpers);
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->scripts)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('registers nav scripts', function () {
            $addAction = PHPMockery::mock(__NAMESPACE__, 'add_action');
            $addAction->with('wp_enqueue_scripts', [$this->scripts, 'wpEnqueueScripts'])->once();
            $addAction->with('wp_print_scripts', [$this->scripts, 'wpPrintScripts'])->once();

            $this->scripts->register();
        });
    });

    describe('->getAssetPath()', function () {
        it('gets the path of the assets', function () {
            PHPMockery::mock(__NAMESPACE__, 'get_stylesheet_directory_uri')->with()->andReturn('http://foo.bar.invalid/cat/dog');
            expect($this->scripts->getAssetPath('meow'))->to->be->equal('http://foo.bar.invalid/cat/static/meow');
        });
    });

    describe('->assetPath()', function () {
        it('echos the path of the assets', function () {
            PHPMockery::mock(__NAMESPACE__, 'get_stylesheet_directory_uri')->with()->andReturn('http://foo.bar.invalid/cat/dog');
            ob_start();
            $this->scripts->assetPath('meow');
            $result = ob_get_contents();
            ob_end_clean();
            expect($result)->to->be->equal('_http://foo.bar.invalid/cat/static/meow_');
        });
    });

    describe('->wpEnqueueScripts()', function () {
        it('enqueues some of the JavaScript files', function () {
            PHPMockery::mock(__NAMESPACE__, 'get_stylesheet_directory_uri')->with()->andReturn('http://a.invalid/zzz');

            PHPMockery::mock(__NAMESPACE__, 'wp_deregister_script')->with('jquery')->times(1);

            $wpEnqueueScript = PHPMockery::mock(__NAMESPACE__, 'wp_enqueue_script');
            $wpEnqueueScript->with('jquery', 'http://a.invalid/static/lib/jquery.min.js')->times(1);

            $wpEnqueueScript->with('modernizr', 'http://a.invalid/static/lib/modernizr.min.js')->times(1);

            $wpEnqueueScript->with('main', 'http://a.invalid/static/main.min.js', ['jquery', 'modernizr'], '', true)->times(1);

            PHPMockery::mock(__NAMESPACE__, 'wp_enqueue_style')->with('main', 'http://a.invalid/static/main.min.css')->times(1);

            $this->scripts->wpEnqueueScripts();
        });
    });

    describe('->wpPrintScripts()', function () {
        it('prints some elements tags directly', function () {
            PHPMockery::mock(__NAMESPACE__, 'get_stylesheet_directory_uri')->with()->andReturn('http://a.invalid/zzz');
            ob_start();
            $this->scripts->wpPrintScripts();
            $result = ob_get_contents();
            ob_end_clean();
            expect(preg_match_all("/<meta .*>/", $result))->to->equal(1);
            expect(preg_match_all("/<link .*>/", $result))->to->equal(2);
        });
    });
});
