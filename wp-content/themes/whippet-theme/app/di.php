<?php

$registrar->addInstance(\Dxw\Iguana\Theme\Helpers::class, new \Dxw\Iguana\Theme\Helpers());
$registrar->addInstance(\Dxw\Iguana\Theme\LayoutRegister::class, new \Dxw\Iguana\Theme\LayoutRegister(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));
$registrar->addInstance(\Dxw\Iguana\Extras\UseAtom::class, new \Dxw\Iguana\Extras\UseAtom());

// Libraries and support code
$registrar->addInstance(\Dxw\WhippetTheme\Lib\Whippet\TemplateTags::class, new \Dxw\WhippetTheme\Lib\Whippet\TemplateTags(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));

// Theme behaviour, media, assets and template tags
$registrar->addInstance(\Dxw\WhippetTheme\Theme\Scripts::class, new \Dxw\WhippetTheme\Theme\Scripts(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));
$registrar->addInstance(\Dxw\WhippetTheme\Theme\Media::class, new \Dxw\WhippetTheme\Theme\Media());
$registrar->addInstance(\Dxw\WhippetTheme\Theme\Menus::class, new \Dxw\WhippetTheme\Theme\Menus());
$registrar->addInstance(\Dxw\WhippetTheme\Theme\Widgets::class, new \Dxw\WhippetTheme\Theme\Widgets());
$registrar->addInstance(\Dxw\WhippetTheme\Theme\Analytics::class, new \Dxw\WhippetTheme\Theme\Analytics());
$registrar->addInstance(\Dxw\WhippetTheme\Theme\TitleTag::class, new \Dxw\WhippetTheme\Theme\TitleTag());
$registrar->addInstance(\Dxw\WhippetTheme\Theme\Pagination::class, new \Dxw\WhippetTheme\Theme\Pagination(
    $registrar->getInstance(\Dxw\Iguana\Theme\Helpers::class)
));

// Post types and additional fields
$registrar->addInstance(\Dxw\WhippetTheme\Posts\PostTypes::class, new \Dxw\WhippetTheme\Posts\PostTypes());
$registrar->addInstance(\Dxw\WhippetTheme\Posts\CustomFields::class, new \Dxw\WhippetTheme\Posts\CustomFields());

// Plugin dependency check - pass in any required plugins
$registrar->addInstance(\Dxw\WhippetTheme\Theme\Plugins::class, new \Dxw\WhippetTheme\Theme\Plugins([
//    'advanced-custom-fields/acf.php', // Path to main plugin file
]));
