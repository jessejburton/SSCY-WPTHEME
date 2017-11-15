<?php
get_header();

?><main><div class="loop">
	<?php

	if (have_posts()) :
	   ?>
	   	<section>
			<article>
				<h1>Community Opportunities</h1>
			</article>
		</section>
	<?php

	   while (have_posts()) :
	      the_post();
	      	?>
			<section>
				<article>
					<h2><?php the_title(); ?></h2>
			    	<?php the_excerpt(); ?>
				</article>
			</section>
			<?php
	   endwhile;
	endif;

?></div></main><?php

get_footer(); 
?>