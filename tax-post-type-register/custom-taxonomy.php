<?php
// хук для регистрации
add_action('init', 'prefix_register_taxonomy');
function prefix_register_taxonomy()
{

    register_taxonomy('genre', ['post', 'book'], [
        'label'                 => '', //Название таксономии во множественном числе (для отображения в админке).
        'labels'                => [ //Массив описывающий заголовки таксономии (для отображения в админке).
            'name'              => 'Genres', //Имя таксономии, обычно во множественном числе.
            'singular_name'     => 'Genre', //Название для одного элемента этой таксономии.
            'menu_name'         => 'Genre', //Текст для названия меню. Эта строка обозначает название для пунктов меню. По умолчанию значение параметра name;
            'search_items'      => 'Search Genres', //Текст для поиска элемента таксономии.
            'popular_items'     => 'Genres', //Текст для блока популярных элементов.
            'all_items'         => 'All Genres', //Текст для всех элементов
            'view_item '        => 'View Genre', //Текст для просмотра термина таксономии.
            'parent_item'       => 'Parent Genre', //Текст для родительского элемента таксономии. Этот аргумент не используется для не древовидных таксономий.
            'parent_item_colon' => 'Parent Genre:', //Текст для родительского элемента таксономии, тоже что и parent_item но с двоеточием в конце.
            'edit_item'         => 'Edit Genre', //Текст для редактирования элемента.
            'update_item'       => 'Update Genre', //Текст для обновления элемента.
            'add_new_item'      => 'Add New Genre', //Текст для добавления нового элемента таксономии.
            'new_item_name'     => 'New Genre Name', //Текст для создания нового элемента таксономии.
            'back_to_items'     => '← Back to Genre', //Текст "← Перейти к рубрикам".
            'separate_items_with_commas' => __('Separate genres with commas'), //Текст в админке говорящий что термины (метки) нужно разделять запятыми. Не используется для древовидных таксономий.
            'add_or_remove_items'     => __('Add or remove genres'), //Текст для "удаления или добавления элемента", который используется в блоке админке, при отключенном javascript. Не действует для древовидных таксономий.
            'choose_from_most_used'     => __('Choose from the most used genres'), //Текст для блога при редактировании поста "выберите из часто используемых". Не используется для древовидных таксономий.
            'not_found'     => 'Genres not found', //Текст "не найдено", который отображается, если при клике на часто используемые ни один термин не был найден.
        ],
        'description'           => '', // описание таксономии
        'public'                => true,
        // 'publicly_queryable'    => null, // равен аргументу public
        // 'show_in_nav_menus'     => true, // равен аргументу public
        // 'show_ui'               => true, // равен аргументу public
        // 'show_in_menu'          => true, // равен аргументу show_ui
        // 'show_tagcloud'         => true, // равен аргументу show_ui
        // 'show_in_quick_edit'    => null, // равен аргументу show_ui
        'hierarchical'          => false,

        // 'rewrite'               => true,
        'rewrite'            => array('slug' => 'genre'),
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities'          => array(),
        'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
        'show_in_rest'          => null, // добавить в REST API
        'rest_base'             => null, // Ярлык в REST API. По умолчанию, название таксономии.
        // '_builtin'              => false,
        //'update_count_callback' => '_update_post_term_count',
    ]);
}
