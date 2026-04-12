<?php
get_header();

$archive_link = get_post_type_archive_link( 'video' );
?>

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php
        $tags              = get_the_terms( get_the_ID(), 'post_tag' );
        $video_categories  = get_the_terms( get_the_ID(), 'categorias_video' );
        $primary_category  = ( ! empty( $video_categories ) && ! is_wp_error( $video_categories ) ) ? reset( $video_categories ) : null;
        $primary_cat_link  = $primary_category ? get_term_link( $primary_category ) : '';
        $current_url       = get_permalink();
        $share_title       = rawurlencode( get_the_title() );
        $share_url         = rawurlencode( $current_url );
        $facebook_url      = 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url;
        $twitter_url       = 'https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_title;
        $linkedin_url      = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url;
        $pinterest_url     = 'https://pinterest.com/pin/create/button/?url=' . $share_url . '&description=' . $share_title;
        $mail_url          = 'mailto:?subject=' . $share_title . '&body=' . $share_url;
        $embed_url         = expreso_get_video_embed_url( get_the_ID() );
        ?>

        <section class="breadcrumb-section">
            <h2 class="sr-only">Site Breadcrumb</h2>
            <div class="container">
                <div class="breadcrumb-contents">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
                            <?php if ( $archive_link ) : ?>
                                <li class="breadcrumb-item"><a href="<?php echo esc_url( $archive_link ); ?>">Videos</a></li>
                            <?php endif; ?>
                            <?php if ( $primary_category && ! is_wp_error( $primary_cat_link ) ) : ?>
                                <li class="breadcrumb-item"><a href="<?php echo esc_url( $primary_cat_link ); ?>"><?php echo esc_html( $primary_category->name ); ?></a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        <section class="inner-page-sec-padding-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 mb--60 mb-lg--0">
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post post-details mb--50' ); ?>>
                            <?php if ( $embed_url ) : ?>
                                <div class="blog-video">
                                    <iframe src="<?php echo esc_url( $embed_url ); ?>" allow="autoplay; encrypted-media; picture-in-picture; fullscreen" class="w-100" height="400" allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                </div>
                            <?php elseif ( has_post_thumbnail() ) : ?>
                                <div class="blog-image">
                                    <?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) ); ?>
                                </div>
                            <?php endif; ?>

                            <div class="blog-content mt--30">
                                <header>
                                    <h1 class="blog-title"><?php the_title(); ?></h1>
                                    <div class="post-meta">
                                        <span class="post-date">
                                            <i class="far fa-calendar-alt"></i>
                                            <span class="text-gray">Fecha: </span>
                                            <?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
                                        </span>
                                        <span class="post-separator">|</span>
                                        <span class="post-author">
                                            <i class="fas fa-folder-open"></i>
                                            <span class="text-gray">Tipo: </span>
                                            Video
                                        </span>
                                    </div>
                                </header>

                                <article class="entry-content">
                                    <h2 class="sr-only">Contenido del video</h2>
                                    <?php the_content(); ?>
                                    <?php
                                    wp_link_pages(
                                        array(
                                            'before' => '<div class="page-links">',
                                            'after'  => '</div>',
                                        )
                                    );
                                    ?>
                                </article>

                                <?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
                                    <footer class="blog-meta">
                                        <div>
                                            TAGS:
                                            <?php foreach ( $tags as $index => $tag ) : ?>
                                                <?php if ( $index > 0 ) : ?>, <?php endif; ?>
                                                <a href="<?php echo esc_url( get_term_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </footer>
                                <?php endif; ?>
                            </div>
                        </article>

                        <div class="share-block mb--50">
                            <h3>Compartir</h3>
                            <div class="social-links justify-content-center mt--10">
                                <a href="<?php echo esc_url( $facebook_url ); ?>" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="Compartir en Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="<?php echo esc_url( $twitter_url ); ?>" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="Compartir en X"><i class="fab fa-twitter"></i></a>
                                <a href="<?php echo esc_url( $pinterest_url ); ?>" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="Compartir en Pinterest"><i class="fab fa-pinterest-p"></i></a>
                                <a href="<?php echo esc_url( $linkedin_url ); ?>" class="single-social social-rounded" target="_blank" rel="noopener noreferrer" aria-label="Compartir en LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                <a href="<?php echo esc_url( $mail_url ); ?>" class="single-social social-rounded" aria-label="Compartir por correo"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <?php get_template_part( 'template-parts/sidebar/sidebar', 'content' ); ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
