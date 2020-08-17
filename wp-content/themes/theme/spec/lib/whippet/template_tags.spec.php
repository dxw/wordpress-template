<?php

namespace Theme\Lib\Whippet;

use \phpmock\mockery\PHPMockery;

describe(TemplateTags::class, function () {
    beforeEach(function () {
        $this->helpersMock = \Mockery::mock(\Dxw\Iguana\Theme\Helpers::class);
        $this->templateTags = new \Theme\Lib\Whippet\TemplateTags(
            $this->helpersMock
        );
    });

    afterEach(function () {
        \Mockery::close();
    });

    describe('->w_template_title()', function () {
        xit('displays the title of the page', function () {
            $this->templateTags->w_template_title();
        });
    });
});
