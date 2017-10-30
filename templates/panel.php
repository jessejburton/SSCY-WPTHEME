<section class="<?php echo get_post_meta($current_post->ID, 'background-color')[0]; ?>">
	<article>
		<h1><?php echo $current_post->post_title; ?></h1>
    	<?php echo $current_post->post_content; ?>
	</article>
</section>