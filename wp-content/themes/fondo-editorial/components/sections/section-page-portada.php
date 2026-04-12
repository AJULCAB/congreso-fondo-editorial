<?php if( have_rows('slider_de_imagenes') ): ?>

<!--=================================
Hero Area
===================================== -->
<section class="hero-area hero-slider-2  section-margin">
    <div class="container">
        <div class="row align-items-lg-center">
            <div class="col-12">
                <div class="sb-slick-slider" data-slick-setting='{
                    "autoplay": true,
                    "autoplaySpeed": 8000,
                    "slidesToShow": 1,
                    "dots":true,
                    "adaptiveHeight": true
                    }'>

                    <?php while( have_rows('slider_de_imagenes') ): the_row(); 
                        $imagen = get_sub_field('imagen');
                        ?>
                        <div class="single-slide bg-image" data-bg="<?php echo esc_url($imagen['url']); ?>">
                            <div class="home-content pl--30">
                                <?php 
                                $link = get_sub_field('enlace');
                                if( $link ): 
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                    ?>
                                    <a class="complete-slide-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                                        
                                    </a>

                                    
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                        

                </div>
            </div>
        </div>
    </div>
</section>


    
<?php endif; ?>
