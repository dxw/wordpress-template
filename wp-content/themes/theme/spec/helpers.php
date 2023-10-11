<?php

function get_plugin_data($a)
{
	return [
		'/path/to/plugins/path-to/a-required-plugin.php' => [
			'Name' => 'A plugin',
		],
		'/path/to/plugins/advanced-custom-fields-pro/acf.php' => [
			'Name' => 'Advanced Custom Fields Pro',
		],
	][$a];
}
