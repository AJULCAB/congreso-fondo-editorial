<?php

// etiqueta de opinión Register Custom Taxonomy 
//function etiqueta_taxonomy() {
//	$args =tax_generate('Etiquetas',true,'');
//	register_taxonomy('opinion-tag',array('opinion'),$args);
//}
//add_action( 'init', 'etiqueta_taxonomy', 0 );

// columnista Register Custom Taxonomy 



// tags Register Custom Taxonomy 
function post_categorias_video_taxonomy() {
	$args =tax_generate('Categorías de video',true,'');
	register_taxonomy('categorias_video',array('video',),$args);
}
add_action( 'init', 'post_categorias_video_taxonomy', 0 );



// // tags Register Custom Taxonomy 
// function post_categorias_libro_taxonomy() {
// 	$args =tax_generate('Categorías de libro',true,'');
// 	register_taxonomy('categorias_libro',array('libro',),$args);
// }
// add_action( 'init', 'post_categorias_libro_taxonomy', 0 );



// columnista Register Custom Taxonomy 
function cposts_autor_taxonomy() {
	$args =tax_generate('Autor',true,'');
	register_taxonomy('autor',array('post'),$args);
}
add_action( 'init', 'cposts_autor_taxonomy', 0 );

