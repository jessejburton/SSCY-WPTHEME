
<footer class="footer">
  <div class="footer__widgets">
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
  </div>
  <div class="footer__brand">
    <a href="portal/"><img class="footer__brand-image" src="<?php echo get_template_directory_uri() . '/dist/images/sscy_text_white.svg'; ?>" /></a>
  </div>
</footer>

<?php require_once('templates/modal.php'); ?>

<?php wp_footer(); ?>

</body>
</html>