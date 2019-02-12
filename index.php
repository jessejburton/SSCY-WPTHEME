<?php get_header(); ?>
<div class="main">
  <div class="content-container content-container--sidebar" data-aos="fade-in" data-aos-duration="1000">
    <div class="sidebar">
      <div class="sidebar__navigation">
        <h2>Categories</h2>
        <ul>
          <?php
            $args = array(
              'title_li' => ''
            );
            wp_list_categories( $args );
          ?>
        </ul>
      </div>
    </div>
    <div class="content">
      <?php if (is_search()) { ?>
        <?php if ( have_posts() ) : ?>
            <h2 class="search__results"><?php printf( __( 'Search Results for: %s', 'saltspringcentre' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
        <?php else : ?>
            <h2 class="search__results"><?php _e( 'Nothing Found', 'saltspringcentre' ); ?></h2>
        <?php endif; ?>
      <?php } else { ?>
        <h1>Latest Posts</h1>
        <h2>Blog, News, etc</h2>
      <?php } ?>

      <div class="search__form">
        <?php get_search_form(); ?>
      </div>

      <?php
          if ( have_posts() ) : while ( have_posts() ) : the_post();

            get_template_part( 'templates/post', get_post_format() );

            ?> <hr /> <?php

          endwhile; endif;
        ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>