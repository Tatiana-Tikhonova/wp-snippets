<?php

/**
 * мини-редактор
 * несовместим с гутенбергом
 */
if (!defined('ABSPATH')) {
    die();
}


function tati_mb_editor()
{
    add_meta_box(
        'tati_editor_ex',
        'Инструкция',
        'tati_mb_editor_callback',
        array('post', 'product')
    );
}
function tati_mb_editor_callback($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'tati_mb_editor_nonce');
    $tati_mb_editor = get_post_meta($post->ID);
    wp_editor(wpautop($tati_mb_editor['tati_editor'][0]), 'tati_mb_editor', array(
        'wpautop'       => 0,
        'media_buttons' => 1,
        'textarea_name' => 'tati_editor',
        'textarea_rows' => 20,
        'tabindex'      => null,
        'editor_css'    => '',
        'editor_class'  => '',
        'teeny'         => 0,
        'dfw'           => 0,
        'tinymce'       => 1,
        'quicktags'     => 1,
        'drag_drop_upload' => false
    ));
}
add_action('add_meta_boxes', 'tati_mb_editor');

function tati_mb_editor_meta_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_mb_editor_nonce']) && wp_verify_nonce($_POST['tati_mb_editor_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['tati_editor']) && '' != $_POST['tati_editor']) {
        update_post_meta($post_id, 'tati_editor', $_POST['tati_editor']);
    } elseif (isset($_POST['tati_editor']) && '' == $_POST['tati_editor']) {
        delete_post_meta($post_id, 'tati_editor');
    }
}
add_action('save_post', 'tati_mb_editor_meta_save');
