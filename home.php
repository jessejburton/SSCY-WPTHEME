<?php
get_header();

?><main>
	
	<section class="blog"><div class="loop"><?php
		if (have_posts()) :
		   while (have_posts()) :
		      the_post();
		      	 ?>
		      	 	<article>
		      	 		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-thumbnail">
							<?php the_post_thumbnail( $size = 'post-thumbnail', $attr = '' ); ?>
						</a>
			      	 	<header>
							<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
						</header>
			      	 	<?php the_excerpt(); ?>
			      	 	<footer>
							<p>POSTED ON <?php the_time( 'F jS, Y' ); ?> by <?php the_author_posts_link(); ?>.</p>
						</footer>
			      	</article>
		      	 <?php
		   endwhile;
		endif;
	?></div></section><?php

?></main><?php

	get_footer(); 
?>
