<?php get_header(); ?>
<div class="main">
  <div class="content-container" data-aos="fade-in" data-aos-duration="1000">
    <div class="content">
      <?php
        if (have_posts()) :

          ?><h1>Current Opportunities</h1><?php

          while (have_posts()) :
            the_post();
              if( get_post_meta(get_the_ID(), 'active', true) == 1 ){
          ?>

          <h2><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>

          <?php the_excerpt(); ?>

          <?php

              }

          endwhile;

        endif;
      ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>



