<?php
/*
*
Template Name: Child Panels
*
*/

get_header();

?><main><div class="loop"><?php

	if (have_posts()) :
	   while (have_posts()) :
	      the_post();
			?>
			<section class="<?php echo get_post_meta($post->ID, 'background-color')[0]; ?>">
				<article>
					<?php if ( get_post_meta($post->ID, 'show-heading')[0] == 'yes' ){ ?>
						<h1><?php the_title(); ?></h1>
					<?php } ?>
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
						<?php if ( get_post_meta($child->ID, 'show-heading')[0] == 'yes' ){ ?>
							<h1><?php the_title(); ?></h1>
						<?php } ?>
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