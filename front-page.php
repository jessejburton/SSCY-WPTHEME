<?php
get_header();

?><main><div class="loop"><?php

	if (have_posts()) :
	   while (have_posts()) :
	      the_post();
			?>
			<section class="<?php echo get_post_meta($post->ID, 'background-color')[0]; ?>">
				<article>
					<h1><?php the_title(); ?></h1>
			    	<?php the_content(); ?>
				</article>
			</section>
			<?php

	        $childArgs = array(
	            'sort_order' => 'ASC',
	            'sort_column' => 'menu_order',
	            'child_of' => get_the_ID()
	        );
	        $childList = get_pages($childArgs);
	        foreach ($childList as $child) { 
	        	?>
	        	<section class="<?php echo get_post_meta($child->ID, 'background-color')[0]; ?>">
					<article>
						<h1><?php echo $child->post_title; ?></h1>
				    	<?php echo $child->post_content; ?>
					</article>
				</section>
				<?php
	        }
	   endwhile;
	endif;

?></div></main><?php

get_footer(); 
?>