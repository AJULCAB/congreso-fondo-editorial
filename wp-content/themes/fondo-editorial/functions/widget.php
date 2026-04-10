<?php

function expreso_theme_register_sidebars() {
    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de Home',
        'id' => 'home_sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de post',
        'id' => 'post_sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de últimas noticias',
        'id' => 'post_ultimas_noticias_sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de post (Anuncios)',
        'id' => 'post_sidebar_anuncio',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de opinión (Anuncios)',
        'id' => 'opinion_sidebar_anuncio',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de blog (Anuncios)',
        'id' => 'blog_sidebar_anuncio',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de autor de post (Anuncios)',
        'id' => 'post_autor_sidebar_anuncio',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_title'   => '',
    ) );
    
    
    

    register_sidebar( array(
        'name' => '[WIDGET] - Más contenido de Categorías',
        'id' => 'content_category',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Más contenido de Etiquetas',
        'id' => 'content_tag',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de Opinion',
        'id' => 'opinion_sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de Blog',
        'id' => 'blog_sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de Expreso TV',
        'id' => 'single_expresotv_sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );


    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de perfil de Columnista',
        'id' => 'opinion_sidebar_columnista',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de perfil de Bloguero',
        'id' => 'opinion_sidebar_bloguero',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );


    


    
    
}
add_action( 'widgets_init', 'expreso_theme_register_sidebars' );




// /**
//  * Add a new dashboard widget.
//  */
// function wpdocs_add_dashboard_widgets() {
//     wp_add_dashboard_widget( 'dashboard_widget', 'Example Dashboard Widget', 'dashboard_widget_function' );
// }
// add_action( 'wp_dashboard_setup', 'wpdocs_add_dashboard_widgets' );
 
// /**
//  * Output the contents of the dashboard widget
//  */
// function dashboard_widget_function( $post, $callback_args ) {
//     esc_html_e( "Hello World, this is my first Dashboard Widget!", "textdomain" );
// }

