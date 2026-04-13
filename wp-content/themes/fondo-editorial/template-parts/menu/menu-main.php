<?php
$_menu_categories = wp_get_menu_array('menu_categories');
$_menu_desktop    = wp_get_menu_array('menu_desktop');
$_menu_mobile     = wp_get_menu_array('menu_mobile');
$_footer_data     = expreso_get_site_contact_data();
$_footer_social   = ! empty($_footer_data['social_links']) ? $_footer_data['social_links'] : array();
?>
<div class="site-header header-2 mb--20 d-none d-lg-block">
    <div class="header-middle pt--10 pb--10">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-3">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-brand">
                        <img src="<?php echo esc_url(assets('image/logo.png')); ?>" alt="<?php bloginfo('name'); ?>">
                    </a>
                </div>
                <div class="col-lg-5 float-end">
                    <form class="header-search-block" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" name="s" placeholder="Buscar en el sitio" value="<?php echo esc_attr(get_search_query()); ?>" aria-label="Buscar en el sitio">
                        <button type="submit">Buscar</button>
                    </form>
                </div>
                <!-- <div class="col-lg-4">
                    <div class="main-navigation flex-lg-right">
                        <div class="cart-widget">
                            <div class="login-block">
                                <a href="login-register.html" class="font-weight-bold">Iniciar sesión</a> <br>
                                <span>o</span><a href="login-register.html">Registrarse</a>
                            </div>
                            <div class="cart-block">
                                <div class="cart-total">
                                    <span class="text-number">
                                        1
                                    </span>
                                    <span class="text-item">
                                        Carrito
                                    </span>
                                    <span class="price">
                                        S/0.00
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </div>
                                <div class="cart-dropdown-block">
                                    <div class=" single-cart-block ">
                                        <div class="cart-product">
                                            <a href="product-details.html" class="image">
                                                <img src="image/products/cart-product-1.jpg" alt="">
                                            </a>
                                            <div class="content">
                                                <h3 class="title"><a href="product-details.html">Kodak PIXPRO
                                                        Astro Zoom AZ421 16 MP</a>
                                                </h3>
                                                <p class="price"><span class="qty">1 ×</span> S/87.34</p>
                                                <button class="cross-btn"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" single-cart-block ">
                                        <div class="btn-block">
                                            <a href="cart.html" class="btn">Ver carrito <i
                                                    class="fas fa-chevron-right"></i></a>
                                            <a href="checkout.html" class="btn btn--primary">Finalizar compra <i
                                                    class="fas fa-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="header-bottom bg-primary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <nav class="category-nav white-nav  ">
                        <div>
                            <a href="javascript:void(0)" class="category-trigger"><i
                                    class="fa fa-bars"></i>Explorar catálogos</a>
                            <ul class="category-menu">
                                <?php _render_cat_menu($_menu_categories); ?>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- <div class="col-lg-3">
                    <div class="header-phone color-white">
                        <div class="icon">
                            <i class="fas fa-headphones-alt"></i>
                        </div>
                        <div class="text">
                            <p>Soporte gratuito 24/7</p>
                            <p class="font-weight-bold number">+01-202-555-0181</p>
                        </div>
                    </div>
                </div> -->
                <div class="col-lg-9">
                    <div class="main-navigation flex-lg-right">
                        <ul class="main-menu menu-right main-menu--white li-last-0">
                            <?php _render_desktop_menu($_menu_desktop); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-mobile-menu">
    <header class="mobile-header d-block d-lg-none pt--10 pb-md--10">
        <div class="container">
            <div class="row align-items-sm-end align-items-center">
                <div class="col-md-4 col-7">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-brand">
                        <img src="<?php echo esc_url(assets('image/logo.png')); ?>" alt="<?php bloginfo('name'); ?>">
                    </a>
                </div>
                <div class="col-md-5 order-3 order-md-2">
                    <nav class="category-nav   ">
                        <div>
                            <a href="javascript:void(0)" class="category-trigger"><i
                                    class="fa fa-bars"></i>Explorar catálogos</a>
                            <ul class="category-menu">
                                <?php _render_cat_menu($_menu_categories); ?>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-md-3 col-5  order-md-3 text-right">
                    <div class="mobile-header-btns header-top-widget">
                        <ul class="header-links">
                            <!-- <li class="sin-link">
                                <a href="cart.html" class="cart-link link-icon"><i class="ion-bag"></i></a>
                            </li> -->
                            <li class="sin-link">
                                <a href="javascript:" class="link-icon hamburgur-icon off-canvas-btn"><i
                                        class="ion-navicon"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--Off Canvas Navigation Start-->
    <aside class="off-canvas-wrapper">
        <div class="btn-close-off-canvas">
            <i class="ion-android-close"></i>
        </div>
        <div class="off-canvas-inner">
            <!-- search box start -->
            <div class="search-box offcanvas">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" name="s" placeholder="Buscar aquí" value="<?php echo esc_attr(get_search_query()); ?>" aria-label="Buscar en el sitio">
                    <button class="search-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                </form>
            </div>
            <!-- search box end -->
            <!-- mobile menu start -->
            <div class="mobile-navigation">
                <!-- mobile menu navigation start -->
                <nav class="off-canvas-nav">
                    <ul class="mobile-menu main-mobile-menu">
                        <?php _render_mobile_menu($_menu_mobile); ?>
                    </ul>
                </nav>
                <!-- mobile menu navigation end -->
            </div>
            <!-- mobile menu end -->
            <!-- <nav class="off-canvas-nav">
                <ul class="mobile-menu menu-block-2">
                    <li class="menu-item-has-children">
                        <a href="#">Moneda - USD $ <i class="fas fa-angle-down"></i></a>
                        <ul class="sub-menu">
                            <li> <a href="cart.html">USD $</a></li>
                            <li> <a href="checkout.html">EUR €</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Idioma - Esp<i class="fas fa-angle-down"></i></a>
                        <ul class="sub-menu">
                            <li>Esp</li>
                            <li>Ban</li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Mi Cuenta <i class="fas fa-angle-down"></i></a>
                        <ul class="sub-menu">
                            <li><a href="">Mi Cuenta</a></li>
                            <li><a href="">Historial de Pedidos</a></li>
                            <li><a href="">Transacciones</a></li>
                            <li><a href="">Descargas</a></li>
                        </ul>
                    </li>
                </ul>
            </nav> -->
            <div class="off-canvas-bottom">
                <div class="contact-list mb--10">
                    <a href="<?php echo esc_url($_footer_data['phone']['url']); ?>" class="sin-contact"><i class="fas fa-mobile-alt"></i><?php echo esc_html($_footer_data['phone']['label']); ?></a>
                    <a href="mailto:<?php echo antispambot( esc_attr($_footer_data['email_editorial']) ); ?>" class="sin-contact"><i class="fas fa-envelope"></i><?php echo esc_html( antispambot($_footer_data['email_editorial']) ); ?></a>
                </div>
                <div class="off-canvas-social">
                    <?php foreach ($_footer_social as $social_item) : ?>
                        <a href="<?php echo esc_url($social_item['url']); ?>" class="single-icon" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($social_item['label']); ?>"><i class="<?php echo esc_attr($social_item['icon_class']); ?>"></i></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </aside>
    <!--Off Canvas Navigation End-->
</div>
<div class="sticky-init fixed-header common-sticky">
    <div class="container d-none d-lg-block">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-brand">
                    <img src="<?php echo esc_url(assets('image/logo.png')); ?>" alt="<?php bloginfo('name'); ?>">
                </a>
            </div>
            <div class="col-lg-8">
                <div class="main-navigation flex-lg-right">
                    <ul class="main-menu menu-right ">
                        <?php _render_desktop_menu($_menu_desktop); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>