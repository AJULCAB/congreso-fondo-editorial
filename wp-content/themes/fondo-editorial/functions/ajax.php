<?php

function f_ajax_expreso_responder_encuesta()
{

    //init ajax
    $ajax = false;
    //check ajax call or not
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        $ajax = true;
    }

    $data_p = $_POST;
    $data   = array(
        'id'   => @$data_p['id'],
        'valor'   => @$data_p['valor'],
    );

    if ($data['id']) {
        $items_de_respuesta = get_field('items_de_respuesta',$data['id']);
        if ($items_de_respuesta ) {
            // arsort($items_de_respuesta);

            $repeater_key = 'field_625ae399a0c24';
            $value = [];
            $suma=0;
            foreach ($items_de_respuesta as $key => $item) {
                if ($item['item']==$data['valor']) {
                    $value[] = array(
                        'field_625ae3f6a0c25' => $item['item'],
                        'field_625ae438a0c26' => $item['contador_de_respuestas']+1
                    );
                    $suma+=$item['contador_de_respuestas']+1;
                }else{
                    $value[] = array(
                        'field_625ae3f6a0c25' => $item['item'],
                        'field_625ae438a0c26' => $item['contador_de_respuestas']
                    );
                    $suma+=$item['contador_de_respuestas'];
                }
                
            }
            update_field($repeater_key, $value, $data['id']);
            get_template_part('components/shortcode/shortcode','encuesta-respuesta',[
                'id'=>$data['id'],
                'suma_items'=>$suma
            ]);
            // echo json_encode($value);exit;   
        }else{
            wp_send_json(array(
                'status'  => 'error',
                'message' => 'No hay items encontrados',
            ), 400);
        }

        // wp_send_json(array(
        //     'status'  => 'success',
        //     'message' => '',

        // ), 200);
    } else {
        //something gone wrong
        wp_send_json(array(
            'status'  => 'error',
            'message' => 'Error de conexión',
        ), 400);
    }
    //reset post data
    wp_reset_postdata();
    //check ajax call
    if ($ajax) {
        die();
    }

    // ajax_script_load_more($_POST);
}
add_action('wp_ajax_expreso_responder_encuesta', 'f_ajax_expreso_responder_encuesta');
add_action('wp_ajax_nopriv_expreso_responder_encuesta', 'f_ajax_expreso_responder_encuesta');





add_action('wp_ajax_nopriv_columnista_search', 'f_columnista_search');
add_action('wp_ajax_columnista_search', 'f_columnista_search');

function f_columnista_search(){
    //init ajax
    $ajax = false;
    //check ajax call or not
    if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        $ajax = true;
    }

    if ($ajax) {
        # code...
        $data_p = $_POST;
        $text=@$data_p['text'];

        $args = array(
            'taxonomy'      => array( 'columnistas' ), // taxonomy name
            'orderby'       => 'id', 
            'order'         => 'ASC',
            'hide_empty'    => true,
            'fields'        => 'all',
            'name__like'    => $text
        ); 
        
        $columnistas = get_terms( $args );
        $columnistas_array = [];

        foreach ($columnistas as $key => $col) {
            # code...

            $columnistas_array[]=[
                'name'=>$col->name,
                'image'=>image_auto_url(get_field('foto_de_columnista',$col)),
                'url'=>get_term_link( $col )
            ];
        }

        if (count($columnistas_array)>0) {
            # code...
            wp_send_json(array(
                'status'  => 'error',
                'message' => 'Resultado de búsqueda de productos',
                'data'=>$columnistas_array
            ), 200);
        }else{
            wp_send_json(array(
                'status'  => 'error',
                'message' => 'No hay productos',
            ), 400);
        }
        

    } else {
        # code...
        wp_send_json(array(
            'status'  => 'error',
            'message' => 'Petición no autorizada',
        ), 400);
    }

    //reset post data
    wp_reset_postdata();
    //check ajax call
    if ($ajax) {
        die();
    }
}
add_action('wp_ajax_filter_products_by_price', 'f_filter_products_by_price');
add_action('wp_ajax_nopriv_filter_products_by_price', 'f_filter_products_by_price');

function f_filter_products_by_price() {
    $min_price = isset($_POST['min_price']) ? floatval($_POST['min_price']) : 0;
    $max_price = isset($_POST['max_price']) ? floatval($_POST['max_price']) : 1000;
    $term_id = isset($_POST['term_id']) ? intval($_POST['term_id']) : 0;
    $author_slug = isset($_POST['autor_filtro'])
        ? sanitize_title( wp_unslash( $_POST['autor_filtro'] ) )
        : ( isset($_POST['autor']) ? sanitize_title( wp_unslash( $_POST['autor'] ) ) : '' );
    $format_slug = isset($_POST['formato']) ? sanitize_title( wp_unslash( $_POST['formato'] ) ) : '';
    $author_taxonomy = taxonomy_exists('pa_autor') ? 'pa_autor' : ( taxonomy_exists('autor') ? 'autor' : '' );

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 9,
        'paged' => 1,
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
        )
    );

    if ($term_id > 0) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $term_id
            )
        );
    }

    if ( $author_slug && $author_taxonomy ) {
        if ( empty( $args['tax_query'] ) ) {
            $args['tax_query'] = array();
        }

        $args['tax_query'][] = array(
            'taxonomy' => $author_taxonomy,
            'field'    => 'slug',
            'terms'    => array( $author_slug )
        );
    }

    if ( $format_slug && taxonomy_exists('pa_formato') ) {
        if ( empty( $args['tax_query'] ) ) {
            $args['tax_query'] = array();
        }

        $args['tax_query'][] = array(
            'taxonomy' => 'pa_formato',
            'field'    => 'slug',
            'terms'    => array( $format_slug )
        );
    }

    if ( ! empty( $args['tax_query'] ) && count( $args['tax_query'] ) > 1 ) {
        $args['tax_query']['relation'] = 'AND';
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            echo '<div class="col-lg-4 col-sm-6">';
            get_template_part('components/card/card', 'product', array('id' => $product->get_id()));
            echo '</div>';
        }
    } else {
        echo '<p class="woocommerce-info">No se encontraron productos que concuerden con la selección.</p>';
    }
    $html = ob_get_clean();

    ob_start();
    $total_pages = $query->max_num_pages;
    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));
        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text' => '&larr;',
            'next_text' => '&rarr;'
        ));
    }
    $pagination = ob_get_clean();

    wp_send_json_success(array('html' => $html, 'pagination' => $pagination));
}
