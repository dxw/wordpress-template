<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(Media::class, function () {
    beforeEach(function () {
        $this->media = new \Theme\Theme\Media();
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->media)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('registers thumbnail sizes', function () {
            PHPMockery::mock(__NAMESPACE__, 'set_post_thumbnail_size')->with(\Mockery::type('int'), \Mockery::type('int'), \Mockery::type('bool'))->times(1);

            PHPMockery::mock(__NAMESPACE__, 'add_image_size')->with(\Mockery::type('string'), \Mockery::type('int'), \Mockery::type('int'), \Mockery::type('bool'))->times(2);

            $this->media->register();
        });
    });
});
