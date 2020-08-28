<?php

namespace Theme\Posts;

describe(PostTypes::class, function () {
    beforeEach(function () {
        $this->postTypes = new PostTypes();
    });

    it('is registrable', function () {
        expect($this->postTypes)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        xit('registers any custom post types', function () {
            $this->postTypes->register();
        });
    });
});
