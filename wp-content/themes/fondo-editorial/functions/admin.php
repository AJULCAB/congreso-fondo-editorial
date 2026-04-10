<?php 



if ( ! function_exists( 'expreso_admin_setup' ) ) :

    // Post Formats #
    // add_theme_support( 'post-formats',  array ( 'aside', 'gallery', 'quote', 'image', 'video' ) );

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function expreso_admin_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on effectus, use a find and replace
		 * to change 'effectus' to the name of your theme in all the template files.
		 */
		// load_theme_textdomain( 'vyv', get_template_directory() . '/languages' );
		

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// add_image_size('slider', 400, 400, true);
		// add_image_size('slider-200', 200, 200, true);
		// add_image_size('slider-500', 500, 500, true);
		// if (has_post_thumbnail()) {
		//     the_post_thumbnail('slider');
		//     the_post_thumbnail('slider-200');
		//     the_post_thumbnail('slider-500');
		// }

		// add_image_size( 'post-list', 450, 300,true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu_desktop' => __('Menú Desktop'),
				'menu_mobile' => __('Menú Mobile'),
				'menu_desktop_open' => __('Modal Menú Desktop'),
	            // 'footer'     => __('Footer menu'),
	            // 'menu_mobile'     => __('Menú mobile'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		
	}
endif;
add_action( 'after_setup_theme', 'expreso_admin_setup' );



add_action( 'init', 'cp_change_post_object' );
// Change dashboard Posts to News
function cp_change_post_object() {
    $get_post_type = get_post_type_object('post');
	
    $labels = $get_post_type->labels;
	$labels->name = 'Noticias';
	$labels->singular_name = 'Noticias';
	$labels->add_new = 'Agregar Noticia';
	$labels->add_new_item = 'Agregar Noticia';
	$labels->edit_item = 'Editar Noticias';
	$labels->new_item = 'Noticias';
	$labels->view_item = 'Ver Noticia';
	$labels->search_items = 'Buscar Noticias';
	$labels->not_found = 'No hay noticias';
	$labels->not_found_in_trash = 'No hay noticias en la papelera';
	$labels->all_items = 'Todas las Noticias';
	$labels->menu_name = 'Noticias';
	$labels->name_admin_bar = 'Noticias';
}


function expreso_mu_hide_plugins_network( $plugins ) {
    // let's hide plugins
	$array_disable_plugins=[
		// 'acf-code-field-master/acf-code-field.php',
		// 'acf-cpt-options-pages/cpt-acf.php',
		// 'ACF-Extended-master/acf-extended.php',
		// 'acf-field-name-copier/plugin.php',
		// 'acf-icon-picker-master/acf-icon-picker.php',
		// 'advanced-custom-fields-pro-master/acf.php',
		// // 'sss',
		// 'wps-hide-login/wps-hide-login.php',
		// 'luckywp-term-description-rich-text/luckywp-term-description-rich-text.php'
	];
	foreach (array_keys( $plugins ) as $key => $pugin) {
		# code...
		if (in_array($pugin,$array_disable_plugins )) {
			# code...
			unset( $plugins[$pugin] );
		}
	}
    // if( in_array( 'akismet/akismet.php', array_keys( $plugins ) ) ) {
    //     unset( $plugins['akismet/akismet.php'] );
    // }
    return $plugins;
}

// add_filter( 'all_plugins', 'expreso_mu_hide_plugins_network' );



// add_admin_column(__('Thumbnail'), 'encuesta', function($post_id){
// 	$image_id =  get_post_meta( $post_id , 'custom_thumbnail_metabox' , true );

// 	echo '<img src="'.wp_get_attachment_image_url($image_id).'" />';
// });
function add_admin_column($column_title, $post_type, $cb){
    // Column Header
    add_filter( 'manage_' . $post_type . '_posts_columns', function($columns) use ($column_title) {
        $columns[ sanitize_title($column_title) ] = $column_title;
        return $columns;
    } );
    // Column Content
    add_action( 'manage_' . $post_type . '_posts_custom_column' , function( $column, $post_id ) use ($column_title, $cb) {
        if(sanitize_title($column_title) === $column){
            $cb($post_id);
        }

    }, 10, 2 );
}
add_admin_column(__('SHORTCODE'), 'encuesta', function($post_id){
	?>
        <input class="regular-text" type="text" readonly value="[encuesta-expreso id=<?=$post_id ?>]" onclick="this.select();document.execCommand('copy')" >
    <?php
});


function wporg_add_custom_box() {
	$screens = [ 'post', ];
	foreach ( $screens as $screen ) {
		add_meta_box(
			'wporg_box_id',                 // Unique ID
			'Fecha de actualización',      // Box title
			'wporg_custom_box_html',  // Content callback, must be of type callable
			$screen                            // Post type
		);
	}
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function wporg_custom_box_html( $post ) {

	$post_update_date = get_post_meta( $post->ID, '_post_update_date', true );

	?>

	<!-- <label for="post_update_date">Custom date</label> -->
	<input name="post_update_date" style="width: 100%;" type="datetime-local" value="<?php echo esc_attr($post_update_date); ?>" max="<?= date('Y-m-d'); ?>">

    <?php

}

function meta_box_datepicker_save( $post_id ) {
	if ( array_key_exists( 'post_update_date', $_POST ) ) {
	   update_post_meta(
		  $post_id,
		  '_post_update_date',
		  $_POST['post_update_date']
	   );
	}
 }
 
add_action( 'save_post', 'meta_box_datepicker_save' );

//add_action('init', function() {
//    if (is_user_logged_in()) {
//        $timeout = 900; // 15 minutos
//        $last = isset($_SESSION['last_action']) ? $_SESSION['last_action'] : 0;
//
//        if (time() - $last > $timeout) {
//            wp_logout();
//            wp_redirect(home_url());
//            exit;
//        }
//
//        $_SESSION['last_action'] = time();
//    }
//});

add_filter('edit_posts_per_page', function($per_page, $post_type) {
    if ($post_type === 'opinion') {
        return 20;
    }
    return $per_page;
}, 10, 2);

