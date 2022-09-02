<?php

/**
 * добавить колонку на стр списка постов в админке
 * вывести в ней что-то и поставить колонку в нужное место
 */
/**
 * добавляем колонку
 */
function tati_add_posts_thumb_column($columns)
{
    $post_new_columns = array(
        'post_thumb' => 'Изображение записи',
    );
    return array_merge($columns, $post_new_columns);
}
add_filter('manage_posts_columns', 'tati_add_posts_thumb_column', 5);

/**
 * выводим в ней миниатюры поста
 */

function tati_posts_custom_column($column_name, $id)
{
    // выводим картинку
    if ('post_thumb' === $column_name) {
        the_post_thumbnail('thumbnail');
    }
}
add_action('manage_posts_custom_column', 'tati_posts_custom_column', 5, 2);

/**
 * меняем порядок столбцов чтобы вывести картинку после заголовка
 */
function tati_columns_order($columns)
{
    $n_columns = [];
    $move = 'post_thumb';
    $before = 'author';

    foreach ($columns as $key => $value) {
        if ($key == $before) {
            $n_columns[$move] = $move;
        }
        $n_columns[$key] = $value;
    }
    return $n_columns;
}
add_filter('manage_posts_columns', 'tati_columns_order');
