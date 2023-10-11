<?php

namespace Theme\Theme;

use Kahlan\Arg;

describe(Menus::class, function () {
	beforeEach(function () {
		$this->menus = new Menus();
	});

	it('is registrable', function () {
		expect($this->menus)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
	});

	describe('->register()', function () {
		it('registers nav menus', function () {
			allow('register_nav_menu')->toBeCalled();
			expect('register_nav_menu')->toBeCalled()->times(2);
			expect('register_nav_menu')->toBeCalled()->with(Arg::toBeA('string'), Arg::toBeA('string'))->times(2);

			$this->menus->register();
		});
	});
});
