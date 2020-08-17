<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(Analytics::class, function () {
    beforeEach(function () {
        $this->analytics = new \Theme\Theme\Analytics();
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->analytics)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('registers actions', function () {
            PHPMockery::mock(__NAMESPACE__, 'add_action')->with('wp_footer', [$this->analytics, 'wpFooter'])->once();
            $this->analytics->register();
        });
    });

    describe('->wpFooter()', function () {
        it('adds a script tag to the footer', function () {
            ob_start();
            $this->analytics->wpFooter();
            $result = ob_get_contents();
            ob_end_clean();
            $result = str_replace(["\r", "\n"], '', $result);
            expect(preg_match('/^\s*<script>.*<\\/script>\s*$/', $result))->to->equal(1);
        });
    });
});
