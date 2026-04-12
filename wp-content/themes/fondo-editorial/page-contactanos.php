<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php $page_ancestors = array_reverse( get_post_ancestors( get_the_ID() ) ); ?>

        <section class="breadcrumb-section">
            <h2 class="sr-only">Breadcrumb</h2>
            <div class="container">
                <div class="breadcrumb-contents">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
                            <?php foreach ( $page_ancestors as $ancestor_id ) : ?>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo esc_url( get_permalink( $ancestor_id ) ); ?>"><?php echo esc_html( get_the_title( $ancestor_id ) ); ?></a>
                                </li>
                            <?php endforeach; ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        <main class="contact_area inner-page-sec-padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'contact_adress' ); ?>>
                            <div class="ct_address">
                                <h1 class="ct_title"><?php the_title(); ?></h1>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb--30">
                                    <div class="address_wrapper">
                                        <div class="address">
                                            <div class="icon">
                                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                            </div>
                                            <div class="contact-info-text">
                                                <p><span>Ubicación:</span> Edificio Fernando Belaunde Terry<br>Jirón Huallaga 330, Cercado de Lima</p>
                                            </div>
                                        </div>

                                        <div class="address">
                                            <div class="icon">
                                                <i class="fas fa-phone-alt" aria-hidden="true"></i>
                                            </div>
                                            <div class="contact-info-text">
                                                <p><span>Teléfonos:</span> <a href="tel:+5113117846">(01) 311-7846</a><br><a href="tel:+5113117777">(01) 311-7777</a> anexo 6163</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb--30">
                                    <div class="address_wrapper">
                                        <div class="address">
                                            <div class="icon">
                                                <i class="far fa-envelope" aria-hidden="true"></i>
                                            </div>
                                            <div class="contact-info-text">
                                                <p><span>Correos:</span><br>Proyectos editoriales: <a href="mailto:fondoeditorial@congreso.gob.pe">fondoeditorial@congreso.gob.pe</a><br>Ventas e información comercial: <a href="mailto:fondoeditorialventas@congreso.gob.pe">fondoeditorialventas@congreso.gob.pe</a><br>Prensa: <a href="mailto:prensafec@congreso.gob.pe">prensafec@congreso.gob.pe</a></p>
                                            </div>
                                        </div>

                                        <div class="address">
                                            <div class="icon">
                                                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                            </div>
                                            <div class="contact-info-text">
                                                <p><span>WhatsApp:</span> <a href="https://wa.me/c/51924987288" target="_blank" rel="noopener noreferrer">924-987288</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt--10 mb--40">
                                <h2 class="ct_title">Búscanos en</h2>
                                <div class="social-links mt--20">
                                    <a href="https://www.facebook.com/fecdelperu" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/fecdelperu" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="X"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.instagram.com/fecdelperu/" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="https://www.youtube.com/channel/UCQ9ONB5Y1p6VoXZynLRWlsA/featured" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                                    <a href="https://www.tiktok.com/@fondoeditorial?lang=es" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                                </div>
                            </div>

                            <div class="contact-map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d679.8827173550296!2d-77.02929968459843!3d-12.047738330491628!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8b6c6c1642d%3A0xfad602d422573f99!2sLibrer%C3%ADa%20Fondo%20Editorial%20del%20Congreso%20del%20Per%C3%BA!5e0!3m2!1ses!2spe!4v1681406366316!5m2!1ses!2spe" width="100%" height="450" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa de ubicación Fondo Editorial"></iframe>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </main>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
