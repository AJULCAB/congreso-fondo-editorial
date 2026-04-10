<?php

function title_page()
{
    $title='';
    $sep  = ' - ';
    $name = get_bloginfo('name');
    if (is_single() || is_page()) {
        if (is_page('el-concurso')  || is_page('inscripcion')) {
            $title = wp_title($sep, false, 'right');
        } else {
            $title = wp_title($sep, false, 'right'). $name;
        }
    }
    if (is_category()) {
        $title = single_cat_title('', false) . $sep . $name;
    }
    if (is_post_type_archive()) {
        $title = post_type_archive_title('', false) . $sep . $name;
    }
    if (is_tax()) {
        $taxonomy = get_queried_object();
        $title    = $taxonomy->name . $sep . $name;
    }
    if (is_404()) {
        $title = '404' . $sep . $name;
    }
    if (is_home() || is_front_page()) {
        $name_page = get_bloginfo('name');
        $title     = $name_page . $sep . get_bloginfo('description');
    }
    return $title;
}

function title_page_build($name)
{
    $sep  = ' - ';
    if (is_single() || is_page()) {
        if (is_page('el-concurso')  || is_page('inscripcion')) {
            $title = wp_title($sep, false, 'right');
        } else {
            $title = wp_title($sep, false, 'right')  . $sep . $name;
        }
    }
    if (is_category()) {
        $title = single_cat_title('', false) . $sep . $name;
    }
    if (is_post_type_archive()) {
        $title = post_type_archive_title('', false) . $sep . $name;
    }
    if (is_tax()) {
        $taxonomy = get_queried_object();
        $title    = $taxonomy->name . $sep . $name;
    }
    if (is_404()) {
        $title = '404' . $sep . $name;
    }
    if (is_home() || is_front_page()) {
        $name_page = get_bloginfo('name');
        $title     = $name_page . $sep . get_bloginfo('description');
    }
    return $title;
}

function assets($url = '')
{
    if (is_exp_static()) {
        $cdn=get_exp_static_assets_prefix();
        if ($cdn) {
            return $cdn . '/assets/' . $url;
        } else {
            return home_url() . '/assets/' . $url;
        }
    }else{
        return get_template_directory_uri() . '/assets/' . $url;
    }
}

function asset_svg($url = '')
{
    return get_template_directory_uri() . '/assets/icons/' . $url;
}


function icon($icon)
{

    return assets("svg/{$icon}.svg");
}



function ajax_response($status)
{
    wp_send_json($status);
    die();
}

function api_curl($name = 'nada', $data = array(), $token='')
{
    set_time_limit(0);
    $data_string = json_encode($data);
    $ch          = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://sss.work/api/service/$name");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    $authorization = "X-Authorization: " . $token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
    $output = curl_exec($ch);
    $info   = curl_getinfo($ch);
    curl_close($ch);
    $output = json_decode($output, true);

    return $output;
}

function get_id_youtube($url)
{
    preg_match("#([\/|\?|&]vi?[\/|=]|youtu\.be\/|embed\/)([a-zA-Z0-9_-]+)#", $url, $matches);
    return end($matches);
}
function get_id_faceboo_video($url)
{
    preg_match("/(\d+)\/?$/", $url, $matches);
    return end($matches);
}
function get_id_vimeo($url)
{
    $regs = array();

    $id = '';

    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
        $id = $regs[3];
    }

    return $id;
}



function wp_get_menu_array($current_menu)
{

    $menuLocations = get_nav_menu_locations(); // Get our nav locations (set in our theme, usually functions.php)
    $menu_lists = array();

    // This returns an array of menu locations ([LOCATION_NAME] = MENU_ID);
    if (isset($menuLocations[$current_menu])) {
        # code...
        $menuID = $menuLocations[$current_menu]; // Get the *primary* menu ID

        $menus = wp_get_nav_menu_items($menuID);

        // echo json_encode($menus);exit;

        if ($menus) {
            # code...
            foreach ($menus as $menu) {
                if ($menu->menu_item_parent === "0") {
                    $menu_lists[$menu->ID]['menu'] = (object) array(
                        'id'    => $menu->object_id,
                        'title' => $menu->title,
                        'url'   => $menu->url,
                        'type'  => $menu->type_label,
                        'object'  => $menu->object,
                        'active'  => eval_menu_active($menu),
                        // 'url'   => get_category_link($menu->object_id),

                    );
                } else {
                    $submenu_item = array();

                    foreach ($menus as $submenu) {
                        if ($submenu->menu_item_parent == $menu->menu_item_parent) {
                            $submenu_item[] = (object) array(
                                'id'    => $submenu->object_id,
                                'title' => $submenu->title,
                                'url'   => $submenu->url,
                                'type'  => $menu->type_label,

                                'object'  => $menu->object,
                                'active'  => eval_menu_active($menu),

                                // 'url'   => get_category_link($submenu->object_id),
                            );
                        }
                    }

                    $menu_lists[$menu->menu_item_parent]['submenu'] = $submenu_item;
                }
            }
        }

    }

    // echo json_encode($menu_lists);

    return $menu_lists;
}
function eval_menu_active($menu)
{
    if ($menu->type == 'post_type_archive') {
        # code...
        if (is_post_type($menu->object)) {
            # code...
            return true;
        }
    } else {
        if ($menu->object_id == get_queried_object_id()) {
            # code...
            return true;
        }
    }
    return false;
}

