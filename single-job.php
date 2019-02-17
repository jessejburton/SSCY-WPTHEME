<?php get_header(); ?>
<div class="main">
  <div class="content-container" data-aos="fade-in" data-aos-duration="1000">
    <div class="content">
      <p><a href="<?php echo get_post_type_archive_link( 'job' ); ?>"><<< Back to opportunities</a></p>

      <?php
        if ( have_posts() ) : while ( have_posts() ) : the_post();

          get_template_part( 'templates/content', get_post_format() );

          if( !empty( get_post_meta(get_the_ID(), 'responsibilities', true) ) ) { ?>
            <section class="bright-background">
              <article>
                <h2>Responsibilities & Qualifications</h2>
                <?php echo get_post_meta(get_the_ID(), 'responsibilities', true); ?>
              </article>
            </section>
          <?php }

          if( !empty( get_post_meta(get_the_ID(), 'conditions', true) ) ) { ?>
            <section>
              <article>
                <h2>Working Conditions</h2>
                <?php echo get_post_meta(get_the_ID(), 'conditions', true); ?>
              </article>
            </section>
          <?php }

          if( !empty( get_post_meta(get_the_ID(), 'gravity_form_id', true) ) ) { ?>
            <section>
              <article>
                <p><a class="button" href="http://www.saltspringcentre.com/form/?fid=<?php echo get_post_meta(get_the_ID(), 'gravity_form_id', true); ?>">APPLY</a></p>
              </article>
            </section>
          <?php }

        endwhile; endif;
      ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>