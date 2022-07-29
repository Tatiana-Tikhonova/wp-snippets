<?php
function prefix_register_post_type()
{
    register_post_type(
        'book',
        array(
            'labels'             => array(
                'name'                  => __('Books', 'prefix'),
                'singular_name'         => __('Book', 'prefix'),
                'menu_name'             => __('Books', 'prefix'),

            ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'book'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'show_in_rest'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            // 'menu_icon'          => 'dashicons-testimonial',
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        )
    );
}

add_action('init', 'prefix_register_post_type');
