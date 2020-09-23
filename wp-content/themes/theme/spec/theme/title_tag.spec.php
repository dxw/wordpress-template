<?php

namespace Theme\Theme;

describe(TitleTag::class, function () {
    beforeEach(function () {
        $this->titleTag = new TitleTag();
    });

    it('is registrable', function () {
        expect($this->titleTag)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('adds support for title tag', function () {
            allow('add_theme_support')->toBeCalled();
            expect('add_theme_support')->toBeCalled()->once();
            expect('add_theme_support')->toBeCalled()->with('title-tag');
            $this->titleTag->register();
        });
    });
});
