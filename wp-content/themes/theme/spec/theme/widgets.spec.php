<?php

namespace Theme\Theme;

use \phpmock\mockery\PHPMockery;

describe(Widgets::class, function () {
    beforeEach(function () {
        $this->widgets = new \Theme\Theme\Widgets();
    });

    afterEach(function () {
        \Mockery::close();
    });

    it('is registrable', function () {
        expect($this->widgets)->to->be->an->instanceof(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('initialises the widgets', function () {
            PHPMockery::mock(__NAMESPACE__, 'add_action')->with('widgets_init', [$this->widgets, 'widgetsInit'])->once();
            $this->widgets->register();
        });
    });

    describe('->widgetsInit()', function () {
        it('registers any widgets in the theme ', function () {
            PHPMockery::mock(__NAMESPACE__, '__')->andReturnUsing(function ($a) {
                return $a;
            });

            PHPMockery::mock(__NAMESPACE__, 'register_sidebar')->with(\Mockery::type('array'))->times(2);

            $this->widgets->widgetsInit();
        });
    });
});
