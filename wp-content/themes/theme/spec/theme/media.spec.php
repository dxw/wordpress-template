<?php

namespace Theme\Theme;

use Kahlan\Arg;

describe(Media::class, function () {
	beforeEach(function () {
		$this->media = new Media();
	});

	it('is registrable', function () {
		expect($this->media)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
	});

	describe('->register()', function () {
		it('registers thumbnail sizes', function () {
			allow('set_post_thumbnail_size')->toBeCalled();
			expect('set_post_thumbnail_size')->toBeCalled()->once();
			expect('set_post_thumbnail_size')->toBeCalled()->with(Arg::toBeA('int'), Arg::toBeA('int'), Arg::toBeA('bool'));

			allow('add_image_size')->toBeCalled();
			expect('add_image_size')->toBeCalled()->times(2);
			expect('add_image_size')->toBeCalled()->with(Arg::toBeA('string'), Arg::toBeA('int'), Arg::toBeA('int'), Arg::toBeA('bool'));

			$this->media->register();
		});
	});
});
