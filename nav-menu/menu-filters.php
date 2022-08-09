<?php

/**
 * добавляем классы к суб-меню
 */
function tati_submenu_css_class_filter($classes, $args, $depth)
{

    if ('menu-1' == $args->theme_location) {

        $level = $depth + 1;
        $classes[] = 'main-menu__sub-menu sub-menu_level-' . $level;
    }

    return $classes;
}
add_filter('nav_menu_submenu_css_class', 'tati_submenu_css_class_filter', 10, 3);

/**
 * добавляем классы к пунктам меню
 */
function tati_menu_css_class_filter($classes, $menu_item, $args, $depth)
{

    if ('menu-1' == $args->theme_location) {
        if (0 == $depth) {

            $classes[] = 'main-menu__item';
        } else {
            $classes[] = 'sub-menu__item sub-menu__item_level-' . $depth;
        }
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'tati_menu_css_class_filter', 10, 4);

/**
 * добавляем классы к ссылкам меню
 */
function tati_menu_link_attributes_filter($atts, $menu_item, $args, $depth)

{

    if ('menu-1' == $args->theme_location) {
        if (0 == $depth) {
            $atts['class'] = 'main-menu__link';
        } else {
            $atts['class'] = 'sub-menu__link sub-menu__link_level-' . $depth;
        }
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'tati_menu_link_attributes_filter', 10, 4);


/**
 * добавляем маркер к родительским пунктам меню
 */
function tati_filter_walker_nav_menu_start_el($item_output, $item, $depth, $args)
{
    if ('menu-1' == $args->theme_location) {
        if ($item->current == 1) {
            $item_output = '<span class="current-menu-item-text">' . $item->title . '</span>';
        }

        if (in_array('menu-item-has-children', $item->classes) == 1) {
            $item_output .= '<span class="menu-item__after">
							<svg width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.5 7L0 0H13L6.5 7Z"/>
							</svg>
							</span>';
        }
    }


    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'tati_filter_walker_nav_menu_start_el', 10, 4);
