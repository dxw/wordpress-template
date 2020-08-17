<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(WpHead::class, function () {
    beforeEach(function () {
        $this->wpHead = new \Theme\Theme\WpHead();
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->wpHead)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('adds actions', function () {
            PHPMockery::mock(__NAMESPACE__, 'add_action')->with('init', [$this->wpHead, 'init'])->once();
            $this->wpHead->register();
        });
    });

    describe('->init()', function () {
        it('modifies the output of the WordPress head', function () {
            $actions = [
                ['wp_head', 'print_emoji_detection_script', 7],
                ['wp_print_styles', 'print_emoji_styles'],
                ['admin_print_styles', 'print_emoji_styles'],
                ['admin_print_scripts', 'print_emoji_detection_script'],
                ['wp_head', 'rsd_link'],
                ['wp_head', 'wp_generator'],
                ['wp_head', 'wlwmanifest_link'],
                ['wp_head', 'feed_links_extra', 3],
                ['wp_head', 'start_post_rel_link', 10, 0],
                ['wp_head', 'parent_post_rel_link', 10, 0],
                ['wp_head', 'adjacent_posts_rel_link', 10, 0],
            ];

            $removeAction = PHPMockery::mock(__NAMESPACE__, 'remove_action');
            foreach ($actions as $args) {
                $removeAction->with(...$args)->times(1);
            }
            $this->wpHead->init();
        });
    });
});
