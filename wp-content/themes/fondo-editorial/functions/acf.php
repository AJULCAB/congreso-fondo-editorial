<?php 

// OPTION PAGE
if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Configuraciones generales',
        'menu_title' => 'Configurar Tema',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_theme_config_custom',
        'redirect'   => false,
        'icon_url'=>'dashicons-admin-settings',
        'update_button' => __('Actualizar', 'acf'),
        'updated_message' => __("Configuración actualizada", 'acf'),
    ));

   

    acf_add_options_sub_page(array(
        'page_title'  => 'Insertar código',
        'menu_title'  => 'Insertar código',
        'parent_slug' => 'theme-general-settings',
        'update_button' => __('Actualizar', 'acf'),
        'capability' => 'edit_theme_config_custom',
        'updated_message' => __("Configuración actualizada", 'acf'),
    ));



    acf_add_options_sub_page(array(
        'page_title'  => 'Insertar código AMP',
        'menu_title'  => 'Insertar código AMP',
        'parent_slug' => 'theme-general-settings',
        'update_button' => __('Actualizar', 'acf'),
        'capability' => 'edit_theme_config_custom',
        'updated_message' => __("Configuración actualizada", 'acf'),
    ));

    acf_add_options_sub_page(array(
        'page_title'  => 'Anuncios globales',
        'menu_title'  => 'Anuncios globales',
        'parent_slug' => 'theme-general-settings',
        'update_button' => __('Actualizar', 'acf'),
        'capability' => 'edit_theme_config_custom',
        'updated_message' => __("Configuración actualizada", 'acf'),
    ));
    


    acf_add_options_sub_page(array(
        'page_title'  => 'Contenido de footer',
        'menu_title'  => 'Contenido de footer',
        'parent_slug' => 'theme-general-settings',
        'update_button' => __('Actualizar', 'acf'),
        'capability' => 'edit_theme_config_custom',
        'updated_message' => __("Configuración actualizada", 'acf'),
    ));

    acf_add_options_sub_page(array(
        'page_title'  => 'RSS feed',
        'menu_title'  => 'RSS feed',
        'parent_slug' => 'theme-general-settings',
        'update_button' => __('Actualizar', 'acf'),
        'capability' => 'edit_theme_config_custom',
        'updated_message' => __("Configuración actualizada", 'acf'),
    ));

    acf_add_options_sub_page(array(
        'page_title'  => 'Newsletter',
        'menu_title'  => 'Newsletter',
        'parent_slug' => 'theme-general-settings',
        'update_button' => __('Actualizar', 'acf'),
        'capability' => 'edit_theme_config_custom',
        'updated_message' => __("Configuración actualizada", 'acf'),
    ));



}


add_filter('acf/settings/google_api_key', function () {
    return get_field('op_google_api_key','option');
});

// Posición del label ACF
add_filter('acf/validate_field_group', 'expreso_acf_field_group_default_label_placement', 20);
function expreso_acf_field_group_default_label_placement($field_group){
    
    // Bail early early if it's not a new field group
    if(acf_maybe_get($field_group, 'location'))
        return $field_group;
    
    // Default label placement: Top
    $field_group['label_placement'] = 'top';
    
    return $field_group;
    
}

add_action('acf/init', 'expreso_acf_main_config');
function expreso_acf_main_config() {
    // acf_update_setting('show_admin', false);
    // acf_update_setting('google_api_key', 'xxx');
}

add_filter('acf_icon_path_suffix', 'acf_icon_path_suffix');

function acf_icon_path_suffix($path_suffix)
{
    return 'assets/svg/';
}

function svg_content($name){
    return '';
    return @file_get_contents(icon($name));
}


function add_meta_field_to_acf_relation($title, $post, $field, $post_id){
    return str_replace('</div>', '</div> <strong>'.$post->ID.': </strong>', $title);
}
add_filter('acf/fields/relationship/result', 'add_meta_field_to_acf_relation',10,4);


add_filter('acf/fields/relationship/query', 'expreso_acf_relationship_query', 10, 3);
function expreso_acf_relationship_query( $args, $field, $post_id ) {
    // only show children of the current post being edited
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    $args['suppress_filters'] = true;
    $args['ignore_custom_sort'] = true;

    $args['posts_per_page'] = 8;
	// return
    return $args;
}


add_filter('acf/fields/post_object/query', 'expreso_acf_fields_post_object_query', 10, 3);
function expreso_acf_fields_post_object_query( $args, $field, $post_id ) {
    // only show children of the current post being edited
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    $args['suppress_filters'] = true;
    $args['ignore_custom_sort'] = true;

    $args['posts_per_page'] = 8;
	// return
    return $args;
}

add_filter('acf/fields/taxonomy/query', 'expreso_acf_taxonomy_limit', 10, 3);
function expreso_acf_taxonomy_limit( $args, $field, $post_id ) {
    // Limitar los resultados a 10 términos
    $args['number'] = 8;

    // Si hay una búsqueda, también puedes modificar aquí
    if( isset( $args['search'] ) ) {
        // Ajustar lógica de búsqueda si es necesario
        $args['number'] = 8;
    }

    return $args;
}


add_action('acf/render_field/key=field_625ae6254cb1f', 'expreso_encuesta_shortcode_render');
function expreso_encuesta_shortcode_render($field){
    ?>
        <input class="regular-text" type="text" readonly value="[encuesta-expreso id=<?=get_the_ID() ?>]" onclick="this.select();document.execCommand('copy')" >
    <?php
}

/**
 * ACF Options Page 
 *
 */
// function ea_acf_portfolio_page() {
//     if ( function_exists( 'acf_add_options_sub_page' ) ){
//  		 acf_add_options_sub_page( array(
// 			'title'      => 'Opciones de Opinion',
// 			'parent'     => 'edit.php?post_type=opinion',
// 			'capability' => 'manage_options'
// 		) );
//  	}
// }
// add_action( 'init', 'ea_acf_portfolio_page' );
