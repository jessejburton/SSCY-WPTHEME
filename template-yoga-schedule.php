<?php
/*
*
Template Name: Yoga Schedule (Mind Body)
*
*/

get_header();


// Bread Crumb Navigation
?>
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
		<?php if(function_exists('bcn_display'))
		{
				bcn_display();
		}?>
</div>

<main><div class="loop"><?php

	if (have_posts()) :
	   while (have_posts()) :
	      the_post();
	      	?>
			<section class="<?php echo get_post_meta($post->ID, 'background-color')[0]; ?>">
				<article>
					<?php if ( !isset( get_post_meta($post->ID, 'show-heading')[0] ) || get_post_meta($post->ID, 'show-heading')[0] == 'yes' ){ ?>
						<h1><?php the_title(); ?></h1>
					<?php } ?>
			    	<?php the_content(); ?>
				</article>
			</section>
			<?php
	   endwhile;
	endif;

?></div>

<!-- Mind Body Yoga Schedule Code -->
<script src="https://widgets.healcode.com/javascripts/healcode.js" type="text/javascript"></script>

<healcode-widget data-type="schedules" data-widget-partner="object" data-widget-id="4961510c0f5" data-widget-version="1"></healcode-widget>

</main><?php

get_footer();
?>
