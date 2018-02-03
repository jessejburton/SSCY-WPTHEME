<?php
get_header();

?><main><div class="loop">

    <section>

        <article class="page-header">
            <?php if ( have_posts() ) : ?>
                <h3 class="page-title"><?php printf( __( 'Search Results for: %s', 'saltspringcentre' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
            <?php else : ?>
                <h3 class="page-title"><?php _e( 'Nothing Found', 'saltspringcentre' ); ?></h3>
            <?php endif; ?>
        </article>

        <article>
            <?php
            if ( have_posts() ) :
                /* Start the Loop */
                while ( have_posts() ) : the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php if ( 'post' === get_post_type() ) : ?>
                            <?php elseif ( 'page' === get_post_type() && get_edit_post_link() ) : ?>
                            <?php endif; ?>

                            <?php if ( is_front_page() && ! is_home() ) {

                                // The excerpt is being displayed within a front page section, so it's a lower hierarchy than h2.
                                the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
                            } else {
                                the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                            } ?>
                        </header><!-- .entry-header -->

                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div><!-- .entry-summary -->

                    </article><!-- #post-## -->
                <?php

                endwhile; // End of the loop.

            else : ?>

                <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen' ); ?></p>
                <?php
                    get_search_form();

            endif;
            ?>
        </article>
    </section>

?></div></main><?php

get_footer(); 
?>