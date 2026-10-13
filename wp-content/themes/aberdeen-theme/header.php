<?php
/**
 * Aberdeen Theme Header
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
		<!-- Brand Logo -->
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-link" <?php echo program_track_attr( 'link', 'header-logo', 'header-navigation', 'componentLink' ); ?>>
					<div class="brand-crest">
						<span class="crest-icon">🎓</span>
					</div>
					<div class="brand-text">
						<span class="brand-title">UNIVERSITY OF</span>
						<span class="brand-name">ABERDEEN</span>
					</div>
				</a>
			<?php endif; ?>
		</div>

		<!-- Navigation Menu -->
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
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo program_track_attr( 'link', 'nav-home', 'header-navigation', 'componentLink' ); ?>>Home</a></li>
					<li><a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" <?php echo program_track_attr( 'link', 'nav-programmes', 'header-navigation', 'componentLink' ); ?>>Programmes</a></li>
					<li><a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>" <?php echo program_track_attr( 'link', 'nav-undergrad', 'header-navigation', 'componentLink' ); ?>>Undergraduate</a></li>
					<li><a href="<?php echo esc_url( home_url( '/programmes/postgraduate' ) ); ?>" <?php echo program_track_attr( 'link', 'nav-postgrad', 'header-navigation', 'componentLink' ); ?>>Postgraduate</a></li>
				</ul>
			<?php endif; ?>
		</nav>

		<!-- Header CTA Button (Figma) -->
		<div class="header-actions">
			<button type="button" class="btn btn-gold btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'open-enquiry-form', 'header-navigation', 'componentButton' ); ?>>
				<?php echo esc_html( get_theme_mod( 'aberdeen_header_enquire_label', 'Enquire Now' ) ); ?>
			</button>
			<!-- Mobile Hamburger -->
			<button type="button" class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle Navigation', 'aberdeen-theme' ); ?>">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
	</div>
</header>
<main id="primary" class="site-main">
