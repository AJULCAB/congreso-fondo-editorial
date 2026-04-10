<?php

// etiqueta de opinión Register Custom Taxonomy 
//function etiqueta_taxonomy() {
//	$args =tax_generate('Etiquetas',true,'');
//	register_taxonomy('opinion-tag',array('opinion'),$args);
//}
//add_action( 'init', 'etiqueta_taxonomy', 0 );

// columnista Register Custom Taxonomy 



// tags Register Custom Taxonomy 
// function post_tag_taxonomy() {
// 	$args =tax_generate('Etiqueta',true,'s');
// 	register_taxonomy('post_tag',array('blog','opinion',),$args);
// }
// add_action( 'init', 'post_tag_taxonomy', 0 );



// columnista Register Custom Taxonomy 
function cposts_autor_taxonomy() {
	$args =tax_generate('Autor',true,'');
	register_taxonomy('autor',array('post'),$args);
}
add_action( 'init', 'cposts_autor_taxonomy', 0 );
