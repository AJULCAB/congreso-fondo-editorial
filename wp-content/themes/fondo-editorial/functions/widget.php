<?php

function expreso_theme_register_sidebars() {
   

    register_sidebar( array(
        'name' => '[WIDGET] - Sidebar de internas',
        'id' => 'post_sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
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

