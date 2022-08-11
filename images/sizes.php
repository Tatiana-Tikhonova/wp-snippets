<?php

/**
 * размеры картинок по умолчанию
 * вордпресс:
 * full - полный размер
 * large - 1024x1024 - настраивается в админке
 * medium-large - 768x768
 * medium - 300x300 - настраивается в админке
 * thumbnail - 150x150 - настраивается в админке
 * 
 * вукоммерц:
 * woocommerce_single - 600х600
 * woocommerce_thumbnail - 300х300
 * woocommerce_gallery_thumbnail - 100х100
 */

/**
 * добавить кастомные размеры картинок
 * последний параметр: true - это обрезка, если ставить false, то просто уменьшит под нужный размер с сохранением пропорций
 * 
 */
add_action('after_setup_theme', 'tati_add_image_size');
function tati_add_image_size()
{
    if (function_exists('add_image_size')) {
        add_image_size('testimonial-img', 220, 230, true);
        add_image_size('services-img', 1170, 635, true);
        add_image_size('features-img', 438, 455, true);
        add_image_size('news-img', 733, 9999, false); //масштабирование по ширине без обрезки (высота авто с сохранением пропорций)
    }
}
