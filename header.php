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
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113699006-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-113699006-1');
	</script>

	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '177294809488823');
		fbq('track', 'PageView');
	</script>
	<noscript>
		<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=177294809488823&ev=PageView&noscript=1"/>
	</noscript>
	<!-- End Facebook Pixel Code -->

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

<header class="bright-background">
	<nav class="menu-header">
		<a class="home-link" href="#" title="Home">
			<span class="screen-reader">Home</span>
			<?php require_once( 'lotus-svg.php' ); ?>
		</a>
		<a class="mobile-nav" href="#" title="toggle menu" onclick="toggleMenu(0)">MENU</a>
		<?php wp_nav_menu( array( 'theme_location' => 'primary-menu' ) ); ?>
	</nav>
</header>

<?php if ( is_front_page() ) { ?>
<!-- Banner -->

<section class="hero">
	
	<div class="banner__arrow banner__arrow--left"></div>
	<div class="banner__arrow banner__arrow--right"></div>
	
	<article class="intro">
		<div class="branding active">
			<div class="branding__logo"><?php require_once( 'logo-svg.php' ); ?></div>
			<h1 class="screen-reader">Salt Spring Centre of Yoga</h1>
		</div>
		<?php
			$args = array( 'post_type' => 'banner', 'orderby' => 'menu_order', 'order' => 'ASC' );
			$the_query = new WP_Query( $args );
			$num_banners = $the_query->post_count;

			if ($the_query->have_posts()) :
				while ($the_query->have_posts()) : $the_query->the_post(); 

					$url = get_post_meta($post->ID, 'banner_url', true);
					$url_text = get_post_meta($post->ID, 'banner_url_text', true);
					?>
						<div class="branding">
							<h1 class="branding__title"><?php echo get_the_title(); ?></h1>
							<div class="branding__text"><?php echo get_the_content(); ?></div>
							<?php if( isset($url) ){
								?>
									<a href="<?php echo esc_url( $url ); ?>" class="branding__button"><?php echo _e( $url_text ); ?></a>
								<?php
							}?>
						</div>
					<?php
				endwhile;
			endif;
			wp_reset_postdata();
		?>

	</article>
	<div class="hero__navigation">
		<a href="#" class="active"><i class="fa fa-circle"></i></a>
		<?php
		$current_row = 0;
		while ( $current_row < $num_banners ){
		?>
			<a href="#"><i class="fa fa-circle"></i></a>
		<?php
			$current_row ++;
			}
		?>
	</div>
</section>

<?php } ?>