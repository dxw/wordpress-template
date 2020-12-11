<?php

namespace Theme\Theme;

class Menus implements \Dxw\Iguana\Registerable
{
    public function register() : void
    {
        register_nav_menu('header', 'Header Menu');
        register_nav_menu('footer', 'Footer Menu');
    }
}
