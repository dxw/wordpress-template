<?php

$registrar->addInstance(new \Dxw\Iguana\Theme\Helpers());
$registrar->addInstance(new \Dxw\Iguana\Theme\LayoutRegister(
	$registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));
$registrar->addInstance(new \Dxw\Iguana\Extras\UseAtom());

// Libraries and support code
$registrar->addInstance(new \Theme\Lib\Whippet\TemplateTags(
	$registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));

// Theme behaviour, media, assets and template tags
$registrar->addInstance(new \Theme\Theme\Scripts(
	$registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));
$registrar->addInstance(new \Theme\Theme\Media());
$registrar->addInstance(new \Theme\Theme\Menus());
$registrar->addInstance(new \Theme\Theme\Widgets());
$registrar->addInstance(new \Theme\Theme\Analytics());
$registrar->addInstance(new \Theme\Theme\TitleTag());
$registrar->addInstance(new \Theme\Theme\Pagination(
	$registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));
$registrar->addInstance(new \Theme\Theme\Options());

// Post types and additional fields
$registrar->addInstance(new \Theme\Posts\PostTypes());
$registrar->addInstance(new \Theme\Posts\CustomFields());

// Plugin dependency check - pass in any required plugins
$registrar->addInstance(new \Theme\Theme\Plugins([
//    'advanced-custom-fields/acf.php', // Path to main plugin file
]));
