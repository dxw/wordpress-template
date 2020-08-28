<?php

namespace Theme\Theme;

describe(Analytics::class, function () {
    beforeEach(function () {
        $this->analytics = new Analytics();
    });

    it('is registrable', function () {
        expect($this->analytics)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('registers actions', function () {
            allow('add_action')->toBeCalled();
            expect('add_action')->toBeCalled()->with('wp_footer', [$this->analytics, 'wpFooter']);
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
            expect(preg_match('/^\s*<script>.*<\\/script>\s*$/', $result))->toEqual(1);
        });
    });
});
