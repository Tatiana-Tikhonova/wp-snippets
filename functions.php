<?php

/**
 * register taxonomy
 */
require get_template_directory() . '/inc/custom-taxonomy.php';
/**
 * register custom post-type
 */
require get_template_directory() . '/inc/custom-post-type.php';
add_filter('post_class', 'tati_post_class_filter', 10, 3);

/**
 * Добавляем нужный класс к тегам на нужных страницах
 * для стилей списков внутри стандарной области вывода контента
 * 
 * @param string[] $classes An array of post class names.
 * @param string[] $class   An array of additional class names added to the post.
 * @param int      $post_id The post ID.
 *
 * @return string[]
 */
function tati_post_class_filter($classes, $class, $post_id)
{

    if (is_singular()) {
        $classes[] = 'some-class';
        echo '<pre>';
        print_r($classes);
        echo '</pre>';
    }
    return $classes;
}

// подключение всех стилей в подвале
function tati_add_footer_styles()
{
    wp_enqueue_style('tati-footer-styles', get_template_directory_uri() . '/assets/css/main.css', array(), _S_VERSION);
    wp_enqueue_style('tati-why-styles', get_template_directory_uri() . '/assets/css/why.css', array(), _S_VERSION);
};
add_action('get_footer', 'tati_add_footer_styles');
