<?php 

function filtrar_busqueda_por_titulos_tags_contenido($search, $query) {
  global $wpdb;

  // Verificar si es una búsqueda y si no estamos en el admin
  if (!is_admin() && $query->is_search() && $query->is_main_query()) {
      // Obtener el término de búsqueda
      $search_term = $query->get('s');

      // Si no hay un término de búsqueda, retorna el comportamiento predeterminado
      if (empty($search_term)) {
          return $search;
      }

      // Limitar la búsqueda a título, etiquetas y contenido
      $search = $wpdb->prepare(
          " AND (
              {$wpdb->posts}.post_title LIKE %s
              OR {$wpdb->posts}.post_content LIKE %s
              OR EXISTS (
                  SELECT 1
                  FROM {$wpdb->term_relationships} tr
                  INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                  INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
                  WHERE tt.taxonomy = 'post_tag'
                  AND tr.object_id = {$wpdb->posts}.ID
                  AND t.name LIKE %s
              )
          )",
          '%' . $wpdb->esc_like($search_term) . '%',
          '%' . $wpdb->esc_like($search_term) . '%',
          '%' . $wpdb->esc_like($search_term) . '%'
      );
  }

  return $search;
}

//add_filter('posts_search', 'filtrar_busqueda_por_titulos_tags_contenido', 10, 2);

