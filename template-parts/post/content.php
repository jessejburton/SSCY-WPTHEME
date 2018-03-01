<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

    <article class="post-preview" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-thumbnail">
                <?php the_post_thumbnail('',['class' => 'thumbnail']); ?>
            </a>
        <?php endif; ?>
        
        <header class="entry-header">
            <?php
                if ( is_single() ) {
                    the_title( '<h1 class="entry-title">', '</h1>' );
                } else {
                    the_title( '<h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
                }
            ?>
        </header>

        <?php if ( is_single() ) :
            the_content();
        else :
            the_excerpt();
        endif; ?>

        <?php if ( ! is_single() ) : ?>
            <footer>
                <p>Posted on <?php the_time( 'F jS, Y' ); ?> by <?php the_author_posts_link(); ?>.</p>
            </footer>
        <?php endif; ?>

    </article><!-- #post-## -->
