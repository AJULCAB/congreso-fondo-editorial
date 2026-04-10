<?php


/**
 *
 * Inicializa la configuración de la página
 * https://www.lab21.gr/blog/optimize-your-wordpress-site/
 *
 */

// function _remove_script_version( $src ){
//     $parts = explode( '?ver', $src );
//     return $parts[0];
// }
// add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
// add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );





//Remove JQuery migrate

function remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            // Check whether the script has any dependencies

            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate');


/**
 * Disable the emoji's
 */
function disable_theme_emojis()
{
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10);
    remove_action('wp_head', 'parent_post_rel_link', 10);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10);

    // REMOVE WP EMOJI
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');

    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}

add_action('init', 'disable_theme_emojis');



/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param    array  $plugins
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}




add_action('init', 'my_deregister_heartbeat', 1);
function my_deregister_heartbeat()
{
    global $pagenow;

    if ('post.php' != $pagenow && 'post-new.php' != $pagenow)
        wp_deregister_script('heartbeat');
}




//Move your JS files in the footer:
// remove_action('wp_head', 'wp_print_scripts');
// remove_action('wp_head', 'wp_print_head_scripts', 9);
// remove_action('wp_head', 'wp_enqueue_scripts', 1);
// add_action('wp_footer', 'wp_print_scripts', 5);
// add_action('wp_footer', 'wp_enqueue_scripts', 5);
// add_action('wp_footer', 'wp_print_head_scripts', 5);



//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css()
{
    if (!is_user_logged_in()){
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
        if (!is_admin()) {
            wp_deregister_style('dashicons');
        }
    }
}

add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);


add_filter( 'run_wptexturize', '__return_false' );