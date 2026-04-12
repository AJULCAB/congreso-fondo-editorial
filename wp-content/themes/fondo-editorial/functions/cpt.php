<?php 
/**
 *
 *  https://developer.wordpress.org/resource/dashicons/#cover-image
 * 
*/
// notas_prensa
if (!function_exists('custom_post_type_notas_prensa')) {
    // Register notas_prensa
    function custom_post_type_notas_prensa()
    {
        $name= 'Notas de Prensa';
        register_post_type('notas_prensa', cpt_generate($name,array('post_tag'),'dashicons-editor-quote',''));
    }
    add_action('init', 'custom_post_type_notas_prensa', 4);

}



// video
if (!function_exists('custom_post_type_video')) {
    // Register video
    function custom_post_type_video()
    {
        $name= 'Video';
        register_post_type('video', cpt_generate($name,array('post_tag'),'dashicons-admin-site','s'));
    }
    add_action('init', 'custom_post_type_video', 5);

}

// libro
// if (!function_exists('custom_post_type_libro')) {
//     // Register libro
//     function custom_post_type_libro()
//     {
//         $name= 'Libro';
//         register_post_type('libro', cpt_generate($name,array('post_tag'),'dashicons-admin-site','s'));
//     }
//     add_action('init', 'custom_post_type_libro', 5);

// }
