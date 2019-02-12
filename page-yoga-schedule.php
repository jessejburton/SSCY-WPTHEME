<?php
/*
Template Name: Yoga Schedule
*/
?>

<?php get_header(); ?>
<div class="main">
  <div class="content-container" data-aos="fade-in" data-aos-duration="1000">
    <div class="content">
      <?php
          if ( have_posts() ) : while ( have_posts() ) : the_post();

            get_template_part( 'templates/content', get_post_format() );

          endwhile; endif;

          require_once( get_template_directory() . '/sscy/yoga_schedule.php');
      ?>
    </div>
  </div>

</div>
<?php get_footer(); ?>