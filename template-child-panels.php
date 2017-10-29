<?php
/*
*
Template Name: Child Panels
*
*/

global $child_content;

get_header();

	?><div class="row">
		<div class="container" id="mainContent">
			<div class="col-lg-12"><?php

				if (have_posts()) :
				   while (have_posts()) :
				      the_post(); ?>
			    		<?php the_content(); ?>

							</div>
						</div>
					</div>

				    <?php
				        $childArgs = array(
				            'sort_order' => 'ASC',
				            'sort_column' => 'menu_order',
				            'child_of' => get_the_ID()
				        );
				        $childList = get_pages($childArgs);
				        foreach ($childList as $child) { 
				        	set_query_var( 'content', apply_filters( 'the_content', $child->post_content) );
				        	set_query_var( 'current_post', $child );

				            echo get_template_part( 'templates/panel' );
				        }
				   endwhile;
				endif;

	get_footer(); 
?>