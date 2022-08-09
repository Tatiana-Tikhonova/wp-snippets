<?php
function tati_register_post_type()
{
    register_post_type(
        'book',
        array(
            'labels'             => array(
                'name'                  => __('Books', 'tati'),
                'singular_name'         => __('Book', 'tati'),
                'menu_name'             => __('Books', 'tati'),

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

add_action('init', 'tati_register_post_type');
