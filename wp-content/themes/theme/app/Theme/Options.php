<?php

namespace Theme\Theme;

class Options implements \Dxw\Iguana\Registerable
{
    public function register()
    {
        add_action('init', [$this, 'registerPage']);
        add_action('init', [$this, 'registerFields']);
    }

    public function registerPage()
    {
        acf_add_options_page([
            'page_title'  => 'Global Content and Options',
            'menu_title'  => 'Global Options',
            'menu_slug'   => 'global-options',
            'capability'  => 'manage_options',
            'parent_slug' => '',
            'position'    => 2, // Below 'Dashboard' menu item
            'icon_url'    => 'dashicons-admin-generic',
        ]);
    }

    public function registerFields()
    {
        if (function_exists('acf_add_local_field_group')) {
            $fields = new \StoutLogic\AcfBuilder\FieldsBuilder('global_options', [
                'style' => 'seamless',
            ]);
            $fields
                ->addTab('header')
                ->addText('header_logo_alt_text')
                ->setLocation('options_page', '==', 'global-options');

            acf_add_local_field_group($fields->build());
        }
    }
}
