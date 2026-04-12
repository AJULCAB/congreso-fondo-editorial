<?php get_header() ?>





<!--=================================
Home Features Section
===================================== -->
<!-- <section class="section-margin">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-6 mt--30">
                <div class="feature-box h-100">
                    <div class="icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="text">
                        <h5>Envío Gratuito</h5>
                        <p> Órdenes sobre $500</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mt--30">
                <div class="feature-box h-100">
                    <div class="icon">
                        <i class="fas fa-redo-alt"></i>
                    </div>
                    <div class="text">
                        <h5>Garantía de Devolución de Dinero</h5>
                        <p>100% devolvemos tu dinero</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mt--30">
                <div class="feature-box h-100">
                    <div class="icon">
                        <i class="fas fa-piggy-bank"></i>
                    </div>
                    <div class="text">
                        <h5>Pago Contra Entrega</h5>
                        <p>Paga cuando recibas tu pedido</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mt--30">
                <div class="feature-box h-100">
                    <div class="icon">
                        <i class="fas fa-life-ring"></i>
                    </div>
                    <div class="text">
                        <h5>Ayuda y Soporte</h5>
                        <p>Llámanos: + 0123.4567.89</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->





<?php if( have_rows('secciones') ): ?>
    <?php while( have_rows('secciones') ): the_row(); ?>
        <?php get_template_part('components/sections/section-page',get_row_layout()); ?>
    <?php endwhile; ?>
<?php endif; ?>



<!--=================================
Promotion Section Two
===================================== -->
<div class="section-margin">
    <div class="container">
        <div class="row space-db--30">
            <div class="col-lg-8 mb--30">
                <div class="promo-wrapper promo-type-yt">
                    <a href="https://www.youtube.com/@fecdelperu" target="_blank" class="promo-image  promo-overlay bg-image"
                        data-bg="<?php echo esc_url(assets('image/temp/youtube.jpg')); ?>">
                        <img src="<?php echo esc_url(assets('image/temp/youtube.jpg')); ?>" alt="">
                    </a>
                    <div class="promo-text">
                        <!-- <div class="promo-text-inner">
                            <h2>Buy 3. Get Free 1.</h2>
                            <h3>50% off for selected products in Pustok.</h3>
                            <a href="#" class="btn btn-outlined--red-faded">See More</a>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb--30">
                <div class="promo-wrapper promo-type-five ">
                    <a href="https://drive.google.com/file/d/1hIE08Yu33QZHO4VeYo1ZEaOPv03vFfH0/view" target="_blank" class="promo-image promo-overlay bg-image"
                        data-bg="<?php echo esc_url(assets('image/temp/publicaciones.jpg')); ?>">
                        <img src="<?php echo esc_url(assets('image/temp/publicaciones.jpg')); ?>" alt="">
                    </a>
                    <div class="promo-text">
                        <!-- <div class="promo-text-inner">
                            <span class="d-block price">$26.00</span>
                            <h2>Praise for <br>
                                The Night Child</h2>
                            <a href="#" class="btn btn-outlined--primary">Buy Now</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--=================================
Promotion Section Two
===================================== -->
<section class="section-margin">
    <h2 class="sr-only">Promotion Section</h2>
    <div class="container">
        <div class="promo-wrapper promo-type-four">
            <a href="https://www3.congreso.gob.pe/Docs/FondoEditorial/Interface/files/requisitos_2026.pdf" target="_blank" class="promo-image promo-overlay bg-image"
                data-bg="<?php echo esc_url(assets('image/temp/proyectos.jpg')); ?>">
                <img src="<?php echo esc_url(assets('image/temp/proyectos.jpg')); ?>" alt="" class="w-100 h-100">
            </a>
            <div class="promo-text w-100 justify-content-center justify-content-md-left">
                <div class="row w-100">
                    <div class="col-lg-8">
                        <!-- <div class="promo-text-inner">
                            <h2>Compra 3. Obtén 1 Gratis.</h2>
                            <h3>50% de descuento en productos seleccionados en Pustok.</h3>
                            <a href="#" class="btn btn-outlined--red-faded">Ver Más</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

       
<?php get_footer() ?>
