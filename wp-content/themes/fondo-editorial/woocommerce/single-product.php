<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

$product_id = get_the_ID();
$product    = wc_get_product( $product_id );

if ( ! $product ) {
	get_footer( 'shop' );
	return;
}

$normalize_value = static function( $value ) {
	if ( is_array( $value ) ) {
		$items = array();

		foreach ( $value as $item ) {
			if ( is_object( $item ) && isset( $item->name ) ) {
				$items[] = $item->name;
			} elseif ( is_scalar( $item ) ) {
				$items[] = (string) $item;
			}
		}

		$items = array_filter( array_map( 'trim', $items ) );
		return ! empty( $items ) ? implode( ', ', $items ) : '';
	}

	if ( is_object( $value ) && isset( $value->name ) ) {
		return trim( (string) $value->name );
	}

	if ( is_scalar( $value ) ) {
		return trim( (string) $value );
	}

	return '';
};

$get_book_value = static function( array $keys ) use ( $product_id, $product, $normalize_value ) {
	foreach ( $keys as $key ) {
		if ( function_exists( 'get_field' ) ) {
			$value = $normalize_value( get_field( $key, $product_id ) );
			if ( '' !== $value ) {
				return $value;
			}
		}

		$value = $normalize_value( get_post_meta( $product_id, $key, true ) );
		if ( '' !== $value ) {
			return $value;
		}

		$value = $normalize_value( $product->get_attribute( $key ) );
		if ( '' !== $value ) {
			return $value;
		}

		if ( 0 !== strpos( $key, 'pa_' ) ) {
			$value = $normalize_value( $product->get_attribute( 'pa_' . sanitize_title( $key ) ) );
			if ( '' !== $value ) {
				return $value;
			}
		}
	}

	return '';
};

$get_taxonomy_names = static function( array $taxonomies ) use ( $product_id ) {
	foreach ( $taxonomies as $taxonomy ) {
		$terms = wp_get_post_terms( $product_id, $taxonomy, array( 'fields' => 'names' ) );

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			return implode( ', ', $terms );
		}
	}

	return '';
};

$get_taxonomy_terms = static function( array $taxonomies ) use ( $product_id ) {
	foreach ( $taxonomies as $taxonomy ) {
		$terms = wp_get_post_terms( $product_id, $taxonomy );

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			return array_values( $terms );
		}
	}

	return array();
};

$product_terms = get_the_terms( $product_id, 'product_cat' );
$product_term  = ( $product_terms && ! is_wp_error( $product_terms ) ) ? reset( $product_terms ) : null;

$image_ids = array_values(
	array_unique(
		array_filter(
			array_merge(
				$product->get_image_id() ? array( $product->get_image_id() ) : array(),
				$product->get_gallery_image_ids()
			)
		)
	)
);
$has_gallery_nav = count( $image_ids ) > 1;

$placeholder     = assets( 'img/default-placeholder.png' );
$display_title   = get_the_title( $product_id );
$catalog_base_url = $product_term ? get_term_link( $product_term ) : wc_get_page_permalink( 'shop' );
$author_label    = $get_taxonomy_names( array( 'pa_autor', 'autor' ) );
$author_terms    = $get_taxonomy_terms( array( 'pa_autor', 'autor' ) );
$author_label    = $author_label ? $author_label : $get_book_value( array( 'autor', 'autores', 'author', 'pa_autor' ) );
$pages_label     = $get_book_value( array( 'numero_de_paginas', 'paginas', 'numero_paginas', 'pages', 'cantidad_de_paginas', 'pa_numero-de-paginas', 'pa_paginas' ) );
$isbn_label      = $get_book_value( array( 'isbn', 'ISBN', 'codigo_isbn', 'pa_isbn' ) );
$isbn_label      = $isbn_label ? $isbn_label : $product->get_sku();
$year_label      = $get_book_value( array( 'anio_de_edicion', 'ano_de_edicion', 'año_de_edicion', 'anio', 'ano', 'edicion', 'year', 'pa_anio-de-edicion', 'pa_ano-de-edicion' ) );
$format_label    = $get_taxonomy_names( array( 'pa_formato' ,) );
$format_terms    = $get_taxonomy_terms( array( 'pa_formato' ) );
$format_label    = $format_label ? $format_label : $get_book_value( array( 'formato', 'tipo_de_formato', 'pa_formato' ) );
$short_review    = $product->get_short_description();
$short_review    = $short_review ? $short_review : wp_trim_words( wp_strip_all_tags( $product->get_description() ), 45 );
$average_rating  = (float) $product->get_average_rating();
$review_count    = (int) $product->get_review_count();
$stock_quantity  = $product->get_stock_quantity();
$related_ids     = wc_get_related_products( $product_id, 8 );
$related_ids     = array_values( array_filter( $related_ids ) );

