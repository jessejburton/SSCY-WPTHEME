<?php
get_header();

// Bread Crumb Navigation
?>
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
		<?php if(function_exists('bcn_display'))
		{
				bcn_display();
		}?>
</div><main>
	
	<section class="blog has-sidebar">
		<article>
			<header>
				<h1>Latest Posts</h1>
				<h2>Blog, News, etc</h2>
			</header>
		<div class="loop"><?php
		if (have_posts()) :
		   while (have_posts()) :
		      the_post();
		      	 ?>
				<article class="post-preview">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-thumbnail">
						<?php the_post_thumbnail('',['class' => 'thumbnail']); ?>
					</a>
					<header>
						<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
					</header>
					<?php the_excerpt(); ?>
					<footer>
						<p>Posted on <?php the_time( 'F jS, Y' ); ?> by <?php the_author_posts_link(); ?>.</p>
					</footer>
				</article>
		      	 <?php
		   endwhile;
		endif;
	?>
		</article>
		</div>
		<aside>	
			<h4>Categories</h4>
			<?php
				$args = array(
					'title_li' => '' 
				);
				wp_list_categories( $args );
			?>
		</aside>
	</section><?php

?></main><?php

	get_footer(); 
?>