<?php

/**
 * Class Taty_Walker_Nav_Menu extends Walker_Nav_Menu
 * для использования подключить в functions.php
 * require get_template_directory() . '/inc/class-taty-wp-walker.php';
 * в header при вызове wp_nav_menu 
 * в аргументы добавить 'walker' => new Taty_Walker_Nav_Menu(),
 */
class Taty_Walker_Nav_Menu extends Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = null)
    {

        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);
        $indent = ($depth > 0  ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0
        $wrapper_classes = 'main-menu__subwrap main-menu__subwrap_level-' . $display_depth;
        $classes = array(
            'sub-menu',
            'main-menu__sub-menu',
            'sub-menu_level-' . $display_depth
        );
        $class_names = implode(' ', $classes);

        $class_names = implode(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        $wrapper_start = '<ul class="' . $wrapper_classes . '">';
        $output .= "{$n}{$indent}{$wrapper_start}<div$class_names>{$n}";
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $wrapper_end = '</div>';
        $indent  = str_repeat($t, $depth);
        $output .= "$indent</ul>{$n}{$wrapper_end}";
    }

    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {

        $menu_item = $data_object;

        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $classes = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
        // add depth dependent classes
        if ($depth == 0) {
            $classes[] =   'main-menu__item';
        } else {
            $classes[] =   'sub-menu__item sub-menu__item_level-' . $depth;
        }
        if (in_array('menu-item-has-children', $classes)) {
            $classes['menu-item-has-children'] =   'parent-menu-item';
        }

        $args = apply_filters('nav_menu_item_args', $args, $menu_item, $depth);

        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $menu_item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';
        /**
         * работаем со ссылкой
         */
        $atts           = array();
        $atts['title']  = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
        $atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';
        if ($depth == 0) {
            $atts['class'] = 'main-menu__link';
        } else {
            $atts['class'] = 'sub-menu__link';
        }

        if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $menu_item->xfn;
        }
        $atts['href']         = !empty($menu_item->url) ? $menu_item->url : '';
        $atts['aria-current'] = $menu_item->current ? 'page' : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $menu_item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (is_scalar($value) && '' !== $value && false !== $value) {
                $value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $title = apply_filters('the_title', $menu_item->title, $menu_item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $menu_item, $args, $depth);

        $item_output  = $args->before;
        if (1 == $menu_item->current) {
            $item_output .= '<span class="' . $atts['class'] . ' ' . $atts['class'] . '_current">';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</span>';
        } else {
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
        }
        $item_output .= $args->after;

        /**
         * добавляем маркер к родительскому пункту меню
         */
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<span class="menu-item__after">
             							<svg width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg">
             							<path d="M6.5 7L0 0H13L6.5 7Z"/>
             							</svg>
             							</span>';
        }

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args);
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $output .= "</li>{$n}";
    }
}
