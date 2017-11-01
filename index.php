<?php
get_header();

?><main>
	
	<section class="blog"><?php
		if (have_posts()) :
		   while (have_posts()) :
		      the_post();
		      	 ?>
		      	 	<article><header><h1><?php the_title(); ?></h1></header></article>
		      	 	<article><?php the_content(); ?></article>
		      	 <?php
		   endwhile;
		endif;
	?></section><?php

?></main><?php

	get_footer(); 
?>