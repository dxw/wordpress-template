<?php

namespace Theme\Posts;

use \phpmock\mockery\PHPMockery;

describe(PostTypes::class, function () {
    beforeEach(function () {
        $this->postTypes = new \Theme\Posts\PostTypes();
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->postTypes)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        xit('registers any custom post types', function () {
            $this->postTypes->register();
        });
    });
});
