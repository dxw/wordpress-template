<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(Menus::class, function () {
    beforeEach(function () {
        $this->menus = new \Theme\Theme\Menus();
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->menus)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('registers nav menus', function () {
            PHPMockery::mock(__NAMESPACE__, 'register_nav_menu')->with(\Mockery::type('string'), \Mockery::type('string'))->times(2);

            $this->menus->register();
        });
    });
});
