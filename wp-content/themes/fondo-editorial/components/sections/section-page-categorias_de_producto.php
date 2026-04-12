<!--=================================
SECCIÓN: PRODUCTOS POR CATEGORÍA
===================================== -->
<?php
$categoria = get_sub_field('seleccionar_categoria'); // WP_Term (product_cat)
if ( ! $categoria instanceof WP_Term ) {
    return;
}

$productos = wc_get_products( array(
    'status'        => 'publish',
    'limit'         => 8,
    'category'      => array( $categoria->slug ),
    'orderby'       => 'date',
    'order'         => 'DESC',
    'stock_status'  => 'instock',
) );

if ( empty( $productos ) ) {
    return;
}

$cat_url = get_term_link( $categoria );
?>
<section class="section-margin">
    <div class="container">
        <div class="section-title section-title--bordered flex-lg-right justify-content-between align-items-center mb--20">
            <h2><?php echo esc_html( $categoria->name ); ?></h2>
            <?php if ( ! is_wp_error( $cat_url ) ) : ?>
                <a href="<?php echo esc_url( $cat_url ); ?>" class="btn btn-sm btn-outlined--primary ms-auto">
                    Ver todos
                </a>
            <?php endif; ?>
        </div>
        <div class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
            "autoplay": true,
            "autoplaySpeed": 8000,
            "slidesToShow": 5,
            "dots": true
        }' data-slick-responsive='[
            {"breakpoint":1500, "settings": {"slidesToShow": 4} },
            {"breakpoint":992,  "settings": {"slidesToShow": 3} },
            {"breakpoint":768,  "settings": {"slidesToShow": 2} },
            {"breakpoint":480,  "settings": {"slidesToShow": 1} },
            {"breakpoint":320,  "settings": {"slidesToShow": 1} }
        ]'>
            <?php foreach ( $productos as $producto ) : ?>
            <div class="single-slide">
                <?php get_template_part( 'components/card/card', 'product', array( 'id' => $producto->get_id() ) ); ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
