<?php
/**
 * Enqueue scripts and styles.
 */
function expreso_asset_version($relative_path)
{
    $asset_path = get_theme_file_path('assets/' . $relative_path);

    if (file_exists($asset_path)) {
        return (string) filemtime($asset_path);
    }

    return _S_VERSION;
}

function expreso_asset_exists($relative_path)
{
    return file_exists(get_theme_file_path('assets/' . $relative_path));
}

function labs_scripts()
{
    // wp_style_add_data( 'vyv-style', 'title', 'foo' );

    $array_url = array(
        'ajaxurl'          => admin_url('admin-ajax.php'),
        'redirection_home' => home_url(),
        'component_url' => home_url('component'),
        'img_placeholder' =>assets('img/default-placeholder.png'),
    );

    // Assets base que la plantilla necesita desde /assets.
    wp_register_style('theme-plugins', assets('css/plugins.css'), array(), expreso_asset_version('css/plugins.css'), 'all');
    wp_register_style('main', assets('css/main.css'), array('theme-plugins'), expreso_asset_version('css/main.css'), 'all');

    // COOKIES
    // wp_register_style('main', assets('css/main.min.css'), 'null', _S_VERSION, 'all');
    // wp_register_script('jquery-cookie', assets('vendor/jquery-cookie/jquery.cookie.js'), array('jquery'), '1.4.1', 'false');
    // wp_register_script('jquery-cookie-config', assets('js/cookie.config.min.js'), array('jquery'), _S_VERSION, 'false');



    // wp_register_style('aplayer', assets('vendor/aplayer-music/aplayer-music.min.css'), 'null', _S_VERSION, 'all');
    // wp_register_script('aplayer', assets('vendor/aplayer-music/aplayer-music.min.js'), array('jquery'), _S_VERSION, 'false');
    // wp_register_script('aplayer-config', assets('vendor/aplayer-music/aplayer-music-config.min.js'), array('jquery'), _S_VERSION, 'false');

    // Aplayer CSS como non-render-blocking
    // wp_enqueue_style('aplayer');
    // wp_style_add_data('aplayer', 'media', 'print');
    // wp_script_add_data('aplayer', 'strategy', 'defer');
    // wp_enqueue_script('aplayer');
    // wp_enqueue_script('aplayer-config');

    
    
    // wp_register_style('main', 'https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap', 'null', '', 'all');


    // <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">


    // INIT MAIN STYLES
    wp_enqueue_style('theme-plugins');

    wp_enqueue_script('theme-plugins', assets('js/plugins.js'), array('jquery'), expreso_asset_version('js/plugins.js'), array('in_footer' => true));
    wp_enqueue_script('theme-ajax-mail', assets('js/ajax-mail.js'), array('theme-plugins'), expreso_asset_version('js/ajax-mail.js'), array('in_footer' => true));
    // wp_script_add_data( 'g-maps', 'async', 'true' );

    
    wp_enqueue_style('main');
    wp_enqueue_script('main', assets('js/custom.js'), array('jquery', 'theme-plugins', 'theme-ajax-mail'), expreso_asset_version('js/custom.js'), array('in_footer' => true));

    if (expreso_asset_exists('js/alert.min.js')) {
        wp_enqueue_script('mainalert', assets('js/alert.min.js'), array('jquery'), expreso_asset_version('js/alert.min.js'), array('in_footer' => true));
    }

    
    wp_localize_script('main', 'array_url', $array_url);

    // wp_enqueue_style('pace');
    // wp_enqueue_script('pace');



    
    // 404  
    wp_register_style('page-404', assets('css/page-404.min.css'), 'null', _S_VERSION, 'all');
    if (is_404()) {
        # code...
        wp_enqueue_style('page-404');
    }


    // HOME  
    wp_register_style('home', assets('css/home.min.css'), 'null', _S_VERSION, 'all');

    if ( function_exists('is_woocommerce') && ( is_woocommerce() || is_shop() || is_product_category() ) ) {
        if ( expreso_asset_exists('js/shop.js') ) {
            wp_enqueue_script('shop', assets('js/shop.js'), array('jquery', 'main'), expreso_asset_version('js/shop.js'), array('in_footer' => true));
        }
    }

    if (is_front_page() || is_home()) {
        wp_enqueue_style('home');

        if (expreso_asset_exists('js/home.min.js')) {
            wp_enqueue_script('home', assets('js/home.min.js'), array('jquery'), expreso_asset_version('js/home.min.js'), array('in_footer' => true));
        }
    }



    if (is_front_page() || is_home() || is_singular('expresotv') || is_post_type_archive('expresotv') || is_tax('programas')) {
            if (expreso_asset_exists('js/lite-yt-embed.min.js')) {
                    wp_enqueue_script('lite-yt-embed', assets('js/lite-yt-embed.min.js'), array('jquery'), expreso_asset_version('js/lite-yt-embed.min.js'), array('in_footer' => true));
            }

            if (expreso_asset_exists('js/youtube.min.js')) {
                    wp_enqueue_script('youtube', assets('js/youtube.min.js'), array('jquery'), expreso_asset_version('js/youtube.min.js'), array('in_footer' => true));
            }
    }


    wp_register_style('fulltext', assets('css/fulltext.min.css'), 'null', _S_VERSION, 'all');
    if (is_page('nuestra-historia')) {
        wp_enqueue_style('fulltext');
    }

    // MAINCSS
    wp_enqueue_style('vyv-style', get_stylesheet_uri(), array(), _S_VERSION);

    
}
add_action('wp_enqueue_scripts', 'labs_scripts');

