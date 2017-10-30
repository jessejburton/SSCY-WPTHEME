</div>

<footer id="footer" class="dark-background">
	<ul>
		<?php
			if(is_active_sidebar('footer-sidebar-1')){
				dynamic_sidebar('footer-sidebar-1');
			}
			if(is_active_sidebar('footer-sidebar-2')){
				dynamic_sidebar('footer-sidebar-2');
			}
			if(is_active_sidebar('footer-sidebar-3')){
				dynamic_sidebar('footer-sidebar-3');
			}
			if(is_active_sidebar('footer-sidebar-4')){
				dynamic_sidebar('footer-sidebar-4');
			}
		?>
	</ul>
</footer>


<?php wp_footer(); ?>

</body>
</html>