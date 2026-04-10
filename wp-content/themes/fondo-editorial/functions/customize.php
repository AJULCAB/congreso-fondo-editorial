<?php

/**
 *
 * Add customize options
 * https://desarrollowp.com/blog/tutoriales/sacale-partido-al-personalizador-wordpress/
 * https://sodocumentation.net/wordpress/topic/2930/customizer-basics--add-panel--section--setting--control-
 * https://www.usablewp.com/learn-wordpress/wordpress-customizer/how-to-add-a-panel-section-and-controls-to-the-customize-panel/
 * 
 * 
 */

function expreso_customize_register( $wp_customize ) {
   //All our sections, settings, and controls will be added here
    wp_customize_config_expreso($wp_customize);
    wp_customize_agregar_color($wp_customize);



}
add_action( 'customize_register', 'expreso_customize_register' );

function wp_customize_config_expreso($wp_customize){
    // Theme Options Panel
    $wp_customize->add_panel( 'expreso_theme_config_options', 
        array(
            'priority'       => 99999,
            'title'            =>'Más Configuración de Expreso' ,
            'description'      =>'Lista de configuraciones del template de expreso' ,
        ) 
    );
    // ###########################################################################################################
    wp_customize_dates_format_config_expreso($wp_customize);
    wp_customize_alerts_config_expreso($wp_customize);
    wp_customize_popup_config_expreso($wp_customize);
    

    // ###########################################################################################################

    // Text Options Section Inside Theme
    $wp_customize->add_section( 'expreso_rrss_options', 
        array(
            'title'         =>'Redes sociales' ,
            'description'   =>'Lista de todas las redes sociales de Expreso',
            'priority'      => 1,
            'panel'         => 'expreso_theme_config_options'
        ) 
    );



    // ###########################################################################################################

    // Settinf field
    $wp_customize->add_setting( 'expreso_rrss_facebook_url',
        array(
            'default'           =>'' ,
            'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_rrss_facebook_url', 
        array(
            'type'        => 'url',
            'priority'    => 10,
            'section'     => 'expreso_rrss_options',
            'label'       => 'Enlace de facebook',
            'description' => 'Ingrese el enlace de facebook',
            'input_attrs' => array(
                'placeholder' => __( 'https://www.facebook.com/user' ),
            ),
        ) 
    );



    // ###########################################################################################################


    // Settinf field
    $wp_customize->add_setting( 'expreso_rrss_twitter_url',
        array(
            'default'           =>'' ,
            'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_rrss_twitter_url', 
        array(
            'type'        => 'url',
            'priority'    => 10,
            'section'     => 'expreso_rrss_options',
            'label'       => 'Enlace de twitter',
            'description' => 'Ingrese el enlace de twitter',
            'input_attrs' => array(
                'placeholder' => __( 'https://twitter.com/user' ),
            ),
        ) 
    );

    // ###########################################################################################################


    // Settinf field
    $wp_customize->add_setting( 'expreso_rrss_youtube_url',
        array(
            'default'           =>'' ,
            'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_rrss_youtube_url', 
        array(
            'type'        => 'url',
            'priority'    => 10,
            'section'     => 'expreso_rrss_options',
            'label'       => 'Enlace de youtube',
            'description' => 'Ingrese el enlace de youtube',
            'input_attrs' => array(
                'placeholder' => __( 'https://youtube.com/user' ),
            ),
        ) 
    );

    // ###########################################################################################################


    // Settinf field
    $wp_customize->add_setting( 'expreso_rrss_instagram_url',
        array(
            'default'           =>'' ,
            'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_rrss_instagram_url', 
        array(
            'type'        => 'url',
            'priority'    => 10,
            'section'     => 'expreso_rrss_options',
            'label'       => 'Enlace de instagram',
            'description' => 'Ingrese el enlace de instagram',
            'input_attrs' => array(
                'placeholder' => __( 'https://instagram.com/user' ),
            ),
        ) 
    );


    // ###########################################################################################################


    // Settinf field
    $wp_customize->add_setting( 'expreso_rrss_tiktok_url',
        array(
            'default'           =>'' ,
            'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_rrss_tiktok_url', 
        array(
            'type'        => 'url',
            'priority'    => 10,
            'section'     => 'expreso_rrss_options',
            'label'       => 'Enlace de TikTok',
            'description' => 'Ingrese el enlace de tiktok',
            'input_attrs' => array(
                'placeholder' => __( 'https://tiktok.com/user' ),
            ),
        ) 
    );


    // ###########################################################################################################


    // Settinf field
    $wp_customize->add_setting( 'expreso_rrss_whatsapp_url',
        array(
            'default'           =>'' ,
            'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_rrss_whatsapp_url', 
        array(
            'type'        => 'url',
            'priority'    => 10,
            'section'     => 'expreso_rrss_options',
            'label'       => 'Enlace de WhatsApp',
            'description' => 'Ingrese el enlace de WhatsApp',
            'input_attrs' => array(
                'placeholder' => __( 'https://wa.me/XXXXXXXXX' ),
            ),
        ) 
    );


}
function wp_customize_agregar_color($wp_customize){
    // ###########################################################################################################

    // Header & Footer Background Color.
    $wp_customize->add_setting(
        'expreso_header_footer_background_color',
        array(
            'default'           => '#000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'expreso_header_footer_background_color',
            array(
                'label'   => 'Color principal de Expreso',
                'section' => 'colors',
            )
        )
    );
    // ###########################################################################################################
    // ###########################################################################################################
    // ###########################################################################################################

}


function  wp_customize_dates_format_config_expreso($wp_customize){
    // Text Options Section Inside Theme
    $wp_customize->add_section( 'expreso_fechas_options', 
        array(
            'title'         =>'Configuración de fechas' ,
            'description'   =>'Lista de la configuración de fechas. <br> <a href="https://es.wordpress.org/support/article/formatting-date-and-time/" target="_blank">Documentación sobre el formato de fecha y hora.</a>',
            'priority'      => 1,
            'panel'         => 'expreso_theme_config_options'
        ) 
    );

    // ###########################################################################################################

    // Settinf field
    $wp_customize->add_setting( 'expreso_formato_fecha_header',
        array(
            'default'           =>'' ,
            // 'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_formato_fecha_header', 
        array(
            'type'        => 'text',
            'priority'    => 10,
            'section'     => 'expreso_fechas_options',
            'label'       => 'Formato de fecha del header',
            // 'description' => 'Ingrese el formato de fecha del header ',
            'input_attrs' => array(
                'placeholder' => __( 'j \d\e F \d\e Y' ),
            ),
        ) 
    );

    // ###########################################################################################################

    // Settinf field
    $wp_customize->add_setting( 'expreso_formato_fecha_post',
        array(
            'default'           =>'' ,
            // 'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_formato_fecha_post', 
        array(
            'type'        => 'text',
            'priority'    => 10,
            'section'     => 'expreso_fechas_options',
            'label'       => 'Formato de fecha de las noticias',
            // 'description' => 'Ingrese el formato de fecha del header ',
            'input_attrs' => array(
                'placeholder' => __( 'j \d\e F \d\e Y' ),
            ),
        ) 
    );
    // ###########################################################################################################

    // Settinf field
    $wp_customize->add_setting( 'expreso_formato_hora_post',
        array(
            'default'           =>'' ,
            // 'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_formato_hora_post', 
        array(
            'type'        => 'text',
            'priority'    => 10,
            'section'     => 'expreso_fechas_options',
            'label'       => 'Formato de hora de las noticias',
            // 'description' => 'Ingrese el formato de fecha del header ',
            'input_attrs' => array(
                'placeholder' => __( 'H:i \h' ),
            ),
        ) 
    );

    // ###########################################################################################################

    // Settinf field
    $wp_customize->add_setting( 'expreso_formato_fecha_opinion',
        array(
            'default'           =>'' ,
            // 'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_formato_fecha_opinion', 
        array(
            'type'        => 'text',
            'priority'    => 10,
            'section'     => 'expreso_fechas_options',
            'label'       => 'Formato de hora de Opinión',
            // 'description' => 'Ingrese el formato de fecha del header ',
            'input_attrs' => array(
                'placeholder' => __( 'j \d\e F \d\e Y' ),
            ),
        ) 
    );


}

function  wp_customize_alerts_config_expreso($wp_customize){
    // Text Options Section Inside Theme
    $wp_customize->add_section( 'expreso_alerta_options', 
        array(
            'title'         =>'Configuración de alerta' ,
            'description'   =>'Lista de la configuración de alerta.',
            'priority'      => 1,
            'panel'         => 'expreso_theme_config_options'
        ) 
    );

    // ###########################################################################################################

    // Settinf field
    $wp_customize->add_setting( 'expreso_alerta_activar_header',
        array(
            'default'           =>true,
            // 'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_alerta_activar_header', 
        array(
            'type'        => 'checkbox',
            'priority'    => 10,
            'section'     => 'expreso_alerta_options',
            'label'       => 'Activar alerta',
            // 'description' => 'Ingrese el formato de fecha del header ',
        ) 
    );


}

function  wp_customize_popup_config_expreso($wp_customize){
    // Text Options Section Inside Theme
    $wp_customize->add_section( 'expreso_popup_options', 
        array(
            'title'         =>'Configuración de popup' ,
            'description'   =>'Lista de la configuración de popup.',
            'priority'      => 1,
            'panel'         => 'expreso_theme_config_options'
        ) 
    );

    // ###########################################################################################################

    // Settinf field
    $wp_customize->add_setting( 'expreso_popup_activar_footer',
        array(
            'default'           =>true,
            // 'sanitize_callback' => 'expreso_sanitize_url',
            'transport'         => 'refresh',
        )
    );

    // Control field
    $wp_customize->add_control( 'expreso_popup_activar_footer', 
        array(
            'type'        => 'checkbox',
            'priority'    => 10,
            'section'     => 'expreso_popup_options',
            'label'       => 'Activar popup',
            // 'description' => 'Ingrese el formato de fecha del header ',
        ) 
    );


}