function build_url($string)
{
    return sanitize_title($string);
}

/**
 * https://stackoverflow.com/questions/45436051/how-to-add-excerpt-in-custom-post-type-in-wordpress
 * 
 * 
 */
function cpt_generate($name, $taxonomy = array('category', 'post_tag'), $icon = 'dashicons-admin-post', $plural = 's', $support = array('title', 'editor', 'thumbnail', 'custom-fields','excerpt', 'page-attributes'))
{
    $name_l = build_url($name);

    $name_u = strtoupper($name);
    $name_o = ucfirst(strtolower($name));
    $name_p = $name_o . $plural;

    $labels = array(
        'name'                  => _x($name_p, 'Nombre general', 'vyv'),
        'singular_name'         => _x($name_o, 'Nombre singular', 'vyv'),
        'menu_name'             => __($name_p, 'vyv'),
        'name_admin_bar'        => __($name_p, 'vyv'),
        'archives'              => __($name_p, 'vyv'),
        'attributes'            => __('Atributos', 'vyv'),
        'parent_item_colon'     => __('Artículo principal:', 'vyv'),
        'all_items'             => __('Listar todo', 'vyv'),
        'add_new_item'          => __('Agregar ' . $name_o . ' nuevo', 'vyv'),
        'add_new'               => __('Agregar nuevo ', 'vyv'),
        'new_item'              => __('Nuevo ' . $name_o, 'vyv'),
        'edit_item'             => __('Editar ' . $name_o, 'vyv'),
        'update_item'           => __('Actualizar ' . $name_o, 'vyv'),
        'view_item'             => __('Ver ' . $name_o . '', 'vyv'),
        'view_items'            => __('Ver ' . $name_o . 's', 'vyv'),
        'search_items'          => __('Buscar ' . $name_o, 'vyv'),
        'not_found'             => __('No se ha encontrado', 'vyv'),
        'not_found_in_trash'    => __('No se ha encontrado en papelera', 'vyv'),
        'featured_image'        => __('Imagen destacada', 'vyv'),
        'set_featured_image'    => __('Establecer imagen destacada', 'vyv'),
        'remove_featured_image' => __('Eliminar imagen destacada', 'vyv'),
        'use_featured_image'    => __('Usar como imagen destacada', 'vyv'),
        'insert_into_item'      => __('Insertar en post', 'vyv'),
        'uploaded_to_this_item' => __('Subido a este post', 'vyv'),
        'items_list'            => __('Lista de elementos', 'vyv'),
        'items_list_navigation' => __('Lista de elementos de navegación', 'vyv'),
        'filter_items_list'     => __('Lista de elementos de filtro', 'vyv'),
    );
    $rewrite = array(
        'slug'       => $name_l,
        'with_front' => true,
        'pages'      => true,
        'feeds'      => true,
    );

    $responseargs = array(
        'label'               => __($name_o, 'vyv'),
        'description'         => __('Descripción', 'vyv'),
        'labels'              => $labels,
        'supports'            => $support,
        'taxonomies'          => $taxonomy,
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => $icon,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => $name_l,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
    return $responseargs;
}

function tax_generate($name, $custom = false, $add = '')
{
    $name_l = strtolower($name);
    $name_u = strtoupper($name);
    $name_o = ucfirst(strtolower($name));
    $name_p = $name_o . 's';

    $url = build_url($name);

    if ($custom) {
        # code...
        $name_s = $name_o;
        $name_p = $name_o . $add;
    } else {
        $name_s = 'Categoría';
        $name_p = 'Categorías';
    }

    $labels = array(
        'name'                       => _x($name_p, 'Nombre general de taxonomía', 'vyv'),
        'singular_name'              => _x($name_s, 'Nombre singular de taxonomía', 'vyv'),
        'menu_name'                  => __($name_p, 'vyv'),
        'all_items'                  => __('Todas las ' . $name_p, 'vyv'),
        'parent_item'                => __($name_s . ' principal', 'vyv'),
        'parent_item_colon'          => __($name_s . ' principal:', 'vyv'),
        'new_item_name'              => __('Nuevo nombre de ' . $name_s, 'vyv'),
        'add_new_item'               => __('Agregar nueva(o) ' . $name_s, 'vyv'),
        'edit_item'                  => __('Editar ' . $name_s, 'vyv'),
        'update_item'                => __('Actualizar ' . $name_s, 'vyv'),
        'view_item'                  => __('Ver ítem', 'vyv'),
        'separate_items_with_commas' => __($name_p . ' separadas con comas', 'vyv'),
        'add_or_remove_items'        => __('Agregar o eliminar ' . $name_p, 'vyv'),
        'choose_from_most_used'      => __('Elige entre las/los ' . $name_p . ' más utilizadas', 'vyv'),
        'popular_items'              => __('Artículos populares', 'vyv'),
        'search_items'               => __('Buscar ' . $name_p, 'vyv'),
        'not_found'                  => __('No encontrado', 'vyv'),
        'no_terms'                   => __('No hay ' . $name_p, 'vyv'),
        'items_list'                 => __('Lista de ' . $name_p, 'vyv'),
        'items_list_navigation'      => __('Lista de ' . $name_p . ' de navegación', 'vyv'),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => array(
            'slug' => $url,
            'with_front' => false, 
			'hierarchical' => true
        ),
        // 'capabilities'=>
    );

    return $args;
}

function redirect($url = '/')
{
    return home_url($url);
    // return home_url($url, $scheme = 'relative');
}

function args_cpt($post_type = 'nada', $numberposts = '-1')
{
    $args = array(
        'numberposts' => $numberposts, // -1 is for all
        'post_type'   => $post_type, // or 'post', 'page'
        //'category'      => $category_id,
        //'exclude'       => get_the_ID()
        // ...
        // http://codex.wordpress.org/Template_Tags/get_posts#Usage
    );
    return $args;
}

function thumbnail($id, $type = 'full',$default=true)
{

    // is_exp_static
    // get_exp_static_media_prefix

    // //Default WordPress
    // the_post_thumbnail( 'thumbnail' );     // Thumbnail (150 x 150 hard cropped)
    // the_post_thumbnail( 'medium' );        // Medium resolution (300 x 300 max height 300px)
    // the_post_thumbnail( 'medium_large' );  // Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
    // the_post_thumbnail( 'large' );         // Large resolution (1024 x 1024 max height 1024px)
    // the_post_thumbnail( 'full' );          // Full resolution (original size uploaded)

    // //With WooCommerce
    // the_post_thumbnail( 'shop_thumbnail' ); // Shop thumbnail (180 x 180 hard cropped)
    // the_post_thumbnail( 'shop_catalog' );   // Shop catalog (300 x 300 hard cropped)
    // the_post_thumbnail( 'shop_single' );    // Shop single (600 x 600 hard cropped)
    if (!has_post_thumbnail($id)) {
        return assets('img/default-placeholder.png');  
    }
    $image= get_the_post_thumbnail_url($id, $type);
    if (!$image && $default) {
        $image=assets('img/default-placeholder.png');
    }

    if (is_exp_static()) {
        # code...
        $cdn_image=get_exp_static_media_prefix();
        if ($cdn_image) {
            $image=str_replace(home_url()."/wp-content/uploads",$cdn_image,$image);
        }
    }
    return $image;
}

function thumbnail_url($url){
    if (!$url) {
        return assets('img/default-placeholder.png');
    }
    return $url;
}

function ajax_script_load_more($args)
{
    //init ajax
    $ajax = false;
    //check ajax call or not
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        $ajax = true;
    }
    //number of posts per page default
    //query
    $query = new WP_Query($args);
    //check
    if ($query->have_posts()) :
        //loop articales
        while ($query->have_posts()) : $query->the_post();
            //include articles template
            include get_template_directory() . '/inc/post_by_search.php';

        endwhile;
    else :
        echo 0;
    endif;
    //reset post data
    wp_reset_postdata();
    //check ajax call
    if ($ajax) {
        die();
    }
}


