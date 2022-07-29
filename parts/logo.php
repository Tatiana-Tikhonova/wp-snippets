<?php
function taty_change_logo_class($html)
{
    $html = str_replace('custom-logo', 'site-branding__logo', $html);
    $html = str_replace('custom-logo-link', 'site-branding__logo-link', $html);

    return $html;
}
add_filter('get_custom_logo', 'taty_change_logo_class');