function expreso_theme_favicon()
{
    if (has_site_icon()) {
        return;
    }

    echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_url(assets('image/favicon.ico')) . '">' . "\n";
}
add_action('wp_head', 'expreso_theme_favicon', 5);






//Create a function to register the js files needed for your theme:
// if (!is_admin()){
//     add_action("wp_enqueue_scripts", "labs_scripts", 999);
// }

// Iniciar un buffer de salida para modificar Google Fonts y otros elementos de todo el head
function expreso_start_ob_header() {
    if (!is_admin()) {
        ob_start('expreso_optimize_html_output');
    }
}
function expreso_end_ob_header() {
    if (!is_admin()) {
        ob_end_flush();
    }
}
function expreso_optimize_html_output($html) {
    if (strpos($html, 'fonts.googleapis.com/css') !== false && strpos($html, 'display=') === false) {
        $html = str_replace('fonts.googleapis.com/css?', 'fonts.googleapis.com/css?display=swap&', $html);
    }
    return $html;
}
add_action('template_redirect', 'expreso_start_ob_header');

// Agrega font-display: swap a las fuentes de Google
function expreso_add_font_display_swap($html) {
    if (strpos($html, 'fonts.googleapis.com/css') !== false && strpos($html, 'display=') === false) {
        $html = str_replace('fonts.googleapis.com/css?', 'fonts.googleapis.com/css?display=swap&', $html);
    }
    return $html;
}
add_filter('style_loader_tag', 'expreso_add_font_display_swap');

if (!is_admin()){
	function add_defer_attribute($tag, $handle) {
        $exclude_defer = array(
            'jquery-core',
            'jquery',
            'theme-plugins',
            'theme-ajax-mail',
            'main',
            'slick',
            'home'
        );
        if (in_array($handle, $exclude_defer)) {
            return $tag;
        }
		return str_replace(' src', ' defer src', $tag);	
	}
	add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);
}



