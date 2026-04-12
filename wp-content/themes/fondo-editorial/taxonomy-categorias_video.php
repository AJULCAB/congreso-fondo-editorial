<?php
get_header();

global $wp_query;

$current_term  = get_queried_object();
$archive_link  = get_post_type_archive_link( 'video' );
$archive_title = $current_term instanceof WP_Term ? $current_term->name : single_term_title( '', false );
$term_label    = $current_term instanceof WP_Term ? wp_trim_words( wp_strip_all_tags( term_description( $current_term, 'categorias_video' ) ), 1000 ) : '';
$total_results = (int) $wp_query->found_posts;
$current_page  = max( 1, get_query_var( 'paged' ) );
?>
<section class="breadcrumb-section">
	<h2 class="sr-only">Site Breadcrumb</h2>
	<div class="container">
		<div class="breadcrumb-contents">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
					<?php if ( $archive_link ) : ?>
						<li class="breadcrumb-item"><a href="<?php echo esc_url( $archive_link ); ?>">Videos</a></li>
					<?php endif; ?>
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
						<span><?php echo esc_html( sprintf( _n( '%s video', '%s videos', $total_results, 'fondo-editorial' ), number_format_i18n( $total_results ) ) ); ?></span>
					</p>
					<?php if ( $term_label ) : ?>
						<p class="mb--0"><?php echo esc_html( $term_label ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( have_posts() ) : ?>
					<div class="row space-db-lg--60 space-db--30">
						<?php while ( have_posts() ) : the_post(); ?>
							<div class="col-lg-6 col-md-6 mb-lg--60 mb--30">
								<article <?php post_class( 'blog-card card-style-grid video-card-grid' ); ?>>
									<a href="<?php the_permalink(); ?>" class="image d-block video-card-media">
										<img src="<?php echo esc_url( expreso_get_video_poster( get_the_ID() ) ); ?>" alt="<?php the_title_attribute(); ?>">
										<span class="video-card-play" aria-hidden="true"><i class="fas fa-play"></i></span>
									</a>
									<div class="card-content">
										<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p class="post-meta"><span><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span> </p>
										<article>
											<h2 class="sr-only">Video</h2>
											<p><?php echo esc_html( wp_trim_words( get_the_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_strip_all_tags( get_the_content() ), 24 ) ); ?></p>
											<!-- <a href="<?php the_permalink(); ?>" class="blog-link">Ver video</a> -->
										</article>
									</div>
								</article>
							</div>
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
					<p class="woocommerce-info">No se encontraron videos.</p>
				<?php endif; ?>
			</div>
			<div class="col-lg-3">
				<?php get_template_part( 'template-parts/sidebar/sidebar', 'content' ); ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
