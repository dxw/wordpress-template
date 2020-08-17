<?php

namespace Theme\Posts;

use \phpmock\mockery\PHPMockery;

describe(CustomFields::class, function () {
    beforeEach(function () {
        $this->customFields = new \Theme\Posts\CustomFields();
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->customFields)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        xit('registers any custom fields', function () {
            $this->customFields->register();
        });
    });
});
