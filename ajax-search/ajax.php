<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

add_action('wp_ajax_search_action', 'prefix_search_ajax_action_callback');
add_action('wp_ajax_nopriv_search_action', 'prefix_search_ajax_action_callback');
function prefix_search_ajax_action_callback()
{

	if (!wp_verify_nonce($_POST['nonce'], 'search-nonce')) {
		wp_die('Данные отправлены с неверного адреса');
	}

	$arg = array(
		'post_type' => array('product'),
		'post_status' => 'publish',
		's' => $_POST['s']
	);
	$query_ajax = new WP_Query($arg);
	$json_data['out'] = ob_start();
	if ($query_ajax->have_posts()) {
		while ($query_ajax->have_posts()) {
			$query_ajax->the_post();
?>
			<li>
				<a class="search__single-res" href="<?php echo get_permalink(); ?>"> <?php echo get_the_title(); ?>
				</a>
			</li>
		<?php
		}
	} else { ?>
		<li>
			Ничего не найдено...
		</li>
<?php
	}

	$json_data['out'] .= ob_get_clean();
	wp_send_json($json_data);
	wp_die();
}