function is_post_type($type)
{
    global $wp_query;
    if (!isset($wp_query->post->ID)) {
        # code...
        return false;
    }
    if ($type == get_post_type($wp_query->post->ID))
        return true;
    return false;
}




function array_to_css($data)
{
    if (is_array($data)) {
        # code...
        $css = '';
        foreach ($data as $key => $value) {
            # code...
            $css .= "$key:$value; ";
        }
        return $css;
    } else {
        # code...
        return '';
    }
}

function menu_active($menu, $type)
{
    switch ($type) {
        case 'page':
            # code...
            if (is_page($menu)) {
                # code...
                return 'uk-active';
            }
            break;
        case 'cpt':
            # code...
            if (is_post_type($menu)) {
                # code...
                return 'uk-active';
            }
            break;

        default:
            # code...
            break;
    }
}


function default_image()
{
    return get_field('op_imagen_por_defecto', 'option');
}

function icon_svg_change_color($id, $color = "#000000")
{
    try {
        //code...
        $arrContextOptions=array(
            "ssl"=>array(
                 "verify_peer"=>false,
                 "verify_peer_name"=>false,
            ),
        ); 

        $svg_cont = file_get_contents(thumbnail($id),false, stream_context_create($arrContextOptions));
        $replace_codes = str_replace("#000000", $color, $svg_cont);
        return str_replace("<svg ", "<svg style='fill:$color' ", $replace_codes);
    } catch (\Throwable $th) {
        //throw $th;
        return '';
    }
}

