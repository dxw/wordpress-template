<?php

namespace Theme\Theme;

use Kahlan\Arg;

describe(Widgets::class, function () {
	beforeEach(function () {
		$this->widgets = new Widgets();
	});

	it('is registrable', function () {
		expect($this->widgets)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
	});

	describe('->register()', function () {
		it('initialises the widgets', function () {
			allow('add_action')->toBeCalled();
			expect('add_action')->toBeCalled()->once();
			expect('add_action')->toBeCalled()->with('widgets_init', [$this->widgets, 'widgetsInit']);
			$this->widgets->register();
		});
	});

	describe('->widgetsInit()', function () {
		it('registers any widgets in the theme ', function () {
			allow('__')->toBeCalled()->andRun(function ($a) {
				return $a;
			});

			allow('register_sidebar')->toBeCalled();
			expect('register_sidebar')->toBeCalled()->times(2);
			expect('register_sidebar')->toBeCalled()->with(Arg::toBeA('array'))->times(2);

			$this->widgets->widgetsInit();
		});
	});
});
