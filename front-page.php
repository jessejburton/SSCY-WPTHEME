<?php
get_header();

?><main><div class="loop"><?php

	if (have_posts()) :
	   while (have_posts()) :
	      the_post();
			set_query_var( 'current_post', $post );
            echo get_template_part( 'templates/panel' );

	        $childArgs = array(
	            'sort_order' => 'ASC',
	            'sort_column' => 'menu_order',
	            'child_of' => get_the_ID()
	        );
	        $childList = get_pages($childArgs);
	        foreach ($childList as $child) { 
	        	set_query_var( 'current_post', $child );
	            echo get_template_part( 'templates/panel' );
	        }
	   endwhile;
	endif;

?></div></main><?php

get_footer(); 
?>