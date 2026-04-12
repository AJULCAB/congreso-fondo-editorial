<?php
$_menu_footer   = wp_get_menu_array( 'menu_footer' );
$_footer_data   = expreso_get_site_contact_data();
$_footer_social = ! empty( $_footer_data['social_links'] ) ? $_footer_data['social_links'] : array();
?>
<!--=================================
    Footer Area
    ===================================== -->
<footer class="site-footer">
    <div class="container">
        <div class="row justify-content-between  section-padding">
            <div class=" col-xl-6 col-lg-4 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="brand-footer footer-title">
                        <img src="<?php echo esc_url(assets('image/logo.png')); ?>" alt="">
                    </div>
                    <div class="footer-contact">
                        <h4 style="margin-bottom: 15px; font-weight: bold;"><?php echo esc_html( $_footer_data['organization'] ); ?></h4>
                        <p><span class="label">Ubicación:</span><span class="text"><?php echo nl2br( esc_html( $_footer_data['address'] ) ); ?></span></p>
                        <p><span class="label">Teléfono:</span><span class="text"><?php echo esc_html( $_footer_data['phone']['label'] ); ?><br><?php echo esc_html( $_footer_data['phone_secondary']['label'] ); ?></span></p>
                        <p><span class="label">WhatsApp:</span><span class="text"><?php echo esc_html( $_footer_data['whatsapp']['label'] ); ?></span></p>
                        <p><span class="label">Correo:</span><span class="text"><?php echo esc_html( $_footer_data['email_editorial'] ); ?></span></p>
                    </div>

                </div>
            </div>
            <div class=" col-xl-3 col-lg-4 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="footer-title">
                        <h3>Contacto</h3>
                    </div>
                    <ul class="footer-list normal-list mb--30">
                        <li>Uso Editorial: <a href="mailto:<?php echo antispambot( esc_attr( $_footer_data['email_editorial'] ) ); ?>"><?php echo esc_html( antispambot( $_footer_data['email_editorial'] ) ); ?></a></li>
                        <li>Ventas: <a href="mailto:<?php echo antispambot( esc_attr( $_footer_data['email_sales'] ) ); ?>"><?php echo esc_html( antispambot( $_footer_data['email_sales'] ) ); ?></a></li>
                        <li>Prensa: <a href="mailto:<?php echo antispambot( esc_attr( $_footer_data['email_press'] ) ); ?>"><?php echo esc_html( antispambot( $_footer_data['email_press'] ) ); ?></a></li>
                        <li>WhatsApp: <a href="<?php echo esc_url( $_footer_data['whatsapp']['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $_footer_data['whatsapp']['label'] ); ?></a></li>
                    </ul>

                    <div class="social-block">
                        <h3 class="title">SÍGUENOS</h3>
                        <ul class="social-list list-inline">
                            <?php foreach ( $_footer_social as $social_item ) : ?>
                                <li class="single-social <?php echo esc_attr( $social_item['item_class'] ); ?>"><a href="<?php echo esc_url( $social_item['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $social_item['label'] ); ?>"><i class="<?php echo esc_attr( $social_item['icon_class'] ); ?>"></i></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>
            <div class=" col-xl-3 col-lg-4 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="footer-title">
                        <h3>Páginas</h3>
                    </div>
                    <ul class="footer-list normal-list">
                        <?php if ( ! empty( $_menu_footer ) ) : ?>
                            <?php foreach ( $_menu_footer as $footer_item ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( $footer_item['menu']->url ); ?>"><?php echo esc_html( $footer_item['menu']->title ); ?></a>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php
                            wp_list_pages(
                                array(
                                    'title_li' => '',
                                    'depth'    => 1,
                                )
                            );
                            ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="copyright-heading pb--0 mb--0">Somos la editorial oficial del Congreso de la República del Perú, comprometidos con la difusión del conocimiento legislativo y cultural.</p>
            <!-- <a href="#" class="payment-block">
                <img src="<?php echo esc_url(assets('image/icon/payment.png')); ?>" alt="">
            </a> -->
            <p class="copyright-text">Derechos de autor © 2024 <a href="#" class="author">Fondo Editorial del Congreso del Perú</a>. Todos los derechos reservados.
                <br>
                Desarrollado por Ahiezer Julca</p>
        </div>
    </div>
</footer>
