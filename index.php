<?php
get_header();

?><main>
	
	<section class="has-sidebar blog"><div class="loop"><?php
		if (have_posts()) :
		   while (have_posts()) :
		      the_post();
		      	 ?>
		      	 	<article><header><h1><?php the_title(); ?></h1></header></article>
		      	 	<article><?php the_content(); ?></article>
		      	 <?php
		   endwhile;
		endif;
		?><aside><h4>Latests Posts</h4><ul><?php
			$recent_posts = wp_get_recent_posts();
			foreach( $recent_posts as $recent ){
				echo '<li><a href="' . get_permalink($recent["ID"]) . '">' . $recent["post_title"].'</a></li> ';
			}
			wp_reset_query();
		?></ul></aside><?php
	?></div></section><?php


?></main><?php

	get_footer(); 
?>