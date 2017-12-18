<?php
get_header();

?><main><div class="loop"><?php

	if (have_posts()) :
	   while (have_posts()) :
	      the_post();
	      	?>
			<section class="<?php echo get_post_meta($post->ID, 'background-color')[0]; ?>">
				<article>
					<?php 
						if( is_numeric( get_query_var( 'fid' ) )){
							gravity_form( get_query_var( 'fid' ), true, true, false, '', false );
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