<?php
defined('ABSPATH') || exit;
function tati_text_metabox()
{
    add_meta_box(
        '_tati_text_date',
        'Даты проведения акции',
        'tati_text_metabox_callback',
        array('post')
    );
}
function tati_text_metabox_callback($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'tati_text_metabox_nonce');
    $tati_text_metabox = get_post_meta($post->ID);
    echo '<p>Заголовок метабокса</p>';
    echo '<label for="_tati_text_date">Подсказка</label> ';
    echo '<input type="text" name="_tati_text_date" id="_tati_text_date" value="' . $tati_text_metabox["_tati_text_date"][0] . '" style="width: 100%;"/>';
    // echo '</p>';
}

add_action('add_meta_boxes', 'tati_text_metabox');

function tati_text_metabox_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_text_metabox_nonce']) && wp_verify_nonce($_POST['tati_text_metabox_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['_tati_text_date']) && '' != $_POST['_tati_text_date']) {
        update_post_meta($post_id, '_tati_text_date', $_POST['_tati_text_date']);
    } elseif (isset($_POST['_tati_text_date']) && '' == $_POST['_tati_text_date']) {
        delete_post_meta($post_id, '_tati_text_date');
    }
}
add_action('save_post', 'tati_text_metabox_save');
