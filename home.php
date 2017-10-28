<?php
get_header();

?><div class="container">
	
	<div class="row" id="mainContent">
		<div class="col-lg-8"><?php

			if (have_posts()) :
			   while (have_posts()) :
			      the_post();
			         the_content();
			   endwhile;
			endif;

		?></div>
		<div class="col-lg-4"><h2>Latests Posts</h2><ul><?php
			$recent_posts = wp_get_recent_posts();
			foreach( $recent_posts as $recent ){
				echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
			}
			wp_reset_query();
		?></ul></div><?php
	?></div><?php


?></div><?php

	get_footer(); 
?>