function get_data_table($tablename = 'name')
{
    global $wpdb;
    $table = $wpdb->prefix . $tablename;
    $sql = "SELECT * FROM `$table` ORDER BY id DESC";
    return $wpdb->get_results($sql, OBJECT);
}


function generate_rstring($length = 10)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function array_md5(Array $array) {
    array_multisort($array);
    return md5(json_encode($array));
}

function WP_Query_o_cache($arg = array()){
    // Generar un ID único para el transient
    $origin=isset($arg['origin'])?$arg['origin']:'sin_origin';
    // $current_id=get_the_ID();
    // if (!$current_id) {
    //     $current_id='00';
    // }
    $transient_id = 'query_cache_' .$origin.'_'. array_md5($arg);
    // Intentar obtener los resultados del transient
    $cached_result = get_transient($transient_id);
    if ($cached_result !== false) {
        // Si se encontró en caché, retornar los resultados cacheados
        return $cached_result;
    }
    // Establecer valores por defecto para optimizar la consulta
    if (!isset($arg['fields'])) {
        $arg['fields'] = 'ids';
    }
    if (!isset($arg['orderby'])) {
        $arg['orderby'] = array('date' => 'DESC');
    }
    if (!isset($arg['post_status'])) {
        $arg['post_status'] = 'publish';
    }
    // $arg['orderby'] = 'publish_date';
    // $arg['order'] = 'DESC';
    $arg['update_post_meta_cache'] = false; // No cachear metadatos
    $arg['update_post_term_cache'] = false; // No cachear términos
    $arg['ignore_sticky_posts'] = true;     // Ignorar posts fijados
    $arg['no_found_rows'] = true;           // No contar resultados para paginación
    // $args['lazy_load_term_meta'] = true;

    // Ejecutar la consulta
    $optimized_query_with_ids = new WP_Query($arg);
    // Cachear el resultado
    set_transient($transient_id, $optimized_query_with_ids->posts, 6*HOUR_IN_SECONDS); // Cache por 6 horas
    return $optimized_query_with_ids->posts; // Retornar solo los IDs de los posts
}

function WP_Query_o($args = array()){
    if (!isset($args['paged'])) {
        //$post_ids = WP_Query_o_cache($args);
        //$args['post__in'] = $post_ids;
    }
    // Establecer valores por defecto para optimizar la consulta
    if (!isset($args['fields'])) {
        $args['fields'] = 'ids';
    }
    if (!isset($args['orderby'])) {
        $args['orderby'] = array('date' => 'DESC');
    }
    if (!isset($args['post_status'])) {
        $args['post_status'] = 'publish';
    }
    // $arg['orderby'] = 'publish_date';
    // $arg['order'] = 'DESC';
    $args['update_post_meta_cache'] = false; // No cachear metadatos
    $args['update_post_term_cache'] = false; // No cachear términos
    $args['ignore_sticky_posts'] = true;     // Ignorar posts fijados
    //$args['no_found_rows'] = true;           // No contar resultados para paginación
    if (isset($args['no_found_rows'])) {
      $args['no_found_rows'] = $args['no_found_rows'];
    }else{
      $args['no_found_rows'] = true;
    }
    $args['lazy_load_term_meta'] = true;
    // Ejecutar la consulta
    return new WP_Query($args);
}

function post_count_by_args($args){
    if (isset($args->post_count)) {
        return $args->post_count;
    } else {
        $the_query = WP_Query_o($args);
        if (isset($the_query->post_count)) {
            return $the_query->post_count;
        } 
    }
    return 0;
}


