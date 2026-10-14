<?php
/**
 * Aberdeen Theme Header (Figma Exact Match)
 *
 * @package Aberdeen_Theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
	<div class="aberdeen-container header-inner">
		<!-- Brand Logo (Exact Figma Image) -->
		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-link" <?php echo program_track_attr( 'link', 'header-logo', 'header-navigation', 'componentLink' ); ?>>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo_image.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="aberdeen-logo-img">
			</a>
		</div>

		<!-- Navigation Menu (Figma Exact Links) -->
		<nav class="main-navigation" id="main-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'aberdeen-theme' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) :
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-menu',
					'fallback_cb'    => false,
				) );
			else :
			?>
				<ul class="nav-menu">
					<li><a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" <?php echo program_track_attr( 'link', 'nav-study', 'header-navigation', 'componentLink' ); ?>>Study</a></li>
					<li><a href="#our-programmes" <?php echo program_track_attr( 'link', 'nav-admission', 'header-navigation', 'componentLink' ); ?>>Admission</a></li>
					<li><a href="#careers-section" <?php echo program_track_attr( 'link', 'nav-about-us', 'header-navigation', 'componentLink' ); ?>>About Us</a></li>
					<li><a href="#" <?php echo program_track_attr( 'link', 'nav-alumni', 'header-navigation', 'componentLink' ); ?>>Alumni</a></li>
					<li><a href="#site-footer" <?php echo program_track_attr( 'link', 'nav-contact-us', 'header-navigation', 'componentLink' ); ?>>Contact Us</a></li>
				</ul>
			<?php endif; ?>
		</nav>

		<!-- Right Action Section (Apply Now Button & Mobile Toggle) -->
		<div class="header-right-action">
			<button type="button" class="btn btn-apply-now btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'header-apply-now', 'header-navigation', 'componentButton' ); ?>>
				Apply Now
			</button>
			<!-- Mobile Hamburger -->
			<button type="button" class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle Navigation', 'aberdeen-theme' ); ?>">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
	</div>

	<!-- Header Sub-Divider Line with UK Text Link (Figma Exact Match) -->
	<div class="header-divider-row">
		<div class="aberdeen-container header-divider-inner">
			<a href="https://www.abdn.ac.uk" target="_blank" rel="noopener noreferrer" class="uk-link" <?php echo program_track_attr( 'link', 'aberdeen-uk-link', 'header-navigation', 'componentLink' ); ?>>
				University of Aberdeen UK
			</a>
		</div>
	</div>
</header>
<main id="primary" class="site-main">
