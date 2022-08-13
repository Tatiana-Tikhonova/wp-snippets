<?php
defined('ABSPATH') || exit;
function tati_select_mb()
{
    add_meta_box(
        'tati_select_ex',
        'Заголовок секции',
        'tati_select_mb_callback',
        array('post')
    );
}
function tati_select_mb_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'tati_select_mb_nonce');
    $tati_select_mb = get_post_meta($post->ID, 'tati_select_ex');
    echo '<pre>';
    print_r($tati_select_mb);
    echo '</pre>';
?>
    <p>Заголовок метабокса</p>
    <p>
        <label for="tati_select_ex" class="tati_select_ex">Подсказка</label>
        <select name="tati_select_ex" id="tati_select_ex">
            <option value="Понедельник" <?php if (in_array('Понедельник', $tati_select_mb)) echo 'selected="true"'; ?>>Понедельник</option>';
            <option value="Вторник" <?php if (in_array('Вторник', $tati_select_mb)) echo 'selected="true"'; ?>>Вторник</option>';
        </select>
    </p>
<?php
}

add_action('add_meta_boxes', 'tati_select_mb');

function tati_select_mb_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_select_mb_nonce']) && wp_verify_nonce($_POST['tati_select_mb_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['tati_select_ex']) && '' != $_POST['tati_select_ex']) {
        update_post_meta($post_id, 'tati_select_ex', $_POST['tati_select_ex']);
    } elseif (isset($_POST['tati_select_ex']) && '' == $_POST['tati_select_ex']) {
        delete_post_meta($post_id, 'tati_select_ex');
    }
}
add_action('save_post', 'tati_select_mb_save');
