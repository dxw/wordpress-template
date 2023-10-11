<?php

namespace Theme\Lib\Whippet;

describe(TemplateTags::class, function () {
	beforeEach(function () {
		$this->helpersMock = Mockery::mock(\Dxw\Iguana\Theme\Helpers::class);
		$this->templateTags = new TemplateTags(
			$this->helpersMock
		);
	});

	describe('->w_template_title()', function () {
		xit('displays the title of the page', function () {
			$this->templateTags->w_template_title();
		});
	});
});
