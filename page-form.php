<?php
get_header();

?><main><div class="loop"><?php

	// Bread Crumb Navigation
	?>
	<section><article class="breadcrumb">
		<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
		    <?php if(function_exists('bcn_display'))
		    {
		        bcn_display();
		   	}?>
		</div>
	</article></section>
	<?php

	if (have_posts()) :
	   while (have_posts()) :
	      the_post();
	      	?>
			<section class="<?php echo get_post_meta($post->ID, 'background-color')[0]; ?>">
				<article>
					<h1>FORM TEMPLATE <?php the_title(); ?></h1>
			    	<?php the_content(); ?>
				</article>
			</section>
			<?php
	   endwhile;
	endif;

?></div></main><?php

get_footer(); 
?>