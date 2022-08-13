<?php
defined('ABSPATH') || exit;
function tati_text_mb()
{
    add_meta_box(
        'tati_text_ex',
        'Заголовок секции',
        'tati_text_mb_callback',
        array('post')
    );
}
function tati_text_mb_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'tati_text_mb_nonce');
    $tati_text_mb = get_post_meta($post->ID);
    echo '<p>Заголовок метабокса</p>';
    echo '<label for="tati_text_ex">Подсказка</label> ';
    echo '<input type="text" name="tati_text_ex" id="tati_text_ex" value="' . $tati_text_mb["tati_text_ex"][0] . '" style="width: 100%;"/>';
    // echo '</p>';
}

add_action('add_meta_boxes', 'tati_text_mb');

function tati_text_mb_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_text_mb_nonce']) && wp_verify_nonce($_POST['tati_text_mb_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['tati_text_ex']) && '' != $_POST['tati_text_ex']) {
        update_post_meta($post_id, 'tati_text_ex', $_POST['tati_text_ex']);
    } elseif (isset($_POST['tati_text_ex']) && '' == $_POST['tati_text_ex']) {
        delete_post_meta($post_id, 'tati_text_ex');
    }
}
add_action('save_post', 'tati_text_mb_save');
