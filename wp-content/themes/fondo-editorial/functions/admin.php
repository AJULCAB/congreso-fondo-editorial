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
				'menu_categories' => __('Menú Categorías'),
				'menu_footer' => __('Menú Footer'),
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

		// Add WooCommerce support
		add_theme_support( 'woocommerce' );
		
	}
endif;
add_action( 'after_setup_theme', 'expreso_admin_setup' );

// Respetar el parámetro ?per_page= en el catálogo de WooCommerce
add_filter( 'loop_shop_per_page', function ( $cols ) {
	if ( isset( $_GET['per_page'] ) && intval( $_GET['per_page'] ) > 0 ) {
		return intval( $_GET['per_page'] );
	}
	return $cols;
}, 20 );

add_filter( 'request', function ( $query_vars ) {
	if ( is_admin() || empty( $query_vars['autor'] ) ) {
		return $query_vars;
	}

	$is_product_archive_request = ! empty( $query_vars['product_cat'] )
		|| ! empty( $query_vars['product_tag'] )
		|| ( isset( $query_vars['post_type'] ) && 'product' === $query_vars['post_type'] )
		|| ( isset( $query_vars['wc_query'] ) && 'product_query' === $query_vars['wc_query'] );

	if ( $is_product_archive_request ) {
		$query_vars['autor_filtro'] = $query_vars['autor'];
		unset( $query_vars['autor'] );
	}

	return $query_vars;
}, 20 );

add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! function_exists( 'is_shop' ) || ! ( is_shop() || is_product_taxonomy() || $query->is_post_type_archive( 'product' ) ) ) {
		return;
	}

	$author_slug = '';

	if ( isset( $_GET['autor_filtro'] ) ) {
		$author_slug = sanitize_title( wp_unslash( $_GET['autor_filtro'] ) );
	} elseif ( isset( $_GET['autor'] ) ) {
		$author_slug = sanitize_title( wp_unslash( $_GET['autor'] ) );
	}

	$format_slug = isset( $_GET['formato'] ) ? sanitize_title( wp_unslash( $_GET['formato'] ) ) : '';

	if ( '' === $author_slug && '' === $format_slug ) {
		return;
	}

	$tax_query = $query->get( 'tax_query' );
	$tax_query = is_array( $tax_query ) ? $tax_query : array();
	$author_taxonomy = taxonomy_exists( 'pa_autor' ) ? 'pa_autor' : ( taxonomy_exists( 'autor' ) ? 'autor' : '' );

	if ( isset( $_GET['autor'] ) ) {
		$query->set( 'autor', '' );
	}

	if ( ! empty( $tax_query ) ) {
		$tax_query = array_values(
			array_filter(
				$tax_query,
				function ( $tax_filter ) use ( $author_taxonomy ) {
					if ( ! is_array( $tax_filter ) || empty( $tax_filter['taxonomy'] ) ) {
						return true;
					}

					return 'autor' !== $tax_filter['taxonomy'] || 'autor' === $author_taxonomy;
				}
			)
		);
	}

	if ( $author_slug && $author_taxonomy ) {
		$tax_query[] = array(
			'taxonomy' => $author_taxonomy,
			'field'    => 'slug',
			'terms'    => array( $author_slug ),
		);
	}

	if ( $format_slug && taxonomy_exists( 'pa_formato' ) ) {
		$tax_query[] = array(
			'taxonomy' => 'pa_formato',
			'field'    => 'slug',
			'terms'    => array( $format_slug ),
		);
	}

	if ( ! empty( $tax_query ) ) {
		$tax_query['relation'] = 'AND';
		$query->set( 'tax_query', $tax_query );
	}
}, 20 );



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




/* ============================================================
 * Campo de imagen genérico para taxonomías
 * Agregar el slug de cada taxonomía al array para activarlo.
 * ============================================================ */
function _taxonomy_image_js( $field_id = 'term-imagen' ) {
	$js_field_var = preg_replace( '/[^A-Za-z0-9_]/', '_', (string) $field_id );
	?>
	<script>
	(function($){
		var frame_<?php echo esc_js( $js_field_var ); ?>;
		$(document).on('click', '#<?php echo esc_js($field_id); ?>-btn', function(e){
			e.preventDefault();
			if (frame_<?php echo esc_js( $js_field_var ); ?>) { frame_<?php echo esc_js( $js_field_var ); ?>.open(); return; }
			frame_<?php echo esc_js( $js_field_var ); ?> = wp.media({
				title: '<?php esc_html_e('Seleccionar imagen', 'vyv'); ?>',
				button: { text: '<?php esc_html_e('Usar esta imagen', 'vyv'); ?>' },
				multiple: false
			});
			frame_<?php echo esc_js( $js_field_var ); ?>.on('select', function(){
				var att = frame_<?php echo esc_js( $js_field_var ); ?>.state().get('selection').first().toJSON();
				$('#<?php echo esc_js($field_id); ?>').val(att.id);
				$('#<?php echo esc_js($field_id); ?>-preview').html('<img src="'+att.url+'" style="max-width:200px;height:auto;">');
				$('#<?php echo esc_js($field_id); ?>-remove').show();
			});
			frame_<?php echo esc_js( $js_field_var ); ?>.open();
		});
		$(document).on('click', '#<?php echo esc_js($field_id); ?>-remove', function(){
			$('#<?php echo esc_js($field_id); ?>').val('');
			$('#<?php echo esc_js($field_id); ?>-preview').html('');
			$(this).hide();
		});
	})(jQuery);
	</script>
<?php }

