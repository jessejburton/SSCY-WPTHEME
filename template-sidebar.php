<?php
/*
*
Template Name: Sidebar
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
			<section class="has-sidebar <?php echo get_post_meta($post->ID, 'background-color')[0]; ?>">
				<article>
					<?php if ( !isset( get_post_meta($post->ID, 'show-heading')[0] ) || get_post_meta($post->ID, 'show-heading')[0] == 'yes' ){ ?>
						<h1><?php the_title(); ?></h1>
					<?php } ?>
			    	<?php the_content(); ?>
				</article>

                <!-- Child Page Links -->
                <aside><ul>
                    <?php 
                        $childArgs = array(
                            'sort_order' => 'ASC',
                            'sort_column' => 'menu_order',
                            'child_of' => get_the_ID()
                        );
                        $childList = get_pages($childArgs);
                        foreach ($childList as $child) { 
                            ?>
                                <li><a href="<?php echo $child->guid; ?>"><?php echo $child->post_title; ?></a></li>
                            <?php
                        }
                    ?>
                </aside>
			</section>
			<?php
	   endwhile;
	endif;

?></div></main><?php

get_footer();
?>