add_action( 'wp_head', 'wp_head_insert_preload', 1);
function wp_head_insert_preload()
{
    global $wp_scripts;
    global $wp_styles;
    $htm_insert='';
    
    // foreach ($wp_styles->queue as $handle) {
    //     $style = $wp_styles->registered[$handle];
    //     // if (isset($style->extra['group']) && $style->extra['group'] === 1) {
    //         $source = $style->src . ($style->ver ? "?ver={$style->ver}" : "");
    //         $htm_insert.= "<link rel='preload' href='{$source}' as='style' onload='this.rel = \"stylesheet\"'/>\n
	// 		<noscript><link rel='stylesheet' href='{$source}'/></noscript>\n";
    //     // }
    // }

    // foreach ($wp_scripts->queue as $handle) {
    //     $script = $wp_scripts->registered[$handle];
    //     //-- Check if script is being enqueued in the footer.
    //     if (isset($script->extra['group'] ) && $script->extra['group'] === 1) {
    //         //-- If version is set, append to end of source.
    //         $source = $script->src . ($script->ver ? "?ver={$script->ver}" : "");
    //         //-- Spit out the tag.
    //         $htm_insert.= "<link rel='preload' href='{$source}' as='script'/>\n";
    //     }
    // }

    // <meta http-equiv='x-dns-prefetch-control' content='on'>
    // <link rel='preconnect' href='//ajax.googleapis.com'>
    // <link rel='dns-prefetch' href='https://fonts.gstatic.com'>
    // <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin='anonymous'>
    // <link rel='dns-prefetch' href='https://use.fontawesome.com'>
    // <link rel='preconnect' href='https://use.fontawesome.com' crossorigin>
    // <link rel='preconnect' href='//cdnjs.cloudflare.com'>
    // <link rel='preconnect' href='//www.googletagmanager.com'>
    // <link rel='preconnect' href='//www.google-analytics.com'>
    // <link rel='preconnect' href='//mc.yandex.ru'>
    // <link rel='preconnect' href='//cdn.bitrix24.ru'>
    // <link rel='preconnect' href='//bitrix.info'>
    // <link rel='dns-prefetch' href='//connect.facebook.net'>

    // <link rel='preload' as='script' href='https://cdn.ampproject.org/v0.js'>
    // <link rel='preload' as='script' href='https://cdn.ampproject.org/v0/amp-experiment-0.1.js'>
    // <link rel='preconnect dns-prefetch' href='https://fonts.gstatic.com/' crossorigin>

    $htm_insert.= "<meta http-equiv='x-dns-prefetch-control' content='on'>\n";

    // Reserva espacio para el banner de consentimiento de Clickio CMP ANTES de que
    // su script modifique el body, eliminando el CLS de 0.248 detectado en PageSpeed.
    // Clickio añade .clickio-cmp-out-of-scope al body y empuja el contenido.
    // Este bloque inline garantiza que el layout ya cuente con ese espacio desde el inicio.
    if (!is_amp()) {
        $htm_insert.= "<style>body.clickio-cmp-out-of-scope > *:first-child { margin-top: 0 !important; } .cli-bar-container, #cookie-law-info-bar { min-height: 0; contain: layout; }</style>\n";
    }
    // $htm_insert.= "<link rel='preconnect' href='//mc.yandex.ru'>\n";
    // $htm_insert.= "<link rel='dns-prefetch' href='//connect.facebook.net'>\n";
    // $htm_insert.= "<link rel='preconnect' href='//www.googletagmanager.com'>\n";
    // $htm_insert.= "<link rel='preconnect' href='//www.google-analytics.com'>\n";

    // $htm_insert.= "<link rel='preconnect' href='https://fonts.googleapis.com'>\n";
    // $htm_insert.= "<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>\n";



    
    


    // $htm_insert.= "<link rel='preload' as='script' href='https://cdn.ampproject.org/v0.js'>\n";
    


    if (is_front_page() || is_home()) {
        // Fuentes críticas usadas en above-the-fold (rutas reales confirmadas)
        $htm_insert.= "<link rel='preload' as='font' type='font/woff2' href='".assets('fonts/roboto/Roboto-Bold.woff2')."' crossorigin='anonymous'>\n";
        $htm_insert.= "<link rel='preload' as='font' type='font/woff2' href='".assets('fonts/roboto/Roboto-Regular.woff2')."' crossorigin='anonymous'>\n";
        $htm_insert.= "<link rel='preload' as='font' type='font/woff2' href='".assets('fonts/roboto/Roboto-Light.woff2')."' crossorigin='anonymous'>\n";
        $htm_insert.= "<link rel='preload' as='font' type='font/woff2' href='".assets('fonts/roboto/Roboto-Medium.woff2')."' crossorigin='anonymous'>\n";
        $htm_insert.= "<link rel='preload' as='font' type='font/woff' href='".assets('fonts/seravek/seravek-light.woff')."' crossorigin='anonymous'>\n";
        $htm_insert.= "<link rel='preload' as='font' type='font/woff' href='".assets('fonts/seravek/seravek-bold.woff')."' crossorigin='anonymous'>\n";

        // Preload imagen LCP (portada slider): extraída dinámicamente de la primera
        // noticia destacada para que el browser scanner la descubra en el HTML inicial
        $lcp_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_query'     => array(array(
                'key'     => 'destacado_en_portada',
                'value'   => true,
                'compare' => '==',
            )),
        ));
        if (!empty($lcp_query->posts)) {
            $lcp_img = thumbnail($lcp_query->posts[0], 'full', true);
            if ($lcp_img) {
                $lcp_img = esc_url($lcp_img);
                $htm_insert.= "<link rel='preload' as='image' fetchpriority='high' href='{$lcp_img}'>\n";
            }
        }
    }

    if (is_single() && is_post_type('proyectos-venta')) {
        
        
        // $htm_insert.= "<link rel='preconnect dns-prefetch' href='//fonts.gstatic.com/' crossorigin>\n";
        // // $htm_insert.= "<link rel='preconnect' href='https://maps.googleapis.com' crossorigin>\n";
        // $htm_insert.= "<link rel='preload' as='font' href='".assets('fonts/roboto/roboto-light/roboto-light.woff2')."' crossorigin >\n";
        // $htm_insert.= "<link rel='preload' as='font' href='".assets('fonts/roboto/roboto-bold/roboto-bold.woff2')."' crossorigin >\n";
        // $htm_insert.= "<link rel='preload' as='font' href='".assets('fonts/roboto/roboto-regular/roboto-regular.woff2')."' crossorigin >\n";
        // $htm_insert.= "<link rel='preload' as='font' href='".assets('fonts/roboto/roboto-medium/Roboto-Medium.woff2')."' crossorigin >\n";
        // $htm_insert.= "<link rel='preload' as='font' href='https://fonts.gstatic.com/s/roboto/v27/KFOmCnqEu92Fr1Mu4mxKKTU1Kg.woff2' crossorigin >\n";
        
    }
    
    //This is the code to preload webfonts
    
    // echo "<link rel='preload' href='/wp-content/themes/salient/css/fonts/fontawesome-webfont.ttf?v=4.2' type='font/ttf'>";
    
    echo $htm_insert;
    
}
