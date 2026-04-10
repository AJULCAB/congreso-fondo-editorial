<?php

/**
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

/*
 * Plugin Name: Clean UI
 * Description: Take control over the administration dashboard.
 * Author: WordPlate
 */

function clean_ui_menu_items(): void
{
    // remove_menu_page('edit-comments.php'); // Comments
    // remove_menu_page('edit.php?post_type=page'); // Pages
    // remove_menu_page('edit.php'); // Posts
    // remove_menu_page('index.php'); // Dashboard
    // remove_menu_page('upload.php'); // Media

    // remove_menu_page('edit.php?post_type=acf-field-group'); // ACF options

    remove_menu_page('admin.php?page=itc-svg-upload'); // ACF options



}

add_action('admin_init', 'clean_ui_menu_items');

function clean_ui_toolbar_items($menu): void
{
    $menu->remove_node('comments'); // Comments
    $menu->remove_node('customize'); // Customize
    // $menu->remove_node('dashboard'); // Dashboard
    // $menu->remove_node('edit'); // Edit
    // $menu->remove_node('menus'); // Menus
    // $menu->remove_node('new-content'); // New Content
    // $menu->remove_node('search'); // Search
    // // $menu->remove_node('site-name'); // Site Name
    $menu->remove_node('themes'); // Themes
    $menu->remove_node('updates'); // Updates
    // $menu->remove_node('view-site'); // Visit Site
    // $menu->remove_node('view'); // View
    // $menu->remove_node('widgets'); // Widgets
    // $menu->remove_node('wp-logo'); // WordPress Logo
}

add_action('admin_bar_menu', 'clean_ui_toolbar_items', 999);

function clean_ui_dashboard_widgets(): void
{
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']); // Activity
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // At a Glance
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']); // Site Health Status
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPress Events and News
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Quick Draft
}

add_action('wp_dashboard_setup', 'clean_ui_dashboard_widgets');

function clean_ui_logo(): void
{
    $url = get_theme_file_uri('assets/image/logo.png');
    $width = 200;

    $styles = [
        sprintf('background-image: url(%s);', $url),
        sprintf('width: %dpx;', $width),
        'background-position: center;',
        'background-size: contain;',
    ];

    echo sprintf(
        '<style> .login h1 a { %s } </style>',
        implode('', $styles)
    );
}

add_action('login_head', 'clean_ui_logo');



add_filter('get_post_metadata', function ($existing, $object_id, $meta_key, $single, $meta_type) {
	static $working = false;

	// post type we will work on
	$target_post_types = [ 'page' ];
	// and metakeys to strip/hide from WPSEO - matched partially
	// so 'header' would match head, header_image, title_header, heading etc
	$blacklist = ['head'];

	// condition as tight as possible, we don't want to go doing the debug_backtrace hack anywhere we don't need to
	if (!$working && is_admin() && $meta_type == 'post' && in_array(get_post_type($object_id),$target_post_types)) {

		// hacky way as can't see a better one to narrow scope
		// so we only run when this data is being fed back to WPSEO's var replace
		$trace = debug_backtrace();
		$trace = array_filter($trace, function ($e) {
			return @$e['function'] == 'get_custom_fields_replace_vars' && @$e['class'] == 'WPSEO_Metabox';
		});

		// if we are in the right place....
		if (!empty($trace)) {

			// set the flag - we call get_metadata_raw again (which is where we are hooked) and want to make sure we don't pick  that one up
			$working = true;

			// load the data again, having set the flag
			$data = get_metadata_raw('post', $object_id, $meta_key, $single);

			// filter out the metas by blacklist
			foreach ($data as $k=>$v) {
				$match = array_filter($blacklist, function ($black) use ($k) {
					return strpos($k, $black ) !== false;
				});
				if ($match) {
					unset($data[$k]);
				}
			}

			// unset flag and return
			$working = false;
			return $data;
		}

	}
	// otherwise, return the existing one
	return $existing;
}, 10, 5);


/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function expreso_custom_excerpt_length( $length ) {
    return 32;
}
add_filter( 'excerpt_length', 'expreso_custom_excerpt_length', 999 );

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function expreso_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'expreso_excerpt_more' );



remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );


// function restrict_rest_api_to_localhost() {
//     $whitelist = [ '127.0.0.1', "::1" ];

//     if( ! in_array($_SERVER['REMOTE_ADDR'], $whitelist ) ){
//         die( 'EXPRESO REST API is disabled.' );
//     }
// }
// add_action( 'rest_api_init', 'restrict_rest_api_to_localhost', 0 );