if ( empty( $related_ids ) ) {
	$fallback_related = wc_get_products(
		array(
			'exclude' => array( $product_id ),
			'limit'   => 8,
			'status'  => 'publish',
			'return'  => 'ids',
		)
	);

	$related_ids = is_array( $fallback_related ) ? $fallback_related : array();
}

$stock_label = $product->is_in_stock() ? 'Disponible' : 'Agotado';
$stock_class = $product->is_in_stock() ? 'in-stock' : 'out-of-stock';
if ( $product->managing_stock() && null !== $stock_quantity ) {
	$stock_label = sprintf( '%d disponibles', (int) $stock_quantity );
}

$price_regular = (float) $product->get_regular_price();
$price_sale    = (float) $product->get_sale_price();
$is_on_sale    = $product->is_on_sale() && $price_sale > 0;
?>

<section class="breadcrumb-section">
	<h2 class="sr-only">Site Breadcrumb</h2>
	<div class="container">
		<div class="breadcrumb-contents">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
					<li class="breadcrumb-item"><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Tienda</a></li>
					<?php if ( $product_term ) : ?>
						<li class="breadcrumb-item"><a href="<?php echo esc_url( get_term_link( $product_term ) ); ?>"><?php echo esc_html( $product_term->name ); ?></a></li>
					<?php endif; ?>
					<li class="breadcrumb-item active"><?php echo esc_html( $display_title ); ?></li>
				</ol>
			</nav>
		</div>
	</div>
</section>

<main class="inner-page-sec-padding-bottom">
	<div class="container">
		<div class="row mb--60">
			<div class="col-lg-5 mb--30">
				<div class="product-details-slider sb-slick-slider arrow-type-two" data-slick-setting='{
		"slidesToShow": 1,
		"arrows": false,
		"fade": true,
		"draggable": false,
		"swipe": false,
		"asNavFor": <?php echo wp_json_encode( $has_gallery_nav ? '.product-slider-nav' : '' ); ?>
		}'>
					<?php if ( ! empty( $image_ids ) ) : ?>
						<?php foreach ( $image_ids as $image_id ) : ?>
							<?php $image_url = wp_get_attachment_image_url( $image_id, 'woocommerce_single' ) ?: $placeholder; ?>
							<div class="single-slide">
								<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $display_title ); ?>">
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<div class="single-slide">
							<img src="<?php echo esc_url( $placeholder ); ?>" alt="<?php echo esc_attr( $display_title ); ?>">
						</div>
					<?php endif; ?>
				</div>
				<?php if ( $has_gallery_nav ) : ?>
				<div class="mt--30 product-slider-nav sb-slick-slider arrow-type-two" data-slick-setting='{
	"infinite": true,
	"autoplay": true,
	"autoplaySpeed": 8000,
	"slidesToShow": 4,
	"arrows": true,
	"prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-chevron-left"},
	"nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-chevron-right"},
	"asNavFor": ".product-details-slider",
	"focusOnSelect": true
	}'>
					<?php if ( ! empty( $image_ids ) ) : ?>
						<?php foreach ( $image_ids as $image_id ) : ?>
							<?php $thumb_url = wp_get_attachment_image_url( $image_id, 'thumbnail' ) ?: $placeholder; ?>
							<div class="single-slide">
								<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $display_title ); ?>">
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<div class="single-slide">
							<img src="<?php echo esc_url( $placeholder ); ?>" alt="<?php echo esc_attr( $display_title ); ?>">
						</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="col-lg-7">
				<div class="product-details-info pl-lg--30">
					<?php if ( $author_label ) : ?>
						<p class="tag-block">Autor:
							<span class="list-value">
								<?php if ( ! empty( $author_terms ) && ! is_wp_error( $catalog_base_url ) ) : ?>
									<?php foreach ( $author_terms as $index => $author_term ) : ?>
										<?php if ( $index > 0 ) : ?>, <?php endif; ?>
										<a href="<?php echo esc_url( add_query_arg( 'autor_filtro', $author_term->slug, $catalog_base_url ) ); ?>"><?php echo esc_html( $author_term->name ); ?></a>
									<?php endforeach; ?>
								<?php else : ?>
									<?php echo esc_html( $author_label ); ?>
								<?php endif; ?>
							</span>
						</p>
					<?php endif; ?>

					<h3 class="product-title"><?php echo esc_html( $display_title ); ?></h3>

					<ul class="list-unstyled">
						<!-- <li>Autor: <span class="list-value"><?php echo esc_html( $author_label ?: 'No especificado' ); ?></span></li> -->
						<li>Número de páginas: <span class="list-value"><?php echo esc_html( $pages_label ?: 'No especificado' ); ?></span></li>
						<li>ISBN: <span class="list-value"><?php echo esc_html( $isbn_label ?: 'No especificado' ); ?></span></li>
						<li>Año de edición: <span class="list-value"><?php echo esc_html( $year_label ?: 'No especificado' ); ?></span></li>
						<li>Formato:
							<span class="list-value">
								<?php if ( ! empty( $format_terms ) && ! is_wp_error( $catalog_base_url ) ) : ?>
									<?php foreach ( $format_terms as $index => $format_term ) : ?>
										<?php if ( $index > 0 ) : ?>, <?php endif; ?>
										<a href="<?php echo esc_url( add_query_arg( 'formato', $format_term->slug, $catalog_base_url ) ); ?>"><?php echo esc_html( $format_term->name ); ?></a>
									<?php endforeach; ?>
								<?php else : ?>
									<?php echo esc_html( $format_label ?: 'No especificado' ); ?>
								<?php endif; ?>
							</span>
						</li>
						<li>Stock disponible: <span class="list-value <?php echo esc_attr( $stock_class ); ?>"><?php echo esc_html( $stock_label ); ?></span></li>
					</ul>

					<div class="price-block">
						<?php if ( $is_on_sale ) : ?>
							<span class="price-new"><?php echo wp_kses_post( wc_price( $price_sale ) ); ?></span>
							<del class="price-old"><?php echo wp_kses_post( wc_price( $price_regular ) ); ?></del>
						<?php else : ?>
							<span class="price-new"><?php echo wp_kses_post( wc_price( (float) $product->get_price() ) ); ?></span>
						<?php endif; ?>
					</div>

					<div class="rating-widget">
						<div class="rating-block" aria-label="Opiniones del público">
							<?php for ( $star = 1; $star <= 5; $star++ ) : ?>
								<span class="fas fa-star <?php echo esc_attr( $average_rating >= $star ? 'star_on' : '' ); ?>"></span>
							<?php endfor; ?>
						</div>
						<div class="review-widget">
							<a href="#tab-2" data-bs-toggle="tab" role="tab">(<?php echo esc_html( $review_count ); ?> opiniones)</a>
							<span>|</span>
							<a href="#tab-2" data-bs-toggle="tab" role="tab">Ver opiniones del público</a>
						</div>
					</div>

					<article class="product-details-article">
						<h4 class="sr-only">Reseña</h4>
						<?php echo wp_kses_post( wpautop( $short_review ?: 'Sin reseña disponible.' ) ); ?>
					</article>

					<?php //woocommerce_template_single_add_to_cart(); ?>
				</div>
			</div>
		</div>

		<div class="sb-custom-tab review-tab section-padding">
			<ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">
						RESEÑA
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab2" data-bs-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">
						OPINIONES DEL PÚBLICO (<?php echo esc_html( $review_count ); ?>)
					</a>
				</li>
			</ul>

			<div class="tab-content space-db--20" id="myTabContent">
				<div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab1">
					<article class="review-article">
						<h1 class="sr-only">Reseña del libro</h1>
						<?php echo apply_filters( 'the_content', $product->get_description() ?: $short_review ); ?>
					</article>
				</div>

				<div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab2">
					<?php comments_template(); ?>
				</div>
			</div>
		</div>
	</div>

	<?php if ( ! empty( $related_ids ) ) : ?>
		<section>
			<div class="container">
				<div class="section-title section-title--bordered">
					<h2>LIBROS RELACIONADOS</h2>
				</div>

				<div class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
		"autoplay": true,
		"autoplaySpeed": 8000,
		"slidesToShow": 4,
		"dots": true
	}' data-slick-responsive='[
		{"breakpoint":1200, "settings": {"slidesToShow": 4}},
		{"breakpoint":992, "settings": {"slidesToShow": 3}},
		{"breakpoint":768, "settings": {"slidesToShow": 2}},
		{"breakpoint":480, "settings": {"slidesToShow": 1}}
	]'>
					<?php foreach ( $related_ids as $related_id ) : ?>
						<div class="single-slide">
							<?php get_template_part( 'components/card/card', 'product', array( 'id' => $related_id ) ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php
get_footer( 'shop' );