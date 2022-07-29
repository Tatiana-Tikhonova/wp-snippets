<?php

/**
 * Function for `nav_menu_submenu_css_class` filter-hook.
 * 
 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
 * @param int      $depth   Depth of menu item. Used for padding.
 *
 * @return string[]
 */
function taty_submenu_css_class_filter($classes, $args, $depth)
{

    if ('menu-1' == $args->theme_location) {

        $level = $depth + 1;
        $classes[] = 'main-menu__sub-menu sub-menu_level-' . $level;
    }

    return $classes;
}
add_filter('nav_menu_submenu_css_class', 'taty_submenu_css_class_filter', 10, 3);

/**
 * Function for `nav_menu_css_class` filter-hook.
 * 
 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
 * @param WP_Post  $menu_item The current menu item object.
 * @param stdClass $args      An object of wp_nav_menu() arguments.
 * @param int      $depth     Depth of menu item. Used for padding.
 *
 * @return string[]
 */
function taty_menu_css_class_filter($classes, $menu_item, $args, $depth)
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
add_filter('nav_menu_css_class', 'taty_menu_css_class_filter', 10, 4);

/**
 * Function for `nav_menu_link_attributes` filter-hook.
 * 
 * @param array    $atts      The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 * @param WP_Post  $menu_item The current menu item object.
 * @param stdClass $args      An object of wp_nav_menu() arguments.
 * @param int      $depth     Depth of menu item. Used for padding.
 *
 * @return array
 */
function taty_menu_link_attributes_filter($atts, $menu_item, $args, $depth)

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
add_filter('nav_menu_link_attributes', 'taty_menu_link_attributes_filter', 10, 4);


/**
 * Function for `walker_nav_menu_start_el` filter-hook.
 * 
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $menu_item   Menu item data object.
 * @param int      $depth       Depth of menu item. Used for padding.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 *
 * @return string
 */
function taty_filter_walker_nav_menu_start_el($item_output, $item, $depth, $args)
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
add_filter('walker_nav_menu_start_el', 'taty_filter_walker_nav_menu_start_el', 10, 4);