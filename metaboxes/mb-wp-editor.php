<?php
if (!defined('ABSPATH')) {
    die();
}


function tati_editor_mb()
{
    add_meta_box(
        'tati_editor_mb',
        'Характеристики',
        'tati_editor_mb_callback',
        array('post', 'product')
    );
}
function tati_editor_mb_callback($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'tati_editor_mb_nonce');
    $tati_editor_mb = get_post_meta($post->ID);
    wp_editor(
        wpautop($tati_editor_mb['tati_editor'][0]),
        'tati_editor_mb',
        array(
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
        )
    );
}
add_action('add_meta_boxes', 'tati_editor_mb');

function tati_editor_mb_meta_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_editor_mb_nonce']) && wp_verify_nonce($_POST['tati_editor_mb_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['tati_editor']) && '' != $_POST['tati_editor']) {
        update_post_meta($post_id, 'tati_editor', $_POST['tati_editor']);
    } elseif (isset($_POST['tati_editor']) && '' == $_POST['tati_editor']) {
        delete_post_meta($post_id, 'tati_editor');
    }
}
add_action('save_post', 'tati_editor_mb_meta_save');
