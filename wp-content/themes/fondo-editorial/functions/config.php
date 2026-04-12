<?php
if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

if (!defined('RECAPTCHA_KEY_PUB')) {
    define('RECAPTCHA_KEY_PUB', 'aaaaa');
}
if (!defined('RECAPTCHA_KEY_PRIV')) {
    define('RECAPTCHA_KEY_PRIV', 'aaaaa');
}

if (!defined('BREVO_API_URL')) {
    define('BREVO_API_URL', 'https://api.brevo.com/v3/');
}

if (!defined('BREVO_API_KEY')) {
    define('BREVO_API_KEY', 'aaaa');
}

if (!defined('BREVO_FOLDER_NAME')) {
    define('BREVO_FOLDER_NAME', 'DIARIO EXPRESO NEWSLETTER');
}

if (!defined('BREVO_LIST_NAME')) {
    define('BREVO_LIST_NAME', 'DIARIO EXPRESO - NEWSLETTER WEB');
}

function expreso_init_variable_post() {
  if( ! empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) &&  strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) == 'xmlhttprequest' ) {
      $posts_id_home = wp_cache_get( 'posts_id_home' );
      wp_cache_set( 'posts_id_home',($posts_id_home)?$posts_id_home:[]);

      $posts_tv_id_home = wp_cache_get( 'posts_tv_id_home' );
      wp_cache_set( 'posts_tv_id_home',($posts_tv_id_home)?$posts_tv_id_home:[]);

      $posts_id_single = wp_cache_get( 'posts_id_single' );
      wp_cache_set( 'posts_id_single',($posts_id_single)?$posts_id_single:[]);

      $posts_id_category = wp_cache_get( 'posts_id_category' );
      wp_cache_set( 'posts_id_category',($posts_id_category)?$posts_id_category:[]);

      $opinion_id_home = wp_cache_get( 'opinion_id_home' );
      wp_cache_set( 'opinion_id_home',($opinion_id_home)?$opinion_id_home:[]);

      $blog_id_home = wp_cache_get( 'blog_id_home' );
      wp_cache_set( 'blog_id_home',($blog_id_home)?$blog_id_home:[]);
  }else{
      wp_cache_set('posts_id_home',[]);
      wp_cache_set('posts_id_single',[]);
      wp_cache_set('posts_id_category',[]);
      wp_cache_set('opinion_id_home',[]);
      wp_cache_set('blog_id_home',[]);
      wp_cache_set('posts_tv_id_home',[]);
  }
}
// Start session on init hook.
add_action( 'init', 'expreso_init_variable_post' );

function expreso_set_sesion($name,$value,$array=false){
  if ($array) {
	  $values = wp_cache_get($name); 
	if (!is_array($values)) {
        $values=[];
      }
      array_push($values, $value);
      wp_cache_set($name,array_unique($values));
  }else{
      wp_cache_set($name,$value);
  }
}

function expreso_get_sesion($name){
  $value = wp_cache_get( $name );
  if ($value) {
     return $value;
  }
  return [];
}


