<div class="row content-panel <?php echo get_post_meta($current_post->ID, 'background-color')[0]; ?>">
	<div class="container">
		<h1><?php echo $current_post->post_title; ?></h1>
    	<?php echo $current_post->post_content; ?>
	</div>
</div>