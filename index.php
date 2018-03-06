<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<!-- BREADCRUMB NAVIGATION -->
	<?php if( function_exists('bcn_display') ) : ?>
		<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
			<?php bcn_display(); ?>
		</div>
	<?php endif; ?>

	<!-- MAIN CONTENT --> 
	<main id="main" class="site-main" role="main">
	<section class="<?php if ( ! is_single() ) echo 'blog'; ?> has-sidebar">
	<div class="loop">

		<?php if ( ! is_single() ) : ?>
			<article>
				<header>
					<h1>Latest Posts</h1>
					<h2>Blog, News, etc</h2>

					<?php get_search_form(); ?>
				</header>
			</article>
		<?php endif; ?>

		<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					* Include the Post-Format-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that will be used instead.
					*/
					get_template_part( 'template-parts/post/content', get_post_format() );

				endwhile;

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
		?>

		
		<aside id="sidebar-categories">	
			<h4>Categories</h4>
			<?php
				$args = array(
					'title_li' => '' 
				);
				wp_list_categories( $args );
			?>
			
			<div id="sidebar-signup">
				<?php do_shortcode('[gravityform id=15 title=false description=false ajax=true tabindex=49]'); ?>
			</div>
		</aside>

	</div>
	</section><!-- blog -->
	</main><!-- #main -->


<?php get_footer();