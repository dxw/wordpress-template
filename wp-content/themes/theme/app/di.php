<?php

$registrar->addInstance(\Dxw\Iguana\Theme\Helpers::class, new \Dxw\Iguana\Theme\Helpers());
$registrar->addInstance(\Dxw\Iguana\Theme\LayoutRegister::class, new \Dxw\Iguana\Theme\LayoutRegister(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));
$registrar->addInstance(\Dxw\Iguana\Extras\UseAtom::class, new \Dxw\Iguana\Extras\UseAtom());

// Libraries and support code
$registrar->addInstance(\Theme\Lib\Whippet\TemplateTags::class, new \Theme\Lib\Whippet\TemplateTags(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));

// Theme behaviour, media, assets and template tags
$registrar->addInstance(\Theme\Theme\Scripts::class, new \Theme\Theme\Scripts(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));
$registrar->addInstance(\Theme\Theme\Media::class, new \Theme\Theme\Media());
$registrar->addInstance(\Theme\Theme\Menus::class, new \Theme\Theme\Menus());
$registrar->addInstance(\Theme\Theme\Widgets::class, new \Theme\Theme\Widgets());
$registrar->addInstance(\Theme\Theme\Analytics::class, new \Theme\Theme\Analytics());
$registrar->addInstance(\Theme\Theme\TitleTag::class, new \Theme\Theme\TitleTag());
$registrar->addInstance(\Theme\Theme\Pagination::class, new \Theme\Theme\Pagination(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));

// Post types and additional fields
$registrar->addInstance(\Theme\Posts\PostTypes::class, new \Theme\Posts\PostTypes());
$registrar->addInstance(\Theme\Posts\CustomFields::class, new \Theme\Posts\CustomFields());

// Plugin dependency check - pass in any required plugins
$registrar->addInstance(\Theme\Theme\Plugins::class, new \Theme\Theme\Plugins([
//    'advanced-custom-fields/acf.php', // Path to main plugin file
]));
