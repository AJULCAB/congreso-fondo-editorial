<?php
get_header();

global $wp_query;

$expreso_page_sidebar = '';

if (is_active_sidebar('blog_sidebar')) {
  $expreso_page_sidebar = 'blog_sidebar';
} elseif (is_active_sidebar('post_sidebar')) {
  $expreso_page_sidebar = 'post_sidebar';
}

$search_term   = get_search_query();
$total_results = (int) $wp_query->found_posts;
$current_page  = max( 1, get_query_var( 'paged' ) );
$shop_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

$get_result_type_label = static function( $post_id ) {
	$post_type = get_post_type( $post_id );
	$post_type_labels = array(
		'product' => 'Producto',
		'page'    => 'Pagina',
		'post'    => 'Noticia',
		'video'   => 'Video',
	);

	if ( isset( $post_type_labels[ $post_type ] ) ) {
		return $post_type_labels[ $post_type ];
	}

	$post_type_object = get_post_type_object( $post_type );

	if ( $post_type_object && ! empty( $post_type_object->labels->singular_name ) ) {
		return $post_type_object->labels->singular_name;
	}

	return 'Contenido';
};

$get_result_date = static function( $post_id ) {
    $date = get_the_date( 'd/m/Y', $post_id );

    return $date ? $date : '';
};
?>

<section class="breadcrumb-section">
	<h2 class="sr-only">Breadcrumb</h2>
	<div class="container">
		<div class="breadcrumb-contents">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
					<li class="breadcrumb-item active" aria-current="page">Búsqueda</li>
				</ol>
			</nav>
		</div>
	</div>
</section>
<section class="inner-page-sec-padding-bottom search-results-page">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 mb--40 mb-lg--0">
				<div class="search-results-heading mb--30">
					<h1 class="mb--10">
						<?php if ( $search_term ) : ?>
							Resultados para "<?php echo esc_html( $search_term ); ?>"
						<?php else : ?>
							Búsqueda
						<?php endif; ?>
					</h1>
					<p class="post-meta mb--0">
						<span><?php echo esc_html( $total_results ); ?> resultado<?php echo 1 !== $total_results ? 's' : ''; ?></span>
					</p>
				</div>

				<?php if ( have_posts() ) : ?>
					<div class="blog-list-cards">
						<?php while ( have_posts() ) : the_post(); ?>
							<article <?php post_class( 'blog-card card-style-list search-result-card' ); ?>>
								<div class="row w-100">
									<div class="col-md-3">
										<a href="<?php the_permalink(); ?>" class="image d-block">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-100' ) ); ?>
											<?php else : ?>
												<img src="<?php echo esc_url( assets( 'image/default-placeholder.jpg' ) ); ?>" alt="<?php the_title_attribute(); ?>" class="w-100">
											<?php endif; ?>
										</a>
									</div>
									<div class="col-md-9">
										<div class="card-content">
											<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<p class="post-meta">
												<?php if ( $get_result_date( get_the_ID() ) ) : ?>
													<span><?php echo esc_html( $get_result_date( get_the_ID() ) ); ?></span>
													| 
												<?php endif; ?>
												<span><?php echo esc_html( $get_result_type_label( get_the_ID() ) ); ?></span>
											</p>
											<article>
												<h2 class="sr-only">Resultado de búsqueda</h2>
												<p><?php echo esc_html( wp_trim_words( get_the_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_strip_all_tags( get_the_content() ), 28 ) ); ?></p>
												<a href="<?php the_permalink(); ?>" class="blog-link">Ver detalle</a>
											</article>
										</div>
									</div>
								</div>
							</article>
						<?php endwhile; ?>
					</div>

					<?php if ( $wp_query->max_num_pages > 1 ) : ?>
						<div class="row pt--30">
							<div class="col-md-12">
								<div class="pagination-block bg--white search-results-pagination">
									<?php
									echo wp_kses_post(
										paginate_links(
											array(
												'total'     => $wp_query->max_num_pages,
												'current'   => $current_page,
												'prev_text' => '&larr;',
												'next_text' => '&rarr;',
											)
										)
									);
									?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<p class="woocommerce-info">No se encontraron resultados para tu búsqueda.</p>
				<?php endif; ?>
			</div>

            <div class="col-lg-3">
				<aside class="inner-page-sidebar">
					<div class="single-block">
						<!-- <h2 class="sidebar-title mb--30">Buscar de nuevo</h2> -->
						<form class="site-mini-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" name="s" placeholder="Buscar" value="<?php echo esc_attr( $search_term ); ?>">
							<button type="submit"><i class="fas fa-search"></i></button>
						</form>
					</div>

					<?php if ($expreso_page_sidebar) : ?>
                        <?php dynamic_sidebar($expreso_page_sidebar); ?>
                    <?php else : ?>
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
			</div>
		</div>
	</div>
</section>

<?php
wp_reset_postdata();
get_footer();
?>
