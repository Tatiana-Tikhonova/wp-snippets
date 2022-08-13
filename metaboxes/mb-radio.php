<?php
defined('ABSPATH') || exit;
function tati_radio_mb()
{
    add_meta_box(
        'tati_radio_ex',
        'Заголовок секции',
        'tati_radio_mb_callback',
        array('post')
    );
}
function tati_radio_mb_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'tati_radio_mb_nonce');
    $tati_radio_mb = get_post_meta($post->ID, 'tati_radio_ex'); ?>
    <p>Заголовок метабокса</p>
    <p>
        <input type="radio" name="tati_radio_ex" id="tati_radio_ex_1" value="yes" <?php if (in_array('yes', $tati_radio_mb)) echo 'checked="checked"'; ?> />
        <label for="tati_radio_ex_1">Да</label>
    </p>
    <p>
        <input type="radio" name="tati_radio_ex" id="tati_radio_ex_2" value="no" <?php if (in_array('no', $tati_radio_mb)) echo 'checked="checked"'; ?> />
        <label for="tati_radio_ex_2">Нет</label>
    </p>
<?php
}

add_action('add_meta_boxes', 'tati_radio_mb');

function tati_radio_mb_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_radio_mb_nonce']) && wp_verify_nonce($_POST['tati_radio_mb_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['tati_radio_ex']) && '' != $_POST['tati_radio_ex']) {
        update_post_meta($post_id, 'tati_radio_ex', $_POST['tati_radio_ex']);
    } elseif (isset($_POST['tati_radio_ex']) && '' == $_POST['tati_radio_ex']) {
        delete_post_meta($post_id, 'tati_radio_ex');
    }
}
add_action('save_post', 'tati_radio_mb_save');
