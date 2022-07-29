<?php
// подключить ajax для формы
wp_enqueue_script('prefix-ajax-search', get_template_directory_uri() . '/assets/js/ajax-search.js', array('jquery'), _S_VERSION, true);
wp_localize_script('prefix-ajax-search', 'search__form', array(
	'url' => admin_url('admin-ajax.php'),
	'nonce' => wp_create_nonce('search-nonce')
));
