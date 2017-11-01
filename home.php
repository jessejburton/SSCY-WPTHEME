<?php
get_header();

?><main>
	
	<section class="has-sidebar blog"><?php
			$recent_posts = wp_get_recent_posts(array('numberposts' => 1,'orderby' => 'post_date','order' => 'DESC'));
			foreach( $recent_posts as $recent ){ ?>
		      	 <article><header><h1><a href="<?php echo get_permalink($recent["ID"]) ?>"><?php echo $recent["post_title"] ?></a></h1></header></article>
		      	 <article><?php echo $recent["post_content"] ?></article><?php
			}
			wp_reset_query();

		?><aside><h4>Latests Posts</h4><ul><?php
			$recent_posts = wp_get_recent_posts();
			foreach( $recent_posts as $recent ){
				echo '<li><a href="' . get_permalink($recent["ID"]) . '">' . $recent["post_title"].'</a></li> ';
			}
			wp_reset_query();
		?></ul></aside><?php
	?></section><?php


?></main><?php

	get_footer(); 
?>