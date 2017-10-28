<?php
get_header();

?><div class="container">
	
	<div class="row" id="mainContent">
		<div class="col-lg-8"><?php

			if (have_posts()) :
			   while (have_posts()) :
			      the_post();
			         the_content();
			   endwhile;
			endif;

		?></div>
		<div class="col-lg-4"><?php
			get_sidebar();
		?></div><?php
	?></div><?php


?></div><?php

	get_footer(); 
?>