<?php

function expreso_shortcode_subpaginas_actuales( $atts ) {
	$atts = shortcode_atts(
		array(
			'parent_id'  => 0,
			'class'      => 'sidebar-menu--shop',
			'show_count' => 'false',
			'orderby'    => 'menu_order title',
			'order'      => 'ASC',
			'custom_links' => '',
		),
		$atts,
		'subpaginas_actuales'
	);

	$parent_id = absint( $atts['parent_id'] );
	$children  = array();
	$custom_links = array();

	if ( ! empty( $atts['custom_links'] ) ) {
		$raw_links = preg_split( '/\s*;\s*/', (string) $atts['custom_links'] );

		foreach ( $raw_links as $raw_link ) {
			if ( '' === trim( $raw_link ) ) {
				continue;
			}

			$link_parts = array_map( 'trim', explode( '|', $raw_link, 2 ) );

			if ( empty( $link_parts[0] ) ) {
				continue;
			}

			$custom_links[] = array(
				'label' => $link_parts[0],
				'url'   => ! empty( $link_parts[1] ) ? $link_parts[1] : '#',
			);
		}
	}

	if ( ! $parent_id && is_page() ) {
		$parent_id = get_queried_object_id();
	}

	if ( $parent_id ) {
		$children = get_pages(
			array(
				'child_of'    => $parent_id,
				'parent'      => $parent_id,
				'sort_column' => sanitize_text_field( $atts['orderby'] ),
				'sort_order'  => 'DESC' === strtoupper( $atts['order'] ) ? 'DESC' : 'ASC',
				'post_status' => 'publish',
			)
		);
	}

	if ( empty( $children ) && empty( $custom_links ) ) {
		return '';
	}

	$show_count = filter_var( $atts['show_count'], FILTER_VALIDATE_BOOLEAN );
	$classes    = implode(
		' ',
		array_filter(
			array_map( 'sanitize_html_class', preg_split( '/\s+/', (string) $atts['class'] ) )
		)
	);

	ob_start();
	?>
	<ul class="pl--0 pr--0 <?php echo esc_attr( $classes ? $classes : 'sidebar-menu--shop' ); ?>">
		<?php foreach ( $children as $child_page ) : ?>
			<li>
				<a href="<?php echo esc_url( get_permalink( $child_page->ID ) ); ?>">
					<?php echo esc_html( get_the_title( $child_page->ID ) ); ?>
					<?php if ( $show_count ) : ?>
						<?php $grandchildren = get_pages( array( 'parent' => $child_page->ID, 'post_status' => 'publish' ) ); ?>
						<span>(<?php echo esc_html( count( $grandchildren ) ); ?>)</span>
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; ?>
		<?php foreach ( $custom_links as $custom_link ) : ?>
			<li>
				<a href="<?php echo esc_url( $custom_link['url'] ); ?>">
					<?php echo esc_html( $custom_link['label'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php

	return ob_get_clean();
}
add_shortcode( 'subpaginas_actuales', 'expreso_shortcode_subpaginas_actuales' );


// [subpaginas_actuales]
// [subpaginas_actuales show_count="true"]
// [subpaginas_actuales parent_id="123" class="sidebar-menu--shop menu-type-2"]
// [subpaginas_actuales custom_links="Contacto|/contacto/;Catalogo|/catalogo/"]
