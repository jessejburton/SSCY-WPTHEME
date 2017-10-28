<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package SSCY
 * @subpackage Salt_Spring_Centre_Theme
 * @since Salt Spring Centre Theme 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/vendor/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body>

<header id="header">
	<?php wp_nav_menu( array( 'theme_location' => 'primary-menu' ) ); ?>
</header>
