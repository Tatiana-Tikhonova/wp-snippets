<?php
defined('ABSPATH') || exit;
function tati_image_mb()
{
    add_meta_box(
        'tati_image_ex',
        'Заголовок секции',
        'tati_image_mb_callback',
        array('post')
    );
}
function tati_image_mb_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'tati_image_mb_nonce');
    $tati_image_mb = get_post_meta($post->ID, 'tati_image_ex');
    echo '<pre>';
    print_r($tati_image_mb);
    echo '</pre>';
?>
    <p>Заголовок метабокса</p>
    <p class="tati-image-metabox" style="max-width: 200px;">
        <!-- <label for="tati_image_ex" class="tati_image_label">Картинка</label> -->
        <?php if (isset($tati_image_mb[0])) : ?>
            <img id="tati_image" src="<?php echo $tati_image_mb[0]; ?>" alt="">
        <?php endif ?>

        <input type="hidden" name="tati_image_ex" id="tati_image_input" value="<?php if (isset($tati_image_mb[0])) echo $tati_image_mb[0]; ?>" />
        <?php if (isset($tati_image_mb[0])) : ?>
            <input type="button" id="tati_image_button" class="button" value="Выберите изображение" style="margin-bottom: 5px;" />
            <input type="button" id="tati_image_delete" class="button" value="Удалить изображение" style="margin-bottom: 5px;" />
        <?php else : ?>
            <input type="button" id="tati_image_button" class="button" value="Выберите изображение" style="width:100%; height:100px; margin-bottom: 5px;" />
            <input type="button" id="tati_image_delete" class="button" value="Удалить изображение" style="display:none; margin-bottom: 5px;" />
        <?php endif ?>
    </p>
<?php
}

add_action('add_meta_boxes', 'tati_image_mb');

function tati_image_mb_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['tati_image_mb_nonce']) && wp_verify_nonce($_POST['tati_image_mb_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['tati_image_ex']) && '' != $_POST['tati_image_ex']) {
        update_post_meta($post_id, 'tati_image_ex', $_POST['tati_image_ex']);
    } elseif (isset($_POST['tati_image_ex']) && '' == $_POST['tati_image_ex']) {
        delete_post_meta($post_id, 'tati_image_ex');
    }
}
add_action('save_post', 'tati_image_mb_save');
/**
 * Loads the image picker javascript
 */
function tati_image_enqueue()
{
    global $typenow;
    if ($typenow == 'post') {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script('meta-box-image', get_template_directory_uri() . '/tati-image-mb.js', array('jquery'));
        wp_localize_script(
            'meta-box-image',
            'tati_image_ex',
            array()
        );
        wp_enqueue_script('meta-box-image');
    }
}
add_action('admin_enqueue_scripts', 'tati_image_enqueue');
