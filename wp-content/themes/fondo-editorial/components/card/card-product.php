<?php
$id = $args['id'] ?? 0;
if ( ! $id ) {
    return;
}

$producto = wc_get_product( $id );
if ( ! $producto ) {
    return;
}

$titulo         = $producto->get_name();
$permalink      = get_permalink( $id );
$img            = get_the_post_thumbnail_url( $id, 'full' ) ?: assets('img/default-placeholder.png');
$img_hover      = get_the_post_thumbnail_url( $id, 'woocommerce_single' ) ?: $img;
$precio_regular = (float) $producto->get_regular_price();
$precio_oferta  = (float) $producto->get_sale_price();
$en_oferta      = $producto->is_on_sale() && $precio_oferta > 0;
$precio_mostrar = $en_oferta ? $precio_oferta : $precio_regular;
$descuento      = ( $en_oferta && $precio_regular > 0 )
                    ? round( ( ( $precio_regular - $precio_oferta ) / $precio_regular ) * 100 ) . '%'
                    : '';
$autores        = wp_get_post_terms( $id, 'autor', array( 'fields' => 'names' ) );
$autor_label    = ! is_wp_error( $autores ) && ! empty( $autores ) ? implode( ', ', $autores ) : '';
?>
<div class="product-card">
    <div class="product-header">
        <?php if ( $autor_label ) : ?>
            <a href="<?php echo esc_url( $permalink ); ?>" class="author">
                <?php echo esc_html( $autor_label ); ?>
            </a>
        <?php endif; ?>
        <h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $titulo ); ?></a></h3>
    </div>
    <div class="product-card--body">
        <div class="card-image">
            <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $titulo ); ?>">
            <div class="hover-contents">
                <a href="<?php echo esc_url( $permalink ); ?>" class="hover-image">
                    <img src="<?php echo esc_url( $img_hover ); ?>" alt="<?php echo esc_attr( $titulo ); ?>">
                </a>
            </div>
        </div>
        <div class="price-block">
            <span class="price"><?php echo wc_price( $precio_mostrar ); ?></span>
            <?php if ( $en_oferta ) : ?>
                <del class="price-old"><?php echo wc_price( $precio_regular ); ?></del>
                <?php if ( $descuento ) : ?>
                    <span class="price-discount"><?php echo esc_html( $descuento ); ?></span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
