<?php

namespace Theme\Theme;

class TitleTag implements \Dxw\Iguana\Registerable
{
    public function register() : void
    {
        add_theme_support('title-tag');
    }
}
