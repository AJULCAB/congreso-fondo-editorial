<?php
$sidebar_id = '';

if ( isset( $args['sidebar_id'] ) ) {
	$sidebar_id = sanitize_key( (string) $args['sidebar_id'] );
}

if ( ! $sidebar_id ) {
	if ( is_active_sidebar( 'blog_sidebar' ) ) {
		$sidebar_id = 'blog_sidebar';
	} elseif ( is_active_sidebar( 'post_sidebar' ) ) {
		$sidebar_id = 'post_sidebar';
	}
}

$show_search         = ! isset( $args['show_search'] ) || (bool) $args['show_search'];
$show_pages_fallback = ! isset( $args['show_pages_fallback'] ) || (bool) $args['show_pages_fallback'];
?>
<aside class="inner-page-sidebar">
	<?php if ( $show_search ) : ?>
		<div class="single-block">
			<form class="site-mini-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" name="s" placeholder="Buscar" value="<?php echo esc_attr( get_search_query() ); ?>">
				<button type="submit"><i class="fas fa-search"></i></button>
			</form>
		</div>
	<?php endif; ?>

	<?php if ( $sidebar_id ) : ?>
		<?php dynamic_sidebar( $sidebar_id ); ?>
	<?php elseif ( $show_pages_fallback ) : ?>
		<div class="single-block">
			<h2 class="sidebar-title mb--30">Páginas</h2>
			<ul class="sidebar-list mb--30">
				<?php
				wp_list_pages(
					array(
						'title_li' => '',
						'depth'    => 1,
					)
				);
				?>
			</ul>
		</div>
	<?php endif; ?>
</aside>
