<?php

/**
 * получить альт, заголовок, подпись, описание, ссылку на стр вложения и ссылку на файл картинки
 */
if (!function_exists('tati_get_post_thumbnail_info')) :
    function tati_get_post_thumbnail_info($post_id)
    {
        $attachment = get_post(get_post_thumbnail_id($post_id));
        return array(
            'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
            'title' => $attachment->post_title,
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href' => get_permalink($attachment->ID),
            'src' => $attachment->guid,
        );
    }
endif;
/**
 *  в шаблоне внутри цикла вывести полученные данные
 * <?php $img_info = tati_get_post_thumbnail_info(get_the_ID());?>
 * <div><?php echo $img_info['title']; ?></div>
 * <div><?php echo $img_info['caption']; ?></div>
 * <div><?php echo $img_info['description']; ?></div>
 */
