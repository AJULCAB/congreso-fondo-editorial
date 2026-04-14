<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;
?>
<?php get_header() ?>
<section class="breadcrumb-section">
	<h2 class="sr-only">Site Breadcrumb</h2>
	<div class="container">
		<div class="breadcrumb-contents">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
					<?php if ( is_tax( 'product_cat' ) ) : ?>
						<li class="breadcrumb-item"><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Tienda</a></li>
						<li class="breadcrumb-item active"><?php single_term_title(); ?></li>
					<?php else : ?>
						<li class="breadcrumb-item active">Tienda</li>
					<?php endif; ?>
				</ol>
			</nav>
		</div>
	</div>
</section>
<main class="inner-page-sec-padding-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 order-lg-2">
				<?php
				global $wp_query;
				$total            = intval( $wp_query->found_posts );
				$per_page         = max( 1, intval( $wp_query->query_vars['posts_per_page'] ) );
				$paged            = max( 1, intval( $wp_query->get( 'paged' ) ) );
				$from             = $total > 0 ? ( ( $paged - 1 ) * $per_page ) + 1 : 0;
				$to               = min( $paged * $per_page, $total );
				$current_orderby  = isset( $_GET['orderby'] )
					? sanitize_text_field( wp_unslash( $_GET['orderby'] ) )
					: apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
				$current_per_page = isset( $_GET['per_page'] ) ? intval( $_GET['per_page'] ) : $per_page;
				$sort_options     = array(
					'menu_order' => 'Orden por defecto',
					'date'       => 'Más recientes',
					'price'      => 'Precio: menor a mayor',
					'price-desc' => 'Precio: mayor a menor',
				);
				$per_page_options = array( 9, 12, 18, 24 );
				$current_author   = isset( $_GET['autor_filtro'] )
					? sanitize_title( wp_unslash( $_GET['autor_filtro'] ) )
					: ( isset( $_GET['autor'] ) ? sanitize_title( wp_unslash( $_GET['autor'] ) ) : '' );
				$current_format   = isset( $_GET['formato'] ) ? sanitize_title( wp_unslash( $_GET['formato'] ) ) : '';
				?>
				<div class="shop-toolbar with-sidebar mb--30">
					<div class="row align-items-center">
						<div class="col-lg-2 col-md-2 col-sm-6">
							<!-- Product View Mode -->
							<div class="product-view-mode">
								<a href="#" class="sorting-btn" data-target="grid"><i class="fas fa-th"></i></a>
								<!-- <a href="#" class="sorting-btn" data-target="grid-four">
									<span class="grid-four-icon">
										<i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
									</span>
								</a>
								<a href="#" class="sorting-btn" data-target="list"><i class="fas fa-list"></i></a> -->
							</div>
						</div>
						<div class="col-xl-4 col-md-4 col-sm-6 mt--10 mt-sm--0">
							<span class="toolbar-status">
								<?php if ( $total > 0 ) : ?>
									Mostrando <?php echo esc_html( $from ); ?>–<?php echo esc_html( $to ); ?> de <?php echo esc_html( $total ); ?> resultado<?php echo $total !== 1 ? 's' : ''; ?>
								<?php else : ?>
									Sin resultados
								<?php endif; ?>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-6 mt--10 mt-md--0">
							<div class="sorting-selection">
								<span>Mostrar:</span>
								<select class="form-control nice-select sort-select" id="shop-per-page">
									<?php foreach ( $per_page_options as $opt ) : ?>
										<option value="<?php echo esc_attr( $opt ); ?>"<?php selected( $current_per_page, $opt ); ?>>
											<?php echo esc_html( $opt ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 mt--10 mt-md--0">
							<div class="sorting-selection">
								<span>Ordenar:</span>
								<select class="form-control nice-select sort-select mr-0" id="shop-orderby">
									<?php foreach ( $sort_options as $val => $label ) : ?>
										<option value="<?php echo esc_attr( $val ); ?>"<?php selected( $current_orderby, $val ); ?>>
											<?php echo esc_html( $label ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">
					<?php if ( woocommerce_product_loop() ) : ?>
						<?php while ( have_posts() ) : the_post(); global $product; ?>
							<div class="col-lg-4 col-sm-6">
								<?php get_template_part('components/card/card', 'product', array('id' => $product->get_id())); ?>
							</div>
						<?php endwhile; ?>
					<?php else : ?>
						<p class="woocommerce-info">No se encontraron productos que concuerden con la selección.</p>
					<?php endif; ?>
				</div>
				<!-- Pagination Block -->
				<div class="row pt--30">
					<div class="col-md-12">
						<div class="pagination-block bg--white">
							<?php woocommerce_pagination(); ?>
						</div>
					</div>
				</div>
				<!-- Modal -->
				<div class="modal fade modal-quick-view" id="quickModal" tabindex="-1" role="dialog"
				aria-labelledby="quickModal" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						<div class="product-details-modal">
							<div class="row">
								<div class="col-lg-5">
									<!-- Product Details Slider Big Image-->
									<div class="product-details-slider sb-slick-slider arrow-type-two" data-slick-setting='{
										"slidesToShow": 1,
										"arrows": false,
										"fade": true,
										"draggable": false,
										"swipe": false,
										"asNavFor": ".product-slider-nav"
										}'>
										<div class="single-slide">
											<img src="image/products/product-details-1.jpg" alt="">
										</div>
										<div class="single-slide">
											<img src="image/products/product-details-2.jpg" alt="">
										</div>
										<div class="single-slide">
											<img src="image/products/product-details-3.jpg" alt="">
										</div>
										<div class="single-slide">
											<img src="image/products/product-details-4.jpg" alt="">
										</div>
										<div class="single-slide">
											<img src="image/products/product-details-5.jpg" alt="">
										</div>
									</div>
									<!-- Product Details Slider Nav -->
									<div class="mt--30 product-slider-nav sb-slick-slider arrow-type-two"
										data-slick-setting='{
				"infinite":true,
					"autoplay": true,
					"autoplaySpeed": 8000,
					"slidesToShow": 4,
					"arrows": true,
					"prevArrow":{"buttonClass": "slick-prev","iconClass":"fa fa-chevron-left"},
					"nextArrow":{"buttonClass": "slick-next","iconClass":"fa fa-chevron-right"},
					"asNavFor": ".product-details-slider",
					"focusOnSelect": true
					}'>
										<div class="single-slide">
											<img src="image/products/product-details-1.jpg" alt="">
										</div>
										<div class="single-slide">
											<img src="image/products/product-details-2.jpg" alt="">
										</div>
										<div class="single-slide">
											<img src="image/products/product-details-3.jpg" alt="">
										</div>
										<div class="single-slide">
											<img src="image/products/product-details-4.jpg" alt="">
										</div>
										<div class="single-slide">
											<img src="image/products/product-details-5.jpg" alt="">
										</div>
									</div>
								</div>
								<div class="col-lg-7 mt--30 mt-lg--30">
									<div class="product-details-info pl-lg--30 ">
										<p class="tag-block">Tags: <a href="#">Movado</a>, <a href="#">Omega</a></p>
										<h3 class="product-title">Beats EP Wired On-Ear Headphone-Black</h3>
										<ul class="list-unstyled">
											<li>Ex Tax: <span class="list-value"> £60.24</span></li>
											<li>Brands: <a href="#" class="list-value font-weight-bold"> Canon</a></li>
											<li>Product Code: <span class="list-value"> model1</span></li>
											<li>Reward Points: <span class="list-value"> 200</span></li>
											<li>Availability: <span class="list-value"> In Stock</span></li>
										</ul>
										<div class="price-block">
											<span class="price-new">£73.79</span>
											<del class="price-old">£91.86</del>
										</div>
										<div class="rating-widget">
											<div class="rating-block">
												<span class="fas fa-star star_on"></span>
												<span class="fas fa-star star_on"></span>
												<span class="fas fa-star star_on"></span>
												<span class="fas fa-star star_on"></span>
												<span class="fas fa-star "></span>
											</div>
											<div class="review-widget">
												<a href="">(1 Reviews)</a> <span>|</span>
												<a href="">Write a review</a>
											</div>
										</div>
										<article class="product-details-article">
											<h4 class="sr-only">Product Summery</h4>
											<p>Long printed dress with thin adjustable straps. V-neckline and wiring under
												the Dust with ruffles
												at the bottom
												of the
												dress.</p>
										</article>
										<div class="add-to-cart-row">
											<div class="count-input-block">
												<span class="widget-label">Qty</span>
												<input type="number" class="form-control text-center" value="1">
											</div>
											<div class="add-cart-btn">
												<a href="" class="btn btn-outlined--primary"><span
														class="plus-icon">+</span>Add to Cart</a>
											</div>
										</div>
										<div class="compare-wishlist-row">
											<a href="" class="add-link"><i class="fas fa-heart"></i>Add to Wish List</a>
											<a href="" class="add-link"><i class="fas fa-random"></i>Add to Compare</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="widget-social-share">
								<span class="widget-label">Share:</span>
								<div class="modal-social-share">
									<a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
									<a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
									<a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="col-lg-3  mt--40 mt-lg--0">
				<div class="inner-page-sidebar">
					<!-- Accordion -->
					<div class="single-block">
						<h3 class="sidebar-title">Catálogos</h3>
						<ul class="sidebar-menu--shop">
							<?php
							$current_term_id = 0;
							$is_shop         = false;
							if ( is_tax( 'product_cat' ) ) {
								$current_term = get_queried_object();
								if ( $current_term ) {
									$current_term_id = $current_term->term_id;
								}
							} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
								$is_shop = true;
							}

							$total_products = wp_count_posts( 'product' )->publish;
							?>
							<li>
								<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="<?php echo $is_shop ? 'active font-weight-bold' : ''; ?>">
									Todos (<?php echo esc_html( $total_products ); ?>)
								</a>
							</li>
							<?php
							$product_cats = get_terms( array(
								'taxonomy'   => 'product_cat',
								'hide_empty' => true,
							) );
							
							if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) :
								foreach ( $product_cats as $cat ) :
									// Agregamos clase active si estamos en esta categoría
									$active_class = ( $current_term_id === $cat->term_id ) ? 'active font-weight-bold' : '';
									$cat_link     = get_term_link( $cat );
							?>
								<li>
									<a href="<?php echo esc_url( $cat_link ); ?>" class="<?php echo esc_attr( $active_class ); ?>">
										<?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)
									</a>
								</li>
							<?php 
								endforeach;
							endif; 
							?>
						</ul>
					</div>
					<!-- Price -->
					<div class="single-block">
						<h3 class="sidebar-title">Filtro por rango de precio</h3>
						<div class="range-slider pt--30">
							<?php
							global $wpdb;
							$max_price = ceil( $wpdb->get_var( "
								SELECT max(meta_value + 0)
								FROM {$wpdb->postmeta}
								WHERE meta_key = '_price'
							" ) );
							$max_price = $max_price ? $max_price : 1000;
							$current_min = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
							$current_max = isset($_GET['max_price']) ? intval($_GET['max_price']) : $max_price;
							$current_archive_url = is_tax( 'product_cat' ) && ! empty( $current_term )
								? get_term_link( $current_term )
								: wc_get_page_permalink( 'shop' );
							$author_taxonomy = '';
							$format_taxonomy = taxonomy_exists( 'pa_formato' ) ? 'pa_formato' : '';

							if ( taxonomy_exists( 'pa_autor' ) ) {
								$author_terms_probe = get_terms( array(
									'taxonomy'   => 'pa_autor',
									'hide_empty' => true,
									'number'     => 1,
								) );

								if ( ! is_wp_error( $author_terms_probe ) && ! empty( $author_terms_probe ) ) {
									$author_taxonomy = 'pa_autor';
								}
							}

							if ( ! $author_taxonomy && taxonomy_exists( 'autor' ) ) {
								$author_terms_probe = get_terms( array(
									'taxonomy'   => 'autor',
									'hide_empty' => true,
									'number'     => 1,
								) );

								if ( ! is_wp_error( $author_terms_probe ) && ! empty( $author_terms_probe ) ) {
									$author_taxonomy = 'autor';
								}
							}

							$author_terms = $author_taxonomy ? get_terms( array(
								'taxonomy'   => $author_taxonomy,
								'hide_empty' => true,
							) ) : array();

							$format_terms = $format_taxonomy ? get_terms( array(
								'taxonomy'   => $format_taxonomy,
								'hide_empty' => true,
							) ) : array();

							$base_filter_args = array_filter( array(
								'orderby'   => $current_orderby,
								'per_page'  => $current_per_page,
								'min_price' => $current_min > 0 ? $current_min : null,
								'max_price' => $current_max < $max_price ? $current_max : null,
							) );
							?>
							<div class="sb-range-slider" 
								data-min="0" 
								data-max="<?php echo esc_attr( $max_price ); ?>"
								data-current-min="<?php echo esc_attr( $current_min ); ?>"
								data-current-max="<?php echo esc_attr( $current_max ); ?>"
								data-term-id="<?php echo esc_attr( $current_term_id ); ?>"></div>
							<div class="slider-price">
								<p>
									<input type="text" id="amount" readonly="">
								</p>
							</div>
						</div>
					</div>
					<!-- Size -->

					<?php if ( ! empty( $author_terms ) && ! is_wp_error( $author_terms ) ) : ?>
					<div class="single-block">
						<h3 class="sidebar-title">Autores</h3>
						<ul class="sidebar-menu--shop menu-type-2">
							<li>
								<a href="<?php echo esc_url( add_query_arg( array_filter( array_merge( $base_filter_args, array( 'formato' => $current_format ) ) ), $current_archive_url ) ); ?>" class="<?php echo empty( $current_author ) ? 'active font-weight-bold' : ''; ?>">
									Todos
								</a>
							</li>
							<?php foreach ( $author_terms as $author_term ) : ?>
								<li>
									<a href="<?php echo esc_url( add_query_arg( array_filter( array_merge( $base_filter_args, array( 'autor_filtro' => $author_term->slug, 'formato' => $current_format ) ) ), $current_archive_url ) ); ?>" class="<?php echo $current_author === $author_term->slug ? 'active font-weight-bold' : ''; ?>">
										<?php echo esc_html( $author_term->name ); ?> <span>(<?php echo esc_html( $author_term->count ); ?>)</span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ( ! empty( $format_terms ) && ! is_wp_error( $format_terms ) ) : ?>
					<div class="single-block">
						<h3 class="sidebar-title">Formato</h3>
						<ul class="sidebar-menu--shop menu-type-2">
							<li>
								<a href="<?php echo esc_url( add_query_arg( array_filter( array_merge( $base_filter_args, array( 'autor_filtro' => $current_author ) ) ), $current_archive_url ) ); ?>" class="<?php echo empty( $current_format ) ? 'active font-weight-bold' : ''; ?>">
									Todos
								</a>
							</li>
							<?php foreach ( $format_terms as $format_term ) : ?>
								<li>
									<a href="<?php echo esc_url( add_query_arg( array_filter( array_merge( $base_filter_args, array( 'autor_filtro' => $current_author, 'formato' => $format_term->slug ) ) ), $current_archive_url ) ); ?>" class="<?php echo $current_format === $format_term->slug ? 'active font-weight-bold' : ''; ?>">
										<?php echo esc_html( $format_term->name ); ?> <span>(<?php echo esc_html( $format_term->count ); ?>)</span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<!-- <div class="single-block">
						<h3 class="sidebar-title">Autores</h3>
						<ul class="sidebar-menu--shop menu-type-2">
							<li><a href="">Christian Dior <span>(5)</span></a></li>
							<li><a href="">Diesel <span>(8)</span></a></li>
							<li><a href="">Ferragamo <span>(11)</span></a></li>
							<li><a href="">Hermes <span>(14)</span></a></li>
							<li><a href="">Louis Vuitton <span>(12)</span></a></li>
							<li><a href="">Tommy Hilfiger <span>(0)</span></a></li>
							<li><a href="">Versace <span>(0)</span></a></li>
						</ul>
					</div> -->
					
					<!-- Promotion Block -->
					<!-- <div class="single-block">
						<a href="" class="promo-image sidebar">
							<img src="image/others/home-side-promo.jpg" alt="">
						</a>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</main>

<!-- Footer Area Start Here -->
<?php get_footer(); ?>