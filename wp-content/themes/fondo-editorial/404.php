<?php
get_header();

$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$contacto    = get_page_by_path( 'contacto' );
$contact_url = $contacto instanceof WP_Post ? get_permalink( $contacto ) : '';
?>

<section class="breadcrumb-section">
	<h2 class="sr-only">Breadcrumb</h2>
	<div class="container">
		<div class="breadcrumb-contents">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
					<li class="breadcrumb-item active" aria-current="page">404</li>
				</ol>
			</nav>
		</div>
	</div>
</section>

<section class="inner-page-sec-padding-bottom error-404-page">
	<div class="container">
		<div class="error-404-wrap text-center">
			<p class="error-code">404</p>
			<h1 class="error-title">No encontramos la página que estás buscando</h1>
			<p class="error-description">
				La dirección puede haber cambiado, el contenido pudo ser movido o el enlace ya no está disponible.
			</p>

			<form class="site-mini-search error-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" name="s" placeholder="Buscar libros, noticias o contenido" value="<?php echo esc_attr( get_search_query() ); ?>">
				<button type="submit" aria-label="Buscar"><i class="fas fa-search"></i></button>
			</form>

			<div class="error-actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outlined--primary">Volver al inicio</a>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-outlined">Ir a la tienda</a>
			</div>

			<div class="error-links">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Portada</a>
				<a href="<?php echo esc_url( $shop_url ); ?>">Libros</a>
				<?php if ( $contact_url ) : ?>
					<a href="<?php echo esc_url( $contact_url ); ?>">Contacto</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

