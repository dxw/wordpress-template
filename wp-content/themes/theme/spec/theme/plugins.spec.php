<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(Plugins::class, function () {
    beforeEach(function () {
        PHPMockery::mock(__NAMESPACE__, 'esc_html')->andReturnUsing(function ($a) {
            return '_'.$a.'_';
        });
        PHPMockery::mock(__NAMESPACE__, 'apply_filters')->andReturnUsing(function ($a, $b) {
            return $b;
        });
        if (!defined('WP_PLUGIN_DIR')) {
            define('WP_PLUGIN_DIR', '/path/to/plugins');
        }
        if (!defined('ABSPATH')) {
            define('ABSPATH', '/abspath');
        }
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        $plugins = new \Theme\Theme\Plugins([]);
        expect($plugins)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('registers theme activation hook', function () {
            $plugins = new \Theme\Theme\Plugins([]);
            PHPMockery::mock(__NAMESPACE__, 'add_action')->with('after_switch_theme', [$plugins, 'checkDependencies'])->once();
            $plugins->register();
        });
    });

    describe('->checkDependencies()', function () {
        it('flags any required plugins that aren\'t activated', function () {
            PHPMockery::mock(__NAMESPACE__, 'get_option')->with('active_plugins')->times(1)->andReturn([
                'some-other/plugin.php',
            ]);
            $getPluginData = PHPMockery::mock(__NAMESPACE__, 'get_plugin_data');
            $getPluginData->with(WP_PLUGIN_DIR.'/path-to/a-required-plugin.php')->times(1)->andReturn([
                'Name' => 'A plugin',
            ]);
            $getPluginData->with(WP_PLUGIN_DIR.'/advanced-custom-fields-pro/acf.php')->times(1)->andReturn([
                'Name' => 'Advanced Custom Fields Pro',
            ]);
            PHPMockery::mock(__NAMESPACE__, 'admin_url')->with('plugins.php')->times(2)->andReturn('http://localhost/wp-admin/plugins.php');
            $plugins = new \Theme\Theme\Plugins([
                'path-to/a-required-plugin.php',
                'advanced-custom-fields-pro/acf.php'
            ]);

            // Prevent checkDependencies() from running require_once()
            $plugins->requireOnce = function () {
            };

            ob_start();
            $plugins->checkDependencies();
            $result = ob_get_contents();
            ob_end_clean();
            expect($result)->to->contain('<div class="notice notice-warning">');
            expect($result)->to->contain('<a href="http://localhost/wp-admin/plugins.php">Visit plugins page</a>');
            expect($result)->to->contain('</div>');

            expect($result)->to->contain('<strong>_A plugin_</strong>');
            expect($result)->to->contain('<strong>_Advanced Custom Fields Pro_</strong>');
        });

        context('when the plugins are already active', function () {
            it('doesn\'t print anything', function () {
                PHPMockery::mock(__NAMESPACE__, 'get_option')->with('active_plugins')->times(1)->andReturn([
                    'some-other/plugin.php',
                    'path-to/a-required-plugin.php',
                    'advanced-custom-fields-pro/acf.php',
                ]);
                $plugins = new \Theme\Theme\Plugins([
                    'path-to/a-required-plugin.php',
                    'advanced-custom-fields-pro/acf.php'
                ]);

                // Prevent checkDependencies() from running require_once()
                $plugins->requireOnce = function () {
                };

                ob_start();
                $plugins->checkDependencies();
                $result = ob_get_contents();
                ob_end_clean();
                expect($result)->to->be->empty;
            });
        });

        context('when there\'s no plugin data available', function () {
            it('displays the path of the plugin instead', function () {
                PHPMockery::mock(__NAMESPACE__, 'get_option')->with('active_plugins')->times(1)->andReturn([
                    'some-other/plugin.php',
                    'advanced-custom-fields-pro/acf.php',
                ]);
                PHPMockery::mock(__NAMESPACE__, 'get_plugin_data')->with(WP_PLUGIN_DIR.'/path-to/a-required-plugin.php')->times(1)->andReturn([
                    'Name' => '',
                ]);
                PHPMockery::mock(__NAMESPACE__, 'admin_url')->with('plugins.php')->times(1)->andReturn('http://localhost/wp-admin/plugins.php');
                $plugins = new \Theme\Theme\Plugins([
                    'path-to/a-required-plugin.php',
                    'advanced-custom-fields-pro/acf.php'
                ]);

                // Prevent checkDependencies() from running require_once()
                $plugins->requireOnce = function () {
                };

                ob_start();
                $plugins->checkDependencies();
                $result = ob_get_contents();
                ob_end_clean();

                expect($result)->to->contain('<strong>_path-to/a-required-plugin.php_</strong>');
            });
        });
    });
});
