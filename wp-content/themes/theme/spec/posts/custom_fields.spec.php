<?php

namespace Theme\Posts;

describe(CustomFields::class, function () {
    beforeEach(function () {
        $this->customFields = new CustomFields();
    });

    it('is registrable', function () {
        expect($this->customFields)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        xit('registers any custom fields', function () {
            $this->customFields->register();
        });
    });
});
