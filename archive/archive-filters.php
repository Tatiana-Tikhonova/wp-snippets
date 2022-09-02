<?php
// удалить префикс архивов
add_filter('get_the_archive_title_prefix', 'filter_function_name_3952');
function filter_function_name_3952($prefix)
{
    $prefix = '';

    return $prefix;
}
// изменить значок в конце отрывка
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more)
{
    global $post;
    return '...';
}
