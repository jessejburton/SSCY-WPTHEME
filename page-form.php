<?php get_header(); ?>
<div class="main">
  <div class="content-container" data-aos="fade-in" data-aos-duration="1000">
    <div class="content">
    <?php
      if( is_numeric( get_query_var( 'fid' ) )){
        gravity_form( get_query_var( 'fid' ), true, true, false, '', false );
      } else {
        echo 'No form specified';
      };
    ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>