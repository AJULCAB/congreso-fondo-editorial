<?php 

function create_static_post($post_id,$contents){
    $slug=get_post_slug($post_id);
    if ($slug) {
        $categories = get_the_category($post_id);
        if (!empty($categories)) {
            $category = $categories[0];
            $category_slug = $category->slug;
            $archivoHTML = ABSPATH ."static/{$category_slug}/{$slug}/index.html";
        }else{
            $archivoHTML = ABSPATH ."static/{$slug}/index.html";
        }
        exp_create_static_file($archivoHTML,$contents);
    }
    

}

function create_static_category($cat_id,$contents){
    $category = get_category( $cat_id );
    if ($category && !is_wp_error($category)) {
        $archivoHTML = ABSPATH ."static/{$category->slug}/index.html";
        exp_create_static_file($archivoHTML,$contents);
    }
    
}

function create_static_tag($tag_id,$contents){
    $tag = get_term($tag_id, 'post_tag');
    if ($tag && !is_wp_error($tag)) {
        // var_dump($tag); exit;
        $archivoHTML = ABSPATH ."static/tag/{$tag->slug}/index.html";
        exp_create_static_file($archivoHTML,$contents);
    }
    
}

function create_static_cpt($cpt,$contents){
    $archivoHTML = ABSPATH ."static/{$cpt}/index.html";
    exp_create_static_file($archivoHTML,$contents);
    
}

function create_static_cpt_single($cpt,$post_id,$contents){
    $slug=get_post_slug($post_id);
    if ($slug) {
        $archivoHTML = ABSPATH ."static/{$cpt}/{$slug}/index.html";
        exp_create_static_file($archivoHTML,$contents);
    }
   
}

function create_static_cpt_home($contents){
    $archivoHTML = ABSPATH ."static/index.html";
    exp_create_static_file($archivoHTML,$contents);
}

function create_static_cpt_page($page,$contents){
    $archivoHTML = ABSPATH ."static/{$page}/index.html";
    exp_create_static_file($archivoHTML,$contents);
}

function create_static_taxonomy($tax,$term_id,$contents){
    $term = get_term($term_id, $tax);
    if ($term && !is_wp_error($term)) {
        $archivoHTML = ABSPATH ."static/{$tax}/{$term->slug}/index.html";
        exp_create_static_file($archivoHTML,$contents);
    }
    
}

function create_static_component($path,$contents){
    $archivoHTML = ABSPATH ."static/components/{$path}/index.html";
    exp_create_static_file($archivoHTML,$contents);
    
}

/*

static_prefix
api_prefix

CREAR POST
http://expresofile.dev/actualidad/sicarios-contratados-por-wanda-del-valle-estan-planificando-atentado-contra-coronel-revoredo-revela-informe-policial-peru-venezuela-pnp-tren-de-aragua-noticia/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev

http://expresofile.dev/politica/victor-garcia-toma-representara-al-peru-ante-la-onu-manuel-rodriguez-cuadros-noticia/?static_gen=1&assets_prefix=http://expresofile.dev&content_flush=1&media_prefix=https://expresofile.dev&metadata_output=1

CREAR CATEGORÍA
http://expresofile.dev/actualidad/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev

CREAR TAGS
http://expresofile.dev/tag/noticias-expreso/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev



CREAR OPINIONES
https://expresofile.dev/opinion/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev

CREAR OPINION
http://expresofile.dev/opinion/asdasd/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev

CREAR COLUMNISTA
http://expresofile.dev/columnista/columnista-1/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev


CREAR BLOGS
http://expresofile.dev/blog/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev

CREAR BLOG
http://expresofile.dev/blog/blog-ejemplo-1/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev

CREAR BLOGUERO
http://expresofile.dev/bloguero/bloguero-1/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev


CREAR EXPRESO TV
http://expresofile.dev/expreso-tv/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev



CHEAR HOME
http://expresofile.dev/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev


COMPONENTS

http://expresofile.dev/component/?type=widget&content=wnoticias&static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev

http://expresofile.dev/component/?type=widget&content=wblog&static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev


RESPONSE JSON
http://expresofile.dev/actualidad/sicarios-contratados-por-wanda-del-valle-estan-planificando-atentado-contra-coronel-revoredo-revela-informe-policial-peru-venezuela-pnp-tren-de-aragua-noticia/?static_gen=1&assets_prefix=https://assets.expreso.dev&content_flush=1&media_prefix=https://uploads.expreso.dev&metadata_output=1
    


*/

function get_post_slug($post_id){
    $permalink = get_permalink($post_id);
    return  basename($permalink);
}
function exp_is_url($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}
function exp_url_is_slash_clean($url) {
    $last = substr($url, -1);
    if ($last === '/') {
        $url = substr($url, 0, -1);
    }
    return $url;
}
function exp_create_static_file($path,$contents){
    // Obtiene la ruta de carpetas (directorio) de $archivoHTML
    $rutaDeCarpetas = dirname($path);
    // Asegurarse de que la carpeta exista; si no existe, créala
    if (!file_exists($rutaDeCarpetas)) {
        if (!mkdir($rutaDeCarpetas, 0775, true)) {
            //die("Error al crear la carpeta $carpeta");
        }
    }
    // Almacena el búfer de salida en un archivo .html
    file_put_contents($path, $contents);

    exp_response_statis_file($path, $contents);

}
function exp_response_statis_file($path, $contents){
    $folder=dirname($path);
    $route=str_replace(ABSPATH,'',$folder);
    $metadata_output=isset($_GET['metadata_output'])?$_GET['metadata_output']:0;

    if (is_exp_flush()) {
        ob_end_clean();
    }else{
        ob_end_flush();
    }
    if ($metadata_output==1 && is_exp_flush()) {
        $array_response=[
            'metadata_output'=>isset($_GET['metadata_output'])?$_GET['metadata_output']:0,
            'static_gen'=>isset($_GET['static_gen'])?$_GET['static_gen']:0,
            'assets_prefix'=>isset($_GET['assets_prefix'])?$_GET['assets_prefix']:'',
            'content_flush'=>isset($_GET['content_flush'])?$_GET['content_flush']:0,
            'media_prefix'=>isset($_GET['media_prefix'])?$_GET['media_prefix']:'',
            'folder'=>dirname($path),
            'url'=>home_url($route),
            // 'route'=>"/{$route}",
            'path'=>$path,
            'sha_256'=>hash('sha256', $contents),
            'ts'=>date(DATE_RFC3339),
        ];
        wp_send_json($array_response);
    }
    
    // "url": "https://todo-el-url",

}
function is_exp_static(){
    return (isset($_GET['static_gen']) && $_GET['static_gen']==1);
}
function is_exp_flush(){
    return isset($_GET['content_flush']) && $_GET['content_flush']==1;
}
function get_exp_static_assets_prefix(){
    return (isset($_GET['assets_prefix']) && exp_is_url($_GET['assets_prefix'])) ?exp_url_is_slash_clean($_GET['assets_prefix']):'';
}
function get_exp_static_media_prefix(){
    return (isset($_GET['media_prefix']) && exp_is_url($_GET['media_prefix'])) ?exp_url_is_slash_clean($_GET['media_prefix']):'';
}



// static_gen=1&
// assets_prefix=https://assets.expreso.dev&
// content_flush=1&
// media_prefix=https://uploads.expreso.dev 