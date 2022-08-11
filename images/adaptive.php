<?php

/**
 * docs: https://developer.wordpress.org/apis/handbook/responsive-images/
 * https://wp-kama.ru/function/wp_get_attachment_image_srcset
 * https://wp-kama.ru/function/wp_get_attachment_image_sizes
 * sizes - максимальная (или минимальная)ширина экрана и соответствующий размер картинки в пикс
 * несколько пар через запятую, в конце размер картинки по умолчанию
 * в паре с плагином EWWW image optimizer с использованием webp и тега picture работает просто супер!
 */
$img_src = wp_get_attachment_image_url($image_id, 'full');
$img_srcset = wp_get_attachment_image_srcset($image_id, 'medium-large');
/**
 * получить альт картинки по ее id
 */
$alt   = trim(strip_tags(get_post_meta($image_id, '_wp_attachment_image_alt', true)));
?>
<img src="<?php echo esc_url($img_src); ?>" srcset="<?php echo esc_attr($img_srcset); ?>" sizes="(max-width: 480px) 300px, (max-width: 768px) 768px, 100%" alt="<?php echo $alt ?>">
<?php

/**
 * адаптивный вывод миниатюры поста в зависимости от страницы и ширины экрана
 * в шаблоне в нужном месте цикла вставить <?php tati_adaptive_post_thumbnail(get_the_ID()); ?>
 */
if (!function_exists('tati_adaptive_post_thumbnail')) :
    function tati_adaptive_post_thumbnail($post_id)
    {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }
        $image_id = get_post_thumbnail_id($post_id);
        $alt   = trim(strip_tags(get_post_meta($image_id, '_wp_attachment_image_alt', true)));

        // для страницы поста
        $img_src_single = wp_get_attachment_image_url($image_id, 'full');
        $img_srcset = wp_get_attachment_image_srcset($image_id);

        // для страницы архива или индекса
        $img_src_loop = wp_get_attachment_image_url($image_id, 'medium-large');
        // srcset тот же что и для страницы поста

        if (is_singular()) :
?>
            <div class="post-thumbnail">
                <img src="<?php echo esc_url($img_src_single); ?>" srcset="<?php echo esc_attr($img_srcset); ?>" sizes="(max-width: 480px) 300px, (max-width: 768px) 768px, 100%" alt="<?php echo $alt ?>">
            </div>

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <img src="<?php echo esc_url($img_src_loop); ?>" srcset="<?php echo esc_attr($img_srcset); ?>" sizes="(max-width: 768px) 300px, 768px" alt="<?php echo $alt ?>">
            </a>

        <?php endif;
    }
endif;

/**
 * адаптивный вывод миниатюры поста в зависимости от страницы и ширины экрана
 * с подменой картинки на другую на нужном разрешении
 * в шаблоне в нужном месте цикла вставить <?php tati_adaptive_post_thumbnail_replace(get_the_ID()) ?>
 */
if (!function_exists('tati_adaptive_post_thumbnail_replace')) :
    function tati_adaptive_post_thumbnail_replace($post_id)
    {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }
        $image_id = get_post_thumbnail_id($post_id);
        $alt   = trim(strip_tags(get_post_meta($image_id, '_wp_attachment_image_alt', true)));

        // для страницы поста
        $img_src_single = wp_get_attachment_image_url($image_id, 'full');
        $img_srcset = wp_get_attachment_image_srcset($image_id);
        // другая картинка для подмены (из метабокса или кастомайзера)
        $img_srcset_mobile = explode(',', wp_get_attachment_image_srcset(56));
        // выбираем нужный размер (здесь 768px)
        $img_srcset_single_mobile = $img_srcset_mobile[1];
        // здесь 300px
        $img_srcset_loop_mobile = $img_srcset_mobile[0];
        $img_srcset_single = $img_srcset_loop =  explode(',', $img_srcset);
        // заменяем нужный размер на новую картинку
        $img_srcset_single[2] = $img_srcset_single_mobile;
        $img_srcset_loop[0] = $img_srcset_loop_mobile;
        $img_srcset_single = implode(',', $img_srcset_single);
        $img_srcset_loop = implode(',', $img_srcset_loop);
        // для страницы архива или индекса
        $img_src_loop = wp_get_attachment_image_url($image_id, 'medium-large');

        if (is_singular()) :
        ?>
            <div class="post-thumbnail">
                <img src="<?php echo esc_url($img_src_single); ?>" srcset="<?php echo esc_attr($img_srcset_single); ?>" sizes="(max-width: 480px) 300px, (max-width: 768px) 768px, 100%" alt="<?php echo $alt ?>">
            </div>

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <img src="<?php echo esc_url($img_src_loop); ?>" srcset="<?php echo esc_attr($img_srcset_loop); ?>" sizes="(max-width: 768px) 300px, 768px" alt="<?php echo $alt ?>">
            </a>

<?php endif;
    }
endif;
