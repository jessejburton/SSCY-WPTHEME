<?php get_header(); ?>
<div class="main">
  <div class="content-container error-404 not-found" data-aos="fade-in" data-aos-duration="1000">
    <header class="page-header">
      <h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'twentynineteen' ); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
      <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentynineteen' ); ?></p>
      <?php get_search_form(); ?>
    </div><!-- .page-content -->
  </div><!-- .error-404 -->
</div>
<?php get_footer(); ?>