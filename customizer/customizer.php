<?php

/**
 * Theme Customizer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * Добавлена ​​поддержка postMessage для заголовка и описания сайта для настройщика тем.
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * 
 * поолезно посмотреть wp-includes\class-wp-customize-manager.php
 */

/**
 * API настройки является объектно-ориентированным. 
 * Существует четыре основных типа объектов настройщика: Панели, Разделы, Настройки и элементы управления. 
 * Настройки связывают элементы пользовательского интерфейса (элементы управления) с настройками, сохраненными в базе данных. 
 * Разделы являются контейнерами пользовательского интерфейса для элементов управления, чтобы улучшить их организацию. 
 * Панели представляют собой контейнеры для секций, позволяющие группировать несколько секций вместе.
 * Каждый объект настройщика представлен классом PHP, и все объекты управляются объектом Customize Manager, WP_Customize_Manager . 
 * справка вп кама https://wp-kama.ru/handbook/theme/customize-api
 * офиц доки https://developer.wordpress.org/themes/customize-api/
 * фреймворк с дополнительными возможностями 2018 год https://codyshop.ru/cody-framework/
 * Чтобы добавить, удалить или изменить любой объект Customizer, 
 * а также получить доступ к Customizer Manager, используйте customize_register крюк: 
 * 
 */
