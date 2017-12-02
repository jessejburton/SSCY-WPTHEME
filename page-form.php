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
					<?php 
						if( is_numeric( get_query_var( 'fid' ) )){
							gravity_form( 1, true, true, false, '', false );
						} else {
							echo 'No form specified';
						};
					?>
				</article>
			</section>
			<?php
	   endwhile;
	endif;

?></div></main><?php

get_footer(); 
?>