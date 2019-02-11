<?php get_header(); ?>
<div class="main">
  <div class="content-container" data-aos="fade-in" data-aos-duration="1000">
    <?php
				if ( have_posts() ) : while ( have_posts() ) : the_post();

					get_template_part( 'templates/content', get_post_format() );

				endwhile; endif;
			?>
  </div>
</div>
<?php get_footer(); ?>