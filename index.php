<?php
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
			<section class="<?php echo get_post_meta($post->ID, 'background-color')[0]; ?> <?php echo ( get_post_type() == 'post' ? 'has-sidebar' : '')?>">
				<article>
					<?php if ( !isset( get_post_meta($post->ID, 'show-heading')[0] ) || get_post_meta($post->ID, 'show-heading')[0] == 'yes' ){ ?>
						<h1><?php the_title(); ?></h1>
					<?php } ?>
			    	<?php the_content(); ?>
				</article>

				<!-- If this is a single blog post show the recent posts -->
				<?php 
					if( get_post_type() == 'post'){
						if( is_category() ){
							$category_name = single_cat_title( '', false );
							$category_id = get_cat_id( $category_name );

							$args = array(
								'numberposts' => 30,
								'category' => $category_id
							);

							?>
								<aside>	
									<h4>Recent <?php echo single_cat_title(); ?> Posts</h4>

									<?php
										$recent_posts = wp_get_recent_posts( $args );
										foreach( $recent_posts as $recent ){
											echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
										}
										wp_reset_query();
									?>
								</aside>
						<?php } else { ?>
							<aside>	
								<h4>Categories</h4>
								<?php
									$args = array(
										'title_li' => '' 
									);
									wp_list_categories( $args );
								?>
							</aside>
						<?php	
						}
					};
				?>
			</section>
			<?php
	   endwhile;
	endif;

?></div></main><?php

get_footer();
?>
