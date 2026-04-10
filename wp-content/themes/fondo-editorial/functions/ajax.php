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