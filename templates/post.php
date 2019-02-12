<?php
  if ( is_single() ) {
    $addClass = 'single';
  } else {
    $addClass = '';
  }
?>

<article <?php post_class($addClass); ?> id="post-<?php the_ID(); ?>">

  <?php if ( !is_single() ) { ?>
    <div class="post__thumbnail">
      <?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
        <div class="post__thumbnail-container">
          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post__thumbnail-link">
              <?php the_post_thumbnail('',['class' => 'thumbnail']); ?>
          </a>
        </div>
      <?php endif; ?>
    </div>
  <?php } ?>

  <div class="post__content">
    <div class="post__header">
      <?php
        if ( is_single() ) {
            the_title( '<h1 class="post__title">', '</h1>' );
        } else {
            the_title( '<h3 class="post__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
        }
      ?>
    </div>

      <?php
      if ( is_single() ) :
          the_content();
      else :
          the_excerpt();
      endif;
    ?>

    <?php
      if ( ! is_single() ) : ?>
        <p class="post__date">Posted on <span><?php the_time( 'F jS, Y' ); ?></span> by <?php the_author_posts_link(); ?>.</p>
      <?php else : ?>
        <hr />
        <?php comments_template( '/templates/comments.php' );
      endif;
    ?>
  </div>
</article><!-- ## Post End ## -->