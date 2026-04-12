<?php get_header(); ?>

<?php
$expreso_page_sidebar = '';

if (is_active_sidebar('blog_sidebar')) {
  $expreso_page_sidebar = 'blog_sidebar';
} elseif (is_active_sidebar('post_sidebar')) {
  $expreso_page_sidebar = 'post_sidebar';
}
?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <?php $page_ancestors = array_reverse(get_post_ancestors(get_the_ID())); ?>

    <section class="breadcrumb-section">
      <h2 class="sr-only">Breadcrumb</h2>
      <div class="container">
        <div class="breadcrumb-contents">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Inicio</a></li>
              <?php foreach ($page_ancestors as $ancestor_id) : ?>
                <li class="breadcrumb-item">
                  <a href="<?php echo esc_url(get_permalink($ancestor_id)); ?>"><?php echo esc_html(get_the_title($ancestor_id)); ?></a>
                </li>
              <?php endforeach; ?>
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
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post post-details mb--50'); ?>>
              <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail mb--30">
                  <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                </div>
              <?php endif; ?>

              <div class="blog-content mt--30">
                <header>
                  <h1 class="blog-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                  <?php the_content(); ?>

                  <?php
                  wp_link_pages(
                      array(
                          'before' => '<div class="page-links">',
                          'after'  => '</div>',
                      )
                  );
                  ?>
                </div>
              </div>
            </article>

            <?php if (comments_open() || get_comments_number()) : ?>
              <?php comments_template(); ?>
            <?php endif; ?>
          </div>

          <div class="col-lg-3">
          <?php get_template_part( 'template-parts/sidebar/sidebar', 'content', array( 'sidebar_id' => $expreso_page_sidebar ) ); ?>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
