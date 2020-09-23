<?php

namespace Theme\Theme;

require_once __DIR__.'/../helpers.php';

describe(Plugins::class, function () {
    beforeEach(function () {
        allow('esc_html')->toBeCalled()->andRun(function ($a) {
            return '_'.$a.'_';
        });

        allow('apply_filters')->toBeCalled()->andRun(function ($a, $b) {
            return $b;
        });

        if (!defined('WP_PLUGIN_DIR')) {
            define('WP_PLUGIN_DIR', '/path/to/plugins');
        }

        if (!defined('ABSPATH')) {
            define('ABSPATH', '/path/to/wp');
        }
    });

    it('is registrable', function () {
        $plugins = new Plugins([]);
        expect($plugins)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('registers theme activation hook', function () {
            $plugins = new Plugins([]);
            allow('add_action')->toBeCalled();
            expect('add_action')->toBeCalled()->once();
            expect('add_action')->toBeCalled()->with('after_switch_theme', [$plugins, 'checkDependencies']);
            $plugins->register();
        });
    });

    describe('->checkDependencies()', function () {
        it('flags any required plugins that aren\'t activated', function () {
            // get_plugin_data return values are stored in helpers.php
            allow('get_option')->toBeCalled()->with()->andReturn([
                'some-other/plugin.php'
            ]);
            allow('admin_url')->toBeCalled()->with('plugins.php')->andReturn('http://localhost/wp-admin/plugins.php');
            $plugins = new Plugins([
                'path-to/a-required-plugin.php',
                'advanced-custom-fields-pro/acf.php'
            ]);
            ob_start();
            $plugins->checkDependencies();
            $result = ob_get_contents();
            ob_end_clean();
            expect($result)->toContain('<div class="notice notice-warning">');
            expect($result)->toContain('<a href="http://localhost/wp-admin/plugins.php">Visit plugins page</a>');
            expect($result)->toContain('</div>');

            expect($result)->toContain('<strong>_A plugin_</strong>');
            expect($result)->toContain('<strong>_Advanced Custom Fields Pro_</strong>');
        });

        context('when the plugins are already active', function () {
            it('doesn\'t print anything', function () {
                allow('get_option')->toBeCalled()->with()->andReturn([
                    'some-other/plugin.php',
                    'path-to/a-required-plugin.php',
                    'advanced-custom-fields-pro/acf.php'
                ]);
                $plugins = new Plugins([
                    'path-to/a-required-plugin.php',
                    'advanced-custom-fields-pro/acf.php'
                ]);
                ob_start();
                $plugins->checkDependencies();
                $result = ob_get_contents();
                ob_end_clean();
                expect($result)->toBeEmpty();
            });
        });

        context('when there\'s no plugin data available', function () {
            it('displays the path of the plugin instead', function () {
                allow('get_option')->toBeCalled()->with()->andReturn([
                    'some-other/plugin.php',
                    'advanced-custom-fields-pro/acf.php'
                ]);
                allow('get_plugin_data')->toBeCalled()->with()->andReturn([
                    'Name' => ''
                ]);
                allow('admin_url')->toBeCalled()->with('plugins.php')->andReturn('http://localhost/wp-admin/plugins.php');
                $plugins = new Plugins([
                    'path-to/a-required-plugin.php',
                    'advanced-custom-fields-pro/acf.php'
                ]);
                ob_start();
                $plugins->checkDependencies();
                $result = ob_get_contents();
                ob_end_clean();

                expect($result)->toContain('<strong>_path-to/a-required-plugin.php_</strong>');
            });
        });
    });
});