function taxonomy_add_image_field_cb() {
	wp_enqueue_media(); ?>
	<div class="form-field term-imagen-wrap">
		<label for="term-imagen"><?php esc_html_e('Imagen', 'vyv'); ?></label>
		<input type="hidden" id="term-imagen" name="term_imagen" value="">
		<div id="term-imagen-preview" style="margin-bottom:8px;"></div>
		<button type="button" class="button" id="term-imagen-btn"><?php esc_html_e('Seleccionar imagen', 'vyv'); ?></button>
		<button type="button" class="button" id="term-imagen-remove" style="display:none;"><?php esc_html_e('Eliminar imagen', 'vyv'); ?></button>
		<?php _taxonomy_image_js(); ?>
	</div>
<?php }

function taxonomy_edit_image_field_cb( $term ) {
	$imagen_id  = get_term_meta( $term->term_id, 'term_imagen', true );
	$imagen_url = $imagen_id ? wp_get_attachment_image_url( $imagen_id, 'thumbnail' ) : '';
	wp_enqueue_media(); ?>
	<tr class="form-field term-imagen-wrap">
		<th scope="row"><label for="term-imagen"><?php esc_html_e('Imagen', 'vyv'); ?></label></th>
		<td>
			<input type="hidden" id="term-imagen" name="term_imagen" value="<?php echo esc_attr( $imagen_id ); ?>">
			<div id="term-imagen-preview" style="margin-bottom:8px;">
				<?php if ( $imagen_url ) : ?>
					<img src="<?php echo esc_url( $imagen_url ); ?>" style="max-width:200px;height:auto;">
				<?php endif; ?>
			</div>
			<button type="button" class="button" id="term-imagen-btn"><?php esc_html_e('Seleccionar imagen', 'vyv'); ?></button>
			<button type="button" class="button" id="term-imagen-remove"<?php echo $imagen_id ? '' : ' style="display:none;"'; ?>><?php esc_html_e('Eliminar imagen', 'vyv'); ?></button>
			<?php _taxonomy_image_js(); ?>
		</td>
	</tr>
<?php }

function taxonomy_save_image_field_cb( $term_id ) {
	if ( isset( $_POST['term_imagen'] ) ) {
		$imagen_id = absint( $_POST['term_imagen'] );
		if ( $imagen_id ) {
			update_term_meta( $term_id, 'term_imagen', $imagen_id );
		} else {
			delete_term_meta( $term_id, 'term_imagen' );
		}
	}
}

function taxonomy_image_add_column_cb( $columns ) {
	$columns['term_imagen'] = __( 'Imagen', 'vyv' );
	return $columns;
}

function taxonomy_image_render_column_cb( $content, $column_name, $term_id ) {
	if ( $column_name !== 'term_imagen' ) {
		return $content;
	}
	$imagen_id = get_term_meta( $term_id, 'term_imagen', true );
	if ( $imagen_id ) {
		$url = wp_get_attachment_image_url( $imagen_id, array( 100, 100 ) );
		if ( $url ) {
			return '<img src="' . esc_url( $url ) . '" style="max-width:100px;height:auto;object-fit:contain;border-radius:3px;">';
		}
	}
	return '—';
}

// Registrar hooks de imagen para cada taxonomía del tema
add_action( 'admin_head', function() {
	echo '<style>.column-term_imagen { width: 100px !important; max-width: 100px; }</style>';
} );

add_action( 'init', function() {
	foreach ( array( 'categorias_video', 'autor','categorias_libro' ) as $tax_slug ) {
		add_action( "{$tax_slug}_add_form_fields",  'taxonomy_add_image_field_cb' );
		add_action( "{$tax_slug}_edit_form_fields", 'taxonomy_edit_image_field_cb' );
		add_action( "created_{$tax_slug}",          'taxonomy_save_image_field_cb' );
		add_action( "edited_{$tax_slug}",           'taxonomy_save_image_field_cb' );
		add_filter( "manage_edit-{$tax_slug}_columns",       'taxonomy_image_add_column_cb' );
		add_filter( "manage_{$tax_slug}_custom_column",      'taxonomy_image_render_column_cb', 10, 3 );
	}
} );

// usar con term_image() para mostrar la imagen en el frontend