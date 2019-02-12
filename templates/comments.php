<?php require_once('comment.php'); ?>

<?php if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) return; ?>
<section id="comments">
  <?php
  if ( have_comments() ) :
    global $comments_by_type;
    $comments_by_type = &separate_comments( $comments );
    if ( ! empty( $comments_by_type['comment'] ) ) :
  ?>
    <section id="comments-list" class="comments">
      <h3 class="comments__title"><?php
        printf( _nx( 'One thought on "%2$s"', '%1$s thoughts on "%2$s"', get_comments_number(), 'comments title', 'saltspringcentre' ),
      number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
      ?></h3>
      <?php if ( get_comment_pages_count() > 1 ) : ?>
      <nav id="comments-nav-above" class="comments-navigation" role="navigation">
        <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
      </nav>
  <?php endif; ?>

  <ul class="comments__list">
    <?php wp_list_comments( 'type=comment&callback=saltspringcentre_comment' ); ?>
  </ul>

  <?php if ( get_comment_pages_count() > 1 ) : ?>
    <nav id="comments-nav-below" class="comments-navigation" role="navigation">
      <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
    </nav>
  <?php endif; ?>
</section>

<?php
  endif;
  if ( ! empty( $comments_by_type['pings'] ) ) :
  $ping_count = count( $comments_by_type['pings'] );
?>

<section id="trackbacks-list" class="comments">
  <h3 class="comments-title"><?php echo '<span class="ping-count">' . $ping_count . '</span> ' . ( $ping_count > 1 ? __( 'Trackbacks', 'blankslate' ) : __( 'Trackback', 'blankslate' ) ); ?></h3>
  <ul>
    <?php wp_list_comments( 'type=pings&callback=blankslate_custom_pings' ); ?>
  </ul>
</section>

<?php
endif;
endif;
if ( comments_open() ) comment_form();
?>
</section>