<?php 
function expreso_delete_custom_transients() {
    // Verificar si el usuario está logueado
    if (!is_user_logged_in()) {
        // Redirigir al home si no está logueado
        wp_redirect(home_url());
        exit; // Asegúrate de detener la ejecución después de la redirección
    }
    
    // Llamar a la función para purgar la caché
    exp_purge_transients_cache();
    borrar_cache_w3_total_cache();
    //purge_nginx_cache();
    // Verificar el dominio actual
    $current_domain = $_SERVER['HTTP_HOST'];
    // Array de dominios permitidos
    $allowed_domains = ['www.congreso.gob.pe', 'congreso.gob.pe'];
    // Purgar la caché de Cloudflare solo si el dominio es correcto
    if (in_array($current_domain, $allowed_domains)) {
        // exp_purge_cloudflare_cache();
    }
    //exp_cache_regenerar_home();
}
// Eliminar transients al publicar un nuevo post
add_action('publish_post', 'expreso_delete_custom_transients');
add_action('edit_post', 'expreso_delete_custom_transients');
add_action('before_delete_post', 'expreso_delete_custom_transients');


function borrar_cache_w3_total_cache() {
    if (function_exists('w3tc_flush_all')) {
        // w3tc_flush_all();
        // Agregar un mensaje de éxito
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible">
                <p>W3 Total Cache:  ha sido limpiado exitosamente.</p>
            </div>';
        });
    } else {
        // Agregar un mensaje de error
        // add_action('admin_notices', function() {
        //     echo '<div class="notice notice-error is-dismissible">
        //         <p>W3 Total Cache: No se pudo eliminar la caché, Asegúrate de que el plugin esté activo.</p>
        //     </div>';
        // });
    }
}


function exp_purge_transients_cache() {
    global $wpdb;

    // Contar los transients que se van a eliminar
    $transients_count = $wpdb->get_var(
        "SELECT COUNT(*) FROM $wpdb->options WHERE option_name LIKE '%query_cache_%'"
    );

    // Ejecutar la eliminación
    $deleted_rows = $wpdb->query(
        "DELETE FROM $wpdb->options WHERE option_name LIKE '%query_cache_%'"
    );

    // Preparar el mensaje a mostrar
    if ($deleted_rows !== false) {
        if ($deleted_rows > 0) {
            $message = sprintf(__('Se han encontrado %d transients y se han eliminado %d de ellos.', 'text-domain'), $transients_count, $deleted_rows);
            add_action('admin_notices', function() use ($message) {
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($message) . '</p></div>';
            });
        } else {
            // $message = sprintf(__('Se encontraron %d transients, pero no se eliminaron ninguno.', 'text-domain'), $transients_count);
            // add_action('admin_notices', function() use ($message) {
            //     echo '<div class="notice notice-info is-dismissible"><p>' . esc_html($message) . '</p></div>';
            // });
        }
    } else {
        $message = __('Error al eliminar los transients de la caché.', 'text-domain');
        add_action('admin_notices', function() use ($message) {
            echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($message) . '</p></div>';
        });
    }
}



function exp_cache_regenerar_home() {
    // URL del home de la página
    $home_url = home_url();  // Obtiene la URL del home de WordPress
    // Configura la solicitud cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $home_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // Tiempo de espera en segundos
    // Ejecuta la solicitud
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // Verifica si hubo algún error
    if ($response === false || $http_code !== 200) {
        add_action('admin_notices', function() use ($ch) {
            $error_message = curl_error($ch) ?: 'Error al regenerar la caché del home.';
            echo '<div class="notice notice-error is-dismissible">';
            echo "<p>Caché home: Falló la regeneración de la caché del home: $error_message</p>";
            echo '</div>';
        });
    } else {
        // Éxito en la regeneración
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p>Caché home: Se ha regenerado exitosamente.</p>';
            echo '</div>';
        });
    }
    // Cierra la sesión cURL
    curl_close($ch);
}


// Función para añadir un elemento al menú superior en la barra de administración
function expreso_custom_admin_bar_menu_cache($wp_admin_bar) {
    // Obtener la URL actual
    $current_url = (is_ssl() ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    // Añadir el parámetro `clear_expreso_cache=true` a la URL actual
    $action_url = add_query_arg('clear_expreso_cache', 'true', $current_url);

    // Añadir un elemento al menú de administración
    $wp_admin_bar->add_node([
        'id'    => 'expreso_clear_cache',
        'title' => '<div><span class="dashicon-before"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></span> Limpiar Cache Congreso</div>',   // Título del enlace en el menú
        'href'  => esc_url($action_url),      // URL con el parámetro agregado
        'meta'  => [
            'title' => __('Limpiar la caché del Congreso'),  // Texto de tooltip
        ],
    ]);
}
add_action('admin_bar_menu', 'expreso_custom_admin_bar_menu_cache', 100);

// Función que se ejecuta cuando el parámetro está en la URL
function clear_expreso_cache_param() {
    // Verifica si el parámetro está en la URL y si el usuario tiene permisos
    if (isset($_GET['clear_expreso_cache']) && $_GET['clear_expreso_cache'] === 'true' && current_user_can('manage_options')) {
        // Lógica de la función PHP para limpiar la caché
        expreso_delete_custom_transients();
        // add_action('admin_notices', function() {
        //     echo '<div class="notice notice-success is-dismissible">';
        //     echo '<p>La caché del Congreso se ha limpiado con éxito.</p>';
        //     echo '</div>';
        // });
        // exp_cache_regenerar_home();

    }
}
add_action('admin_init', 'clear_expreso_cache_param');
