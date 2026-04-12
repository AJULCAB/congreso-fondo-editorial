<?php
get_header();

$archive_title = post_type_archive_title( '', false );
$video_terms   = get_terms(
	array(
		'taxonomy'   => 'categorias_video',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);
?>
<section class="breadcrumb-section">
	<h2 class="sr-only">Site Breadcrumb</h2>
	<div class="container">
		<div class="breadcrumb-contents">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo esc_html( $archive_title ); ?></li>
				</ol>
			</nav>
		</div>
	</div>
</section>
<section class="inner-page-sec-padding-bottom search-results-page video-archive-page">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 mb--40 mb-lg--0">
				<div class="search-results-headings mb--30">
					<h1 class="mb--10"><?php echo esc_html( $archive_title ); ?></h1>
					<p class="post-meta mb--0">
						<span><?php echo esc_html( is_array( $video_terms ) ? count( $video_terms ) : 0 ); ?> categorias</span>
					</p>
				</div>

				<?php if ( ! is_wp_error( $video_terms ) && ! empty( $video_terms ) ) : ?>
					<div class="blog-list-cards">
						<?php foreach ( $video_terms as $video_term ) : ?>
							<?php
							$term_link        = get_term_link( $video_term );
							$term_description = wp_trim_words( wp_strip_all_tags( term_description( $video_term, 'categorias_video' ) ), 80 );
							$term_count_label = sprintf(
								_n( '%s video', '%s videos', (int) $video_term->count, 'fondo-editorial' ),
								number_format_i18n( (int) $video_term->count )
							);
							?>
							<article class="blog-card card-style-list video-card-list w-100">
								<div class="row ">
									<div class="col-md-4">
										<a href="<?php echo esc_url( is_wp_error( $term_link ) ? '#' : $term_link ); ?>" class="image d-block video-card-media">
											<img src="<?php echo esc_url( term_image( $video_term->term_id, 'medium_large' ) ); ?>" alt="<?php echo esc_attr( $video_term->name ); ?>">
										</a>
									</div>
									<div class="col-md-8">
										<div class="card-content">
											<h3 class="title"><a href="<?php echo esc_url( is_wp_error( $term_link ) ? '#' : $term_link ); ?>"><?php echo esc_html( $video_term->name ); ?></a></h3>
											<p class="post-meta"><span><?php echo esc_html( $term_count_label ); ?></span></p>
											<article>
												<h2 class="sr-only">Categoría de video</h2>
												<p><?php echo esc_html( $term_description ? $term_description : $term_count_label ); ?></p>
												<a href="<?php echo esc_url( is_wp_error( $term_link ) ? '#' : $term_link ); ?>" class="blog-link">Ver videos</a>
											</article>
										</div>
									</div>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<p class="woocommerce-info">No se encontraron categorías de videos.</p>
				<?php endif; ?>
			</div>
			<div class="col-lg-3">
				<?php get_template_part( 'template-parts/sidebar/sidebar', 'content' ); ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
