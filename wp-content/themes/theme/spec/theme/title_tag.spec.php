<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(TitleTag::class, function () {
    beforeEach(function () {
        $this->titleTag = new \Theme\Theme\TitleTag();
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->titleTag)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('adds support for title tag', function () {
            PHPMockery::mock(__NAMESPACE__, 'add_theme_support')->with('title-tag')->times(1);
            $this->titleTag->register();
        });
    });
});
