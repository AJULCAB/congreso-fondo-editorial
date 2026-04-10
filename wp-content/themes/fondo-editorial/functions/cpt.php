<?php 
/**
 *
 *  https://developer.wordpress.org/resource/dashicons/#cover-image
 * 
*/
// opinion
if (!function_exists('custom_post_type_opinion')) {
    // Register opinion
    function custom_post_type_opinion()
    {
        $name= 'Opinion';
        register_post_type('opinion', cpt_generate($name,array('post_tag'),'dashicons-editor-quote','es'));
    }
    add_action('init', 'custom_post_type_opinion', 4);

}



// blog
if (!function_exists('custom_post_type_blog')) {
    // Register blog
    function custom_post_type_blog()
    {
        $name= 'Blog';
        register_post_type('blog', cpt_generate($name,array('post_tag'),'dashicons-admin-site','s'));
    }
    add_action('init', 'custom_post_type_blog', 5);

}
