<?php

namespace Theme\Theme;

describe(Pagination::class, function () {
	it('registers the function in the constructor', function () {
		$helpersMock = new class () extends \Dxw\Iguana\Theme\Helpers {
		};
		expect($helpersMock)->toReceive('registerFunction')->once();
		$pagination = new Pagination($helpersMock);
	});

	describe('->pagination()', function () {
		xit('adds custom pagination links', function () {
			$this->pagination->pagination();
		});
	});
});
