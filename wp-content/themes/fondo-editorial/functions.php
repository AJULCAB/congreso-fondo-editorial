<?php 

/**
 * Functions
 * Require all PHP files in the /functions/ directory
 */
foreach (glob(get_template_directory() . "/functions/*.php") as $function) {
    $function= basename($function);
    require get_template_directory() . '/functions/' . $function;
}

add_filter( 'heartbeat_send', '__return_false', 10 );

add_filter( 'heartbeat_settings', function( $settings ) {
    $settings['interval'] = 120; // 2 minutos entre solicitudes
    return $settings;
});
