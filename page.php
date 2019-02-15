<?php get_header(); ?>
<div class="main">
  <div class="content-container" data-aos="fade-in" data-aos-duration="1000">
    <div class="content">

      <?php
        if(is_front_page()){
          $args = array( 'post_type' => 'banner', 'orderby' => 'menu_order', 'order' => 'ASC' );
          $the_query = new WP_Query( $args );
          $num_banners = $the_query->post_count;

          ?>

          <div class="news">

          <div class="news__navigation">
              <?php for ( $i = 0; $i < $num_banners; $i++ ){ ?>
                <a href="javascript:void(0);" class="news__icon" data-news="<?php echo $i; ?>"></a>
              <?php } ?>
            </div>

          <?php

          if ($the_query->have_posts()) : ?>
            <?php while ($the_query->have_posts()) : $the_query->the_post();

              $url = get_post_meta($post->ID, 'banner_url', true);
              $url_text = get_post_meta($post->ID, 'banner_url_text', true);
              ?>
                <div class="news__container">
                  <div class="news__heading"><?php echo the_title(); ?></div>
                  <div class="news__text">
                    <?php echo wpautop(get_the_content(), true); ?>
                  </div>
                  <a
                    class="button news__button"
                    href="<?php echo esc_url( $url ); ?>">
                      <?php echo _e( $url_text ); ?>
                      <i class="fas fa-caret-right"></i>
                      <i class="fas fa-caret-right"></i>
                      <i class="fas fa-caret-right"></i>
                  </a>
                </div>
              <?php
            endwhile;
          endif;
          wp_reset_postdata();
          ?> </div>

        <?php }

        if ( have_posts() ) : while ( have_posts() ) : the_post();

          get_template_part( 'templates/content', get_post_format() );

        endwhile; endif;
      ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>