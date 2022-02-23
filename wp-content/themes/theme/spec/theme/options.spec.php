<?php

namespace Theme\Theme;

use Kahlan\Arg;

describe(Options::class, function () {
    beforeEach(function () {
        $this->options = new Options();
    });

    describe('->register()', function () {
        it('adds the action', function () {
            allow('add_action')->toBeCalled();
            expect('add_action')->toBeCalled()->once()->with('init', [$this->options, 'registerPage']);
            expect('add_action')->toBeCalled()->once()->with('init', [$this->options, 'registerFields']);
            $this->options->register();
        });
    });

    describe('->registerPage()', function () {
        it('register the ACF option page, accessible to admins only', function () {
            allow('acf_add_options_page')->toBeCalled();
            expect('acf_add_options_page')->toBeCalled()->once()->with(Arg::toBeAn('array'));
            $this->options->registerPage();
        });
    });

    describe('->registerFields()', function () {
        it('adds the fields for the ACF option page', function () {
            allow('function_exists')->toBeCalled()->andReturn(true);

            $fieldsBuilderDouble = \Kahlan\Plugin\Double::instance();
            allow('StoutLogic\AcfBuilder\FieldsBuilder')->toBe($fieldsBuilderDouble);
            allow($fieldsBuilderDouble)->toReceive('build')->andReturn('built fields');
            expect($fieldsBuilderDouble)->toReceive('build')->once();

            allow('acf_add_local_field_group')->toBeCalled();
            expect('acf_add_local_field_group')->toBeCalled()->once()->with('built fields');
            $this->options->registerFields();
        });
    });
});