function expreso_sanitize_url( $url ) {
    return esc_url_raw( $url );
}

function get_ids_posts_by_args($args){
    if (is_array($args)) {
        $args['fields']='ids';
        return get_posts( $args );
    }
    return [];
}

function component_url($url_parameters=[]){

    return redirect("component?" . build_query($url_parameters));
}

function image_auto_url($imagen){
    if (!$imagen) {
        return assets('img/default-placeholder.png');
    }
    if (is_numeric($imagen)) {
       return  wp_get_attachment_url($imagen);
    }
    return $imagen;
}
function wp_insert_attachment_from_url( $url, $parent_post_id = null ) {

	if ( ! class_exists( 'WP_Http' ) ) {
		require_once ABSPATH . WPINC . '/class-http.php';
	}

	$http     = new WP_Http();
	$response = $http->request( $url );
    if (!isset($response['response']['code'])) {
        # code...
		return false;
    }
	if ( 200 !== $response['response']['code'] ) {
		return false;
	}

	$upload = wp_upload_bits( basename( $url ), null, $response['body'] );
	if ( ! empty( $upload['error'] ) ) {
		return false;
	}

	$file_path        = $upload['file'];
	$file_name        = basename( $file_path );
	$file_type        = wp_check_filetype( $file_name, null );
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir    = wp_upload_dir();

	$post_info = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
		'post_mime_type' => $file_type['type'],
		'post_title'     => $attachment_title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	// Create the attachment.
	$attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );

	// Include image.php.
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Generate the attachment metadata.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

	// Assign metadata to attachment.
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;

}

function last_used_tags($cantidad=5){
    $found_tags = $final_tags = $id_records = array();
    // get last 10 posts
    $last_posts = get_posts([
        'post_type' => 'post',
        'posts_per_page' =>$cantidad,
        'update_post_meta_cache' =>false,
        'update_post_term_cache' =>false,
        'ignore_sticky_posts' =>true,
        'no_found_rows' =>true,

    ]);

    // gather tags
    foreach($last_posts as $post)
    $found_tags = array_merge($found_tags, wp_get_post_tags($post->ID));

    // prepare final tags for the cloud
    foreach($found_tags as $tag){

        // ignore duplicates
        if(in_array($tag->term_id, $id_records))
            continue;

        // track ids...
        $id_records[] = $tag->term_id;

        // generate links
        $tag->link = get_tag_link($tag);

        // keep it
        $final_tags[] = $tag;
    }

    return $final_tags;
}

// Add this function in functions.php file
// custom function to check if amp_is_request exists so that the site doesn't throw error when AMP plugin is disabled.
function is_amp() {
    if ( function_exists( 'amp_is_request' ) ):
        return amp_is_request();
    else :
        return false;
    endif;
}

function expreso_ads_generator($id){
    return "<ins class=\"adsbygoogle\" style=\"display:inline-block;width:160px;height:100%\" data-ad-client=\"ca-pub-{$id}\"  data-ad-slot=\"{$id}\"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>";
}
function expresotv_is_live_program($term){
    $the_query = WP_Query_o(array(
        'origin'=>'expresotv_is_live_program',
        'post_type' => 'expresotv',
        'posts_per_page' => 1,
        'date_query' => array(
            'after' => date("Y-m-d", strtotime("yesterday"))
        ),
        'tax_query' => array(
            array (
                'taxonomy' => 'programas',
                'field' => 'term_id',
                'terms' => $term->term_id,
            )
        ),
        'meta_query' => array(
            array(
                'key' => 'video_en_vivo',
                'value' => true,
                'compare' => '==' 
            ),
        ),
        
    ));
    return post_count_by_args($the_query);
}


function f_porcent($num)
{
    if (!$num) {
        return 0;
    }
    return  number_format($num, 2, '.', '.')/1;
}

function getCurrentDomain(){
    try {
      //code...
      $urlparts = wp_parse_url(home_url());
      return $urlparts['host'];
    } catch (\Throwable $th) {
      //throw $th;
      return '';
    }
}

function get_current_cateory(){
    // Inicializa el array para almacenar los IDs de las categorías
    $category_ids = array();

    // Verifica si estás en una página de un post individual
    if (is_single()) {
        // Obtiene las categorías del post actual
        global $post;
        $categories = get_the_category($post->ID);
        // Recorre las categorías y almacena los IDs en el array
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }
    } elseif (is_category()) {
        // Obtiene el ID de la categoría actual
        $category = get_queried_object();
        $category_ids[] = $category->term_id;
    }
    return $category_ids;
}