function tati_customize_register($wp_customize)
{
	/**
	 * настройки кастомайзера в болванке тем underscore
	 */
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	/**
	 * кастомные настройки тем
	 */
	/**
	 * добавляем панель (необязательно)
	 * Панели объединяют секции. Секция может существовать вне панели, 
	 * то есть создание панели делается по желанию и выгодно, когда секций много и их нужно собраться в панель.
	 *  //active_callback параметр для панелей, разделов и элементов управления принимает имя функции
	 * */
	$wp_customize->add_panel(
		'tati_settings', // id панели
		array(
			'title' => 'Настройки темы', //отображаемое название
			'description' => 'Описание панели', // Include html tags such as <p>.(необязательно)
			'priority' => 160, // Позиция вывода в панели кастомайзера https://developer.wordpress.org/themes/customize-api/customizer-objects/#sections
			// 'active_callback' => function () {
			// 	return is_page(); //проверка находимся ли мы на статической странице
			// }
		)
	);
	/**
	 * добавляем секцию (необязательно)
	 * Секции объединяют элементы управления (текстовое поле, радиокнопки, выпадающие списки и так далее).
	 */
	$wp_customize->add_section(
		'theme_header', //id секции
		array(
			'title' => 'Базовые поля',
			'panel' => 'tati_settings', // id панели, в которой должна находиться секция (если создаем свою отдельную панель)
			'priority' => 160, // Позиция вывода в панели кастомайзера (необязательно)
			'capability' => 'edit_theme_options', // Права доступ к изменению настроек кастомайзера.
			'theme_supports' => '', // Требуется очень редко.
			// 'active_callback' => function () {
			// 	return is_page(); //проверка находимся ли мы на статической странице
			// }
		)
	);

	/** 
	 * 
	 * РАБОЧИЕ ПРИМЕРЫ НАСТРОЕК И КОНТРОЛЛЕРОВ
	 * добавляем настройку (обязательно)
	 * Настройки кастомайзера связывают элементы пользовательского интерфейса (controls) с настройками, хранящимися в базе данных.
	 * 	'type' => 'theme_mod',  Или 'option'(не рекомендуется). 'option' сохраняются в таблице бд wp_options и применяются независимо от темы. Получать такие опции принято функцией get_option().
	 *  По умолчанию: 'theme_mod'. Рекомендовано применять 'theme_mod'. Используются для темы и хранятся для каждой темы отдельно. Данные хранятся в виде сериализованного массива в таблице wp_options, в опции с названием theme_mods_THEME_NAME. 
	 * Получать такие опции принято функцией get_theme_mod() или get_theme_mods().
	 * 'transport' => как обновлять превью сайта: 
	 * 'refresh' - перезагрузкой фрейма (можно полностью отказаться от JavaScript). 
	 * 'postMessage' - отправкой AJAX запроса JavaScript с использованием $wp_customize->selective_refresh->add_partial
	 *  предпочтительно 'postMessage' с использованием $wp_customize->selective_refresh->add_partial
	 * 'sanitize_callback' => '' используется для проверки введенных  данных перед тем, как сохранить их в БД По умолчанию: '' Очистка данных на стороне PHP. Callback to filter a Customize setting value in un-slashed form. Функция получит параметры $value, $this, смотрите хук customize_sanitize_(id)
	 * Найти подходящий готовый коллбэк можнов поиске на https://developer.wordpress.org/ ((ввести sanitize_  и выбрать из списка))
	 * 'sanitize_js_callback' => '',вызывается для проверки и корректировки данных, уже сохраненных в БД в момент их передачи в настройщик тем По умолчанию: '' Callback to convert a Customize PHP setting value to a value that is JSON serializable. Функция получит параметры $value, $this, смотрите хук customize_sanitize_js_(id)
	 * валидация https://developer.wordpress.org/plugins/security/data-validation/
	 * 
	 * */

	$wp_customize->add_setting(
		'date_setting', //id настройки
		array(
			'type'                 => 'theme_mod',          // Или 'option'(не рекомендуется. 'option' сохраняются в таблице бд wp_options и применяются независимо от темы. Рекомендовано применять 'theme_mod') По умолчанию: 'theme_mod'
			'capability'           => 'edit_theme_options', // По умолчанию: 'edit_theme_options' Права доступ к изменению настроек кастомайзера.
			'theme_supports'       => '',                   // По умолчанию: none Требуется редко. Особенности темы, необходимые для поддержки панели.
			'default'              => '',                   // Значение по умолчанию.
			'transport'            => 'refresh',            // Или 'postMessage'. По умолчанию: 'refresh'
			'sanitize_callback'    => '',                   // По умолчанию: '' Очистка данных на стороне PHP. Найти подходящий готовый коллбэк можнов поиске на https://developer.wordpress.org/ ((ввести sanitize_  и выбрать из списка))
			'sanitize_js_callback' => '',
			// 'active_callback' => function () {
			// 	return is_page(); //проверка находимся ли мы на статической странице
			// },                // По умолчанию: '' Очистка данных на стороне JavaScript. В основном 'to_json'.
			'validate_callback' => '', // валидация переданного значения настройки на стороне сервера. Функция получит параметры $validity, $value, $this, смотрите хук customize_validate_(id)
		)
	);
	/**
	 * добавляем элемент управления (обязательно)
	 * Элементы управления не могут существовать вне секции. 
	 * 'type' => тип элемента управления. из ядра - это <input>, checkbox, textarea, radio, select, dropdown-pages
	 * если нужен элемент input, надо просто в параметре 'type' => передать нужный тип инпута (text, hidden, number, range, url, tel, email, search, time, date, datetime, week)
	 * по дефолту 'type' => 'text'
	 * для 'type' => select или radio нужно добавить параметр 'choices'  => [ // список значений и лейблов выпадающего списка в виде ассоциативного массива]
	 *  для dropdown-pages нужно добавить параметр 'allow_addition'=> (true/false) выпадающий список всех существующих страниц
	 * если 'allow_addition'=> true - есть возможность добавить новую страницу. по умолчанию false
	 * input_attrs - class, style, placeholder, min, max
	 * не применяются для  ‘checkbox’, ‘radio’, ‘select’, ‘textarea’, dropdown-pages
	 * 
	 * 
	 * */
	$wp_customize->add_control(
		'date_setting', //id настройки к которой привязан элемент управления или новый объект Customize Control
		array(
			'type' => 'date',
			'priority' => 10, // внутри секции
			'section' => 'theme_header', // id секции. обязательно, существующей по умолчанию или созданной.
			'label' => __('Date'), //название
			'description' => __('This is a date control with a red border.'), // описание
			'input_attrs' => array( // если это input, добавляем атрибуты
				'class' => 'my-custom-class-for-js',
				'style' => 'border: 1px solid #900',
				'placeholder' => __('mm/dd/yyyy'),
			),
			'active_callback' => '',
		)
	);

	// #текстовый инпут 	echo get_theme_mod('text_input');
	$wp_customize->add_setting(
		'text_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'text_input',
		array(
			'type' => 'text',
			'section' => 'theme_header',
			'label' => 'Текстовый инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'text-input',
				'style' => 'border: 1px solid #000',
				'placeholder' => 'Введите текст',
			),
		)
	);
	// #скрытый инпут echo get_theme_mod('hidden_input');
	$wp_customize->add_setting(
		'hidden_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hidden_input',
		array(
			'type' => 'hidden',
			'section' => 'theme_header',
			'label' => 'скрытый инпут',
			'description' => 'Описание',

		)
	);
	// #number инпут echo get_theme_mod('number_input');
	$wp_customize->add_setting(
		'number_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'number_input',
		array(
			'type' => 'number',
			'section' => 'theme_header',
			'label' => 'number инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'number-input',
				'style' => 'border: 1px solid #000',
				'min'		=> '1',
				'max'		=> '100',
			),
		)
	);
	// #инпут ползунок echo get_theme_mod('range_input');
	$wp_customize->add_setting(
		'range_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'range_input',
		array(
			'type' => 'range',
			'section' => 'theme_header',
			'label' => 'ползунок инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'text-input',
				'style' => 'border: 1px solid #000',
				'min'		=> '1',
				'max'		=> '100',
			),
		)
	);
	// #инпут url echo get_theme_mod('url_input');
	$wp_customize->add_setting(
		'url_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'esc_url',
		)
	);
	$wp_customize->add_control(
		'url_input',
		array(
			'type' => 'url',
			'section' => 'theme_header',
			'label' => 'url инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'url-input',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #инпут tel echo get_theme_mod('tel_input');
	$wp_customize->add_setting(
		'tel_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',
			// 'sanitize_js_callback' => 'to_json', // Basically to_json
		)
	);
	$wp_customize->add_control(
		'tel_input',
		array(
			'type' => 'tel',
			'section' => 'theme_header',
			'label' => 'tel инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'tel-input',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #инпут email echo get_theme_mod('email_input');
	$wp_customize->add_setting(
		'email_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'email_input',
		array(
			'type' => 'email',
			'section' => 'theme_header',
			'label' => 'email инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'email-input',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #инпут search echo get_theme_mod('search_input');
	$wp_customize->add_setting(
		'search_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'search_input',
		array(
			'type' => 'search',
			'section' => 'theme_header',
			'label' => 'search инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'search-input',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #инпут time echo get_theme_mod('time_input');
	$wp_customize->add_setting(
		'time_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'time_input',
		array(
			'type' => 'time',
			'section' => 'theme_header',
			'label' => 'time инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'time-input',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #инпут date echo get_theme_mod('date_input');
	$wp_customize->add_setting(
		'date_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'date_input',
		array(
			'type' => 'date',
			'section' => 'theme_header',
			'label' => 'date инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'date-input',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #инпут datetime  echo get_theme_mod('datetime_input');
	$wp_customize->add_setting(
		'datetime_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'datetime_input',
		array(
			'type' => 'datetime',
			'section' => 'theme_header',
			'label' => 'datetime инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'datetime-input',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #инпут week echo get_theme_mod('week_input');
	$wp_customize->add_setting(
		'week_input',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_text_field',

		)
	);
	$wp_customize->add_control(
		'datetime_input',
		array(
			'type' => 'week',
			'section' => 'theme_header',
			'label' => 'week инпут',
			'description' => 'Описание',
			'input_attrs' => array(
				'class' => 'week-input',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #checkbox echo get_theme_mod('checkbox');
	$wp_customize->add_setting(
		'checkbox',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'checkbox',
		array(
			'type' => 'checkbox',
			'section' => 'theme_header',
			'label' => 'checkbox',
			'description' => 'Описание',
			'default'     => '1', // здесь '1' - по умолчанию галочка стоит. если надо по умолчанию пустой, передаем 'default' => '',
			'input_attrs' => array(
				'class' => 'checkbox',
				'style' => 'border: 1px solid #000',
			),
		)
	);
	// #radio echo get_theme_mod('radio');
	$wp_customize->add_setting(
		'radio',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'radio',
		array(
			'type' => 'radio',
			'section' => 'theme_header',
			'label' => 'radio',
			'description' => 'Описание',
			'default'     => 'B',
			'choices' => array(
				'a'     => 'A',
				'b'     => 'B',
				'c'     => 'C',
			),

		)
	);
	// #select  echo get_theme_mod('select');
	$wp_customize->add_setting(
		'select',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'select',
		array(
			'type' => 'select',
			'section' => 'theme_header',
			'label' => 'select',
			'description' => 'Описание',
			'default'     => 'B',
			'choices' => array(
				'a'     => 'A',
				'b'     => 'B',
				'c'     => 'C',
			),

		)
	);
	// #textarea   echo get_theme_mod('textarea');
	$wp_customize->add_setting(
		'textarea',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'textarea',
		array(
			'type' => 'textarea',
			'section' => 'theme_header',
			'label' => 'textarea',
			'description' => 'Описание',
			'default'     => '',
			'input_attrs' => array(
				'class' => 'textarea',
				'style' => 'border: 1px solid #000',
				'placeholder' => 'Введите тексты',
			),


		)
	);
	// #dropdown-pages  echo get_theme_mod('dropdown-pages');
	$wp_customize->add_setting(
		'dropdown-pages',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'dropdown-pages',
		array(
			'type' => 'dropdown-pages',
			'section' => 'theme_header',
			'label' => 'dropdown-pages',
			'description' => 'Описание',
			'allow_addition' => true

		)
	);

	/** 
	 * Core Custom Controls - Дополнительные элементы управления (контроллеры)
	 * являются подклассами базового объекта WP_Customize_Control
	 * вместо id - новый экземпляр класса, в который передаются $wp_customize, id контроллера и массив настроек
	 * https://developer.wordpress.org/reference/classes/wp_customize_control/
	 * 
	 */

	$wp_customize->add_section(
		'tati_custom_ctrl', //id секции
		array(
			'title' => 'Дополнительные поля',
			'panel' => 'tati_settings', // id панели, в которой должна находиться секция (если создаем свою отдельную панель)
			'priority' => 180, // Позиция вывода в панели кастомайзера (необязательно)
			'capability' => 'edit_theme_options', // Права доступ к изменению настроек кастомайзера.
			'theme_supports' => '', // Требуется очень редко.
			// 'active_callback' => function () {
			// 	return is_page(); //проверка находимся ли мы на статической странице
			// }
		)
	);
	// #колорпикер  echo get_theme_mod('my_color_control');
	$wp_customize->add_setting(
		'my_color_control',
		array(
			'type'	=> 'theme_mod',
			'default' => '#ffffff',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control( //новый экземпляр
			$wp_customize, //передаем $wp_customize
			'my_color_control', // id экземпляра
			array( //параметры
				'label' => 'цвет',
				'description' => 'Описание',
				'settings' => 'my_color_control',
				'section' => 'tati_custom_ctrl',
			)
		)
	);
	// #картинка  echo get_theme_mod('my_image_control');
	$wp_customize->add_setting(
		'my_image_control',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control($wp_customize, 'my_image_control', [
			'label'    => 'Картинка',
			'description' => '',
			'settings' => 'my_image_control',
			'section'  => 'tati_custom_ctrl'
		])
	);
	// #файл  echo get_theme_mod('my_upload_control');
	$wp_customize->add_setting(
		'my_upload_control',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
		)
	);
	// возвращает url
	$wp_customize->add_control(
		new WP_Customize_Upload_Control($wp_customize, 'my_upload_control', [
			'label'    => 'my_upload_control',
			'description' => 'Описание',
			'settings' => 'my_upload_control',
			'section'  => 'tati_custom_ctrl'
		])
	);

	// #редактор кода echo get_theme_mod('my_code_editor');
	$wp_customize->add_setting(
		'my_code_editor',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',
			'sanitize_callback'    => 'wp_kses',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Code_Editor_Control($wp_customize, 'my_code_editor_control', [
			'label'    => 'code_editor',
			'description' => 'Описание',
			'settings' => 'my_code_editor',
			'section'  => 'tati_custom_ctrl',
			'editor_settings' => array(
				'type'       => 'text/javascript',
				'codemirror' => array(
					'indentUnit' => 2,
					'tabSize'    => 2,
				),
			),
		])
	);
	// #дата и время  echo get_theme_mod('my_date_time');
	$wp_customize->add_setting(
		'my_date_time',
		array(
			'type'	=> 'theme_mod',
			'transport'  => 'postMessage',

		)
	);

	$wp_customize->add_control(
		new WP_Customize_Date_Time_Control($wp_customize, 'my_date_time', [
			'label'    => 'my_date_time',
			'description' => 'Описание',
			'settings' => 'my_date_time',
			'section'  => 'tati_custom_ctrl',
			'include_time' => false, //показывать ли время или только дату
			'allow_past_date' => false, //можно ли выбрать время и дату в прошлом
			'twelve_hour_format' => false, // включить ли 12-ти часовой формат
			'max_year'  => '2030',
			'min_year' => '2010',
		])
	);
	// #media echo get_theme_mod('my_media_control');
	$wp_customize->add_setting(
		'my_media_control',
		array(
			'type'	=> 'theme_mod',
			// 'transport'  => 'postMessage',
			'sanitize_callback'    => 'sanitize_mime_type',
		)
	);
	// возвращает id
	$wp_customize->add_control(
		new WP_Customize_Media_Control($wp_customize, 'my_media_control', array(
			'label' => 'my_media_control',
			'settings' => 'my_media_control',
			'section' => 'tati_custom_ctrl',
			'mime_type' => 'audio', // image, audio, video
		))
	);

	// 
	/**
	 * Добавление нового кастомного типа контроллера
	 * add_action( 'customize_register', 'tati_customize_register' );
	 *function tati_customize_register( $wp_customize ) {
	 * создать кастомный класс контроллера class, WP_Customize_Custom_Control.
	 * Зарегистрировать этот класс чтобы JS мог с ним работать
	 *  $wp_customize->register_control_type( 'WP_Customize_Custom_Control' );
	 *}
	 * Все зарегистрированные типы элементов управления имеют свои шаблоны, 
	 * распечатанные в настройщике с помощью WP_Customize_Manager::print_control_templates(). 
	 * Все, к чему вы хотели бы получить доступ в render_content() в PHP необходимо будет экспортировать в JavaScript, 
	 * чтобы он был доступен в вашем шаблоне управления. WP_Customize_Control экспортирует следующие переменные класса управления по умолчанию:
	 *type
	 *label
	 *description
	 *active (логическое состояние)
	 * Вы можете добавить дополнительные параметры, относящиеся к вашему пользовательскому элементу управления, 
	 * переопределив WP_Customize_Control::to_json() в вашем подклассе пользовательского элемента управления
	 * потребуется вызвать родительский класс’ to_json() метод также, 
	 * чтобы гарантировать, что все основные переменные также экспортируются
	 * public function to_json() {
	 *  parent::to_json();
	 *  $this->json['statuses'] = $this->statuses;
	 *  $this->json['defaultValue'] = $this->setting->default;
	 *}
	 * перезаписать WP_Customize_Control::content_template() (по умолчанию пусто) в качестве замены WP_Customize_Control::render_content(). Содержимое рендеринга все еще вызывается, 
	 * поэтому обязательно переопределите его пустой функцией в своем подклассе. 
	 * справка: https://developer.wordpress.org/themes/customize-api/javascriptunderscore-js-rendered-custom-controls/
	 * 
	 * */

	/**
	 * выборочное обновление (selective_refresh)
	 * “предварительный просмотр” обновляет только области (add_partial), 
	 * в которых изменяются настройки
	 * 
	 * */
	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial(
			'blogname', // id partial
			array(
				'selector'        => '.customize-test', // селектор
				'render_callback' => 'tati_customize_partial_blogname', // функция вывода данных из базы
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'tati_customize_partial_blogdescription',
			)
		);
		// #текстовый инпут
		$wp_customize->selective_refresh->add_partial(
			'text_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('text_input');
				},
			)
		);
		// #скрытый инпут
		$wp_customize->selective_refresh->add_partial(
			'hidden_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('hidden_input');
				},
			)
		);
		// #number инпут 
		$wp_customize->selective_refresh->add_partial(
			'number_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('number_input');
				},
			)
		);
		// #инпут ползунок
		$wp_customize->selective_refresh->add_partial(
			'range_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('range_input');
				},
			)
		);
		// #инпут url
		$wp_customize->selective_refresh->add_partial(
			'url_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('url_input');
				},
			)
		);
		// #инпут tel
		$wp_customize->selective_refresh->add_partial(
			'tel_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('tel_input');
				},
			)
		);
		// #инпут email
		$wp_customize->selective_refresh->add_partial(
			'email_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('email_input');
				},
			)
		);
		// #инпут search
		$wp_customize->selective_refresh->add_partial(
			'search_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('search_input');
				},
			)
		);
		// #инпут time 
		$wp_customize->selective_refresh->add_partial(
			'time_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('time_input');
				},
			)
		);
		// #инпут date echo get_theme_mod('date_input');
		$wp_customize->selective_refresh->add_partial(
			'date_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('date_input');
				},
			)
		);
		// #инпут datetime  echo get_theme_mod('datetime_input');
		$wp_customize->selective_refresh->add_partial(
			'datetime_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('datetime_input');
				},
			)
		);
		// #инпут week
		$wp_customize->selective_refresh->add_partial(
			'week_input',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('week_input');
				},
			)
		);
		// #checkbox
		$wp_customize->selective_refresh->add_partial(
			'checkbox',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('checkbox');
				},
			)
		);
		// #radio
		$wp_customize->selective_refresh->add_partial(
			'radio',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('radio');
				},
			)
		);
		// #select
		$wp_customize->selective_refresh->add_partial(
			'select',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('select');
				},
			)
		);
		// #textarea 
		$wp_customize->selective_refresh->add_partial(
			'textarea',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('textarea');
				},
			)
		);
		// #dropdown-pages
		$wp_customize->selective_refresh->add_partial(
			'dropdown-pages',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('dropdown-pages');
				},
			)
		);
		// #колорпикер
		$wp_customize->selective_refresh->add_partial(
			'my_color_control',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo '<p>' . get_theme_mod('text_input') . ' </p>';
				},
			)
		);
		// #файл  echo get_theme_mod('my_upload_control');
		// это же для #картинка echo get_theme_mod('my_image_control');
		$wp_customize->selective_refresh->add_partial(
			'my_upload_control',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo 	'<img src="' . get_theme_mod('my_upload_control') . '">';
				},
			)
		);
		// #редактор кода
		$wp_customize->selective_refresh->add_partial(
			'my_code_editor',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					// https://wp-kama.ru/function/wp_add_inline_script
					wp_add_inline_script('tati-customizer', get_theme_mod('my_code_editor'));
					// https://wp-kama.ru/function/wp_add_inline_style
					// wp_add_inline_style( $handle, $data );
				},
			)
		);
		// #дата и время  echo get_theme_mod('my_date_time');
		$wp_customize->selective_refresh->add_partial(
			'my_date_time',
			array(
				'selector'        => '.customize-test',
				'render_callback' => function () {
					echo get_theme_mod('my_date_time');
				},
			)
		);
		// #media echo get_theme_mod('my_media_control');
		// $wp_customize->selective_refresh->add_partial(
		// 	'my_media_control',
		// 	array(
		// 		'selector'        => '.customize-test',
		// 		'render_callback' => function () {
		// 			echo get_theme_mod('my_media_control');
		// 			echo wp_get_attachment_url(get_theme_mod('my_media_control'));
		// 		},
		// 	)
		// );
	}
}
add_action('customize_register', 'tati_customize_register');



// коллбэки для частичного обновления с помощью джаваскрипт
/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function tati_customize_partial_blogname()
{
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function tati_customize_partial_blogdescription()
{
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 * подключение скриптов для частичного обновления
 */
function tati_customize_preview_js()
{
	wp_enqueue_script('tati-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), _S_VERSION, true);
}
add_action('customize_preview_init', 'tati_customize_preview_js');
