<?php
defined('ABSPATH') || exit;
function tati_color_mb()
{
    add_meta_box(
        'tati_color_ex',
        'Заголовок секции',
        'tati_color_mb_callback',
        array('post')
    );
}
function tati_color_mb_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'tati_color_mb_nonce');
    $tati_color_mb = get_post_meta($post->ID, 'tati_color_ex');
?>
    <p>Заголовок метабокса</p>
    <p>
        <label for="tati_color_ex" class="tati_color_ex">Выберите цвет</label>
        <input name="tati_color_ex" type="text" value="<?php echo $tati_color_mb[0];
                                                        ?>" class="tati_color" />

    </p>
<?php
}

add_action('add_meta_boxes', 'tati_color_mb');

function tati_color_mb_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_color_mb_nonce']) && wp_verify_nonce($_POST['tati_color_mb_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['tati_color_ex']) && '' != $_POST['tati_color_ex']) {
        update_post_meta($post_id, 'tati_color_ex', $_POST['tati_color_ex']);
    } elseif (isset($_POST['tati_color_ex']) && '' == $_POST['tati_color_ex']) {
        delete_post_meta($post_id, 'tati_color_ex');
    }
}
add_action('save_post', 'tati_color_mb_save');
/**
 * Loads the color picker javascript
 */
function tati_color_enqueue()
{
    global $typenow;
    if ($typenow == 'post') {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('tati-colorpicker-js', get_template_directory_uri() . '/tati-colorpicker.js', array('wp-color-picker'));
    }
}
add_action('admin_enqueue_scripts', 'tati_color_enqueue');
