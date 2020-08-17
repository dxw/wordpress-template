<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(Pagination::class, function () {
    afterEach(function () {
        \Mockery::close();
    });

    it('registers the function in the constructor', function () {
        $helpersMock = \Mockery::mock(\Dxw\Iguana\Theme\Helpers::class);
        $helpersMock->shouldReceive('registerFunction')->once();
        $pagination = new \Theme\Theme\Pagination($helpersMock);
    });

    describe('->pagination()', function () {
        xit('adds custom pagination links', function () {
            $this->pagination->pagination();
        });
    });
});
