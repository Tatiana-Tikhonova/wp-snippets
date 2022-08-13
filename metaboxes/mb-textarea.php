<?php
defined('ABSPATH') || exit;
function tati_textarea_mb()
{
    add_meta_box(
        'tati_textarea_ex',
        'Заголовок секции',
        'tati_textarea_mb_callback',
        array('post')
    );
}
function tati_textarea_mb_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'tati_textarea_mb_nonce');
    $tati_textarea_mb = get_post_meta($post->ID); ?>
    <p>Заголовок метабокса</p>
    <label for="tati_textarea_ex">Подсказка</label>
    <textarea name="tati_textarea_ex" id="tati_textarea_ex" value="<?php $tati_textarea_mb["tati_textarea_ex"][0] ?>" style="width: 100%;"></textarea>


<?php

}

add_action('add_meta_boxes', 'tati_textarea_mb');

function tati_textarea_mb_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_textarea_mb_nonce']) && wp_verify_nonce($_POST['tati_textarea_mb_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['tati_textarea_ex']) && '' != $_POST['tati_textarea_ex']) {
        update_post_meta($post_id, 'tati_textarea_ex', $_POST['tati_textarea_ex']);
    } elseif (isset($_POST['tati_textarea_ex']) && '' == $_POST['tati_textarea_ex']) {
        delete_post_meta($post_id, 'tati_textarea_ex');
    }
}
add_action('save_post', 'tati_textarea_mb_save');
