<?php
/*
Template Name: Yoga Teacher Training
*/
?>

<?php get_header(); ?>
<div class="main">
  <div class="content-container content-container--sidebar" data-aos="fade-in" data-aos-duration="1000">
    <div class="sidebar">
      <div class="sidebar__navigation">
        <h2>Links</h2>
        <?php wp_nav_menu( array( 'theme_location' => 'ytt-menu' ) ); ?>
      </div>
    </div>
    <div class="content">
      <?php
          if ( have_posts() ) : while ( have_posts() ) : the_post();

            get_template_part( 'templates/content', get_post_format() );

          endwhile; endif;
        ?>
    </div>
  </div>

</div>
<?php get_footer(); ?>