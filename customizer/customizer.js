/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Тема Двадцать семнадцать включает в себя несколько полезных примеров 
 * использования настраиваемого API JS для улучшения пользовательского интерфейса
 * 
 * функции для частичного обновления кастомайзера с ->transport  = 'postMessage' и $wp_customize->selective_refresh->add_partial
 * https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/
 * https://developer.wordpress.org/themes/customize-api/javascriptunderscore-js-rendered-custom-controls/
 * https://developer.wordpress.org/themes/customize-api/advanced-usage/
 * полезно посмотреть JavaScript API в wp-admin\js\customize-controls.js
 * 
 * Как и в PHP, каждый тип объекта настройщика имеет соответствующий объект в JavaScript. 
 * Есть  wp.customize.Control, wp.customize.Panel, и wp.customize.Section модели, 
 * а также  wp.customize.panel, wp.customize.section, and wp.customize.control коллекции (да, они единственные), 
 * в которых хранятся все экземпляры элементов управления. 
 * Вы можете перебирать панели, разделы и элементы управления с помощью: 
 * wp.customize.panel.each( function ( panel ) {} );
 * wp.customize.section.each( function ( section ) {} );
 * wp.customize.control.each( function ( control ) {} );
 * 
 * При регистрации нового элемента управления в PHP передаете идентификатор родительского раздела: 
 * $wp_customize->add_control( 'blogname', array(  
 *  'label' => __( 'Site Title' ),  
 *  'section' => 'title_tagline',) 
 *	);
 * В API JavaScript раздел элемента управления можно получить
 * 	id = wp.customize.control( 'blogname' ).section();
 * Чтобы получить объект раздела из идентификатора, 
 * найдите раздел по идентификатору как обычно: wp.customize.section( id )
 * получить дочерние элементы панелей и секций: 
 * sections = wp.customize.panel( 'widgets' ).sections();controls = wp.customize.section( 'title_tagline' ).controls();
 * 
 * Control, Panel, и Section экземпляры имеют состояние active, а wp.customize.Value instance, когда состояние  active меняется,
 * контроллеры вызывают метод onChangeActive который по умолчанию перемещает элемент контейнера вверх и вниз, если false и true соответственно.
 * Есть также activate() и deactivate() методы для манипулирования этим active состоянием для панелей, секций и элементов управления. 
 * Основная цель этих состояний-показать или скрыть объект, не удаляя его полностью из настройщика. 
 * wp.customize.section( 'nav' ).deactivate(); // slide up
 *wp.customize.section( 'nav' ).activate({ duration: 1000 }); // slide down slowly
 *wp.customize.section( 'colors' ).deactivate({ duration: 0 }); // hide immediately
 *wp.customize.section( 'nav' ).deactivate({ completeCallback:
 *function () {  
 *    wp.customize.section( 'colors' ).activate(); // show after nav hides completely
 *    } 
 *})
 * ручное изменение active состояние будет сохраняться, пока предварительный просмотр не обновится или не загрузит другой URL-адрес. 
 * То activate()/ deactivate() методы сохраняют expanded состояние, 
 * 
 * expand()/ collapse() методы для панелей, секций и элементов управления поддерживают focus() метод, который не только расширяет все необходимые элементы, но и прокручивает целевой контейнер в поле зрения и фокусирует браузер на первом фокусируемом элементе в контейнере. 
 * Например, чтобы развернуть раздел “Статическая главная страница” и сосредоточиться на раскрывающемся списке “Выбрать главную страницу”.: 
 * wp.customize.control( 'page_on_front' ).focus();
 * 
 * При регистрации панели, раздела или элемента управления в PHP вы можете указать priority параметр. 
 * Это значение хранится в wp.customize.Value экземпляр для каждого соответствующего Panel, Section, и Control пример. 
 * Например, вы можете получить приоритет для панели виджетов с помощью: 
 * priority = wp.customize.panel( 'widgets' ).priority(); // returns 110 by default
 * Затем вы можете динамически изменить приоритет, и пользовательский интерфейс настройщика автоматически перестроится, чтобы отразить новые приоритеты: 
 * wp.customize.panel( 'widgets' ).priority( 1 ); // move Widgets to the top
 * 
 * 
 * справка jquery по функции bind https://api.jquery.com/bind/#bind-eventType-eventData-handler
 */

(function ($) {
	// Site title and description.
	wp.customize(
		'blogname',  //id partial (setting) из php
		function (value) { //value - функция реакта, которая отрисовывает
			console.log('value ' + value);
			value.bind(function (to) { //привязываем к ней функцию и передаем в нее значение настройки из базы
				console.log('to ' + to);

				// $('.site-title a').text(to); //выводим в нужном селекторе
				$('.customize-test').text(to); //выводим в нужном селекторе

			});
		});
	wp.customize('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});

	// Header text color.
	wp.customize(
		'header_textcolor', //id partial (setting) из php
		function (value) {//value - функция реакта, которая отрисовывает
			value.bind(function (to) { //привязываем к ней функцию и передаем в нее значение настройки из базы
				// проверяем, если настройка имеет конкретное значение то меняем css определенной части сайта
				if ('blank' === to) {
					$('.site-title, .site-description').css({
						clip: 'rect(1px, 1px, 1px, 1px)',
						position: 'absolute',
					});
				} else {
					$('.site-title, .site-description').css({
						clip: 'auto',
						position: 'relative',
					});
					$('.site-title a, .site-description').css({
						color: to,
					});
				}
			});
		});
	// #текстовый инпут
	wp.customize('text_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #скрытый инпут
	wp.customize('hidden_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #number инпут 
	wp.customize('number_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #инпут ползунок
	wp.customize('range_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #инпут url
	wp.customize('url_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #инпут tel
	wp.customize('tel_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});

	});
	// #инпут email
	wp.customize('email_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #инпут search
	wp.customize('search_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #инпут time 
	wp.customize('time_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #инпут date
	wp.customize('date_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #инпут datetime
	wp.customize('datetime_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #инпут week
	wp.customize('week_input', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #checkbox
	wp.customize('checkbox', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #radio
	wp.customize('radio', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #select
	wp.customize('select', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #textarea 
	wp.customize('textarea', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #dropdown-pages 
	wp.customize('dropdown-pages', function (value) {
		value.bind(function (to) {
			$('.customize-test').html(to);
		});
	});
	// #колорпикер
	wp.customize('my_color_control', function (value) {
		value.bind(function (to) {
			$('.customize-test').css({
				color: to,
			});
		});
	});
	// #картинка
	wp.customize('my_upload_control', function (value) {
		value.bind(function (to) {
			$('.customize-test').html('<img src="' + to + '">');
		});
	});
	// #редактор кода echo get_theme_mod('my_code_editor');
	wp.customize('my_code_editor', function (value) {
		value.bind(function (to) {
			$('.customize-test').html(to);
		});
	});
	// #дата и время
	wp.customize('my_date_time', function (value) {
		value.bind(function (to) {
			$('.customize-test').text(to);
		});
	});
	// #media echo get_theme_mod('my_media_control');
	// wp.customize('my_media_control', function (value) {
	// 	value.bind(function (to) {
	// 		console.log(to);

	// 		$('.customize-test').html(to);
	// 	});
	// });
}(jQuery));
