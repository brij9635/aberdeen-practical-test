<?php
/**
 * Front Page Template (Figma Exact Match)
 * Interactive Hero Slider without Page Reload + Exact Assets
 *
 * @package Aberdeen_Theme
 */

get_header();

$theme_uri = get_template_directory_uri();
$hero_bg   = $theme_uri . '/assets/images/hero_image.jpg';
$careers_img = $theme_uri . '/assets/images/after_hero_section_img.png';
$undergrad_img = $theme_uri . '/assets/images/home_cours2.png';
$postgrad_img  = $theme_uri . '/assets/images/home_cours1.jpg';
?>

<!-- =========================================================================
     1. Hero Section: Exact Figma Match Slider (No Page Reload)
     ========================================================================= -->
<section class="hero-slider-section" id="hero-slider-section" style="background-image: url('<?php echo esc_url( $hero_bg ); ?>');">
	<div class="hero-slider-overlay"></div>

	<!-- Left Navigation Arrow (Figma Teal Box) -->
	<button type="button" class="hero-arrow hero-arrow-prev" id="hero-prev" aria-label="<?php esc_attr_e( 'Previous Slide', 'aberdeen-theme' ); ?>" <?php echo program_track_attr( 'button', 'hero-slider-prev', 'hero-carousel', 'componentButton' ); ?>>
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
			<polyline points="15 18 9 12 15 6"></polyline>
		</svg>
	</button>

	<!-- Right Navigation Arrow (Figma Teal Box) -->
	<button type="button" class="hero-arrow hero-arrow-next" id="hero-next" aria-label="<?php esc_attr_e( 'Next Slide', 'aberdeen-theme' ); ?>" <?php echo program_track_attr( 'button', 'hero-slider-next', 'hero-carousel', 'componentButton' ); ?>>
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
			<polyline points="9 18 15 12 9 6"></polyline>
		</svg>
	</button>

	<!-- Slider Content Wrapper -->
	<div class="aberdeen-container hero-slider-container">
		<div class="hero-slides-wrapper" id="hero-slides-wrapper">
			
			<!-- Slide 1 (Exact Figma Screenshot) -->
			<div class="hero-slide active" data-slide="0">
				<h1 class="hero-slide-title">Join the University of Aberdeen in India</h1>
				<p class="hero-slide-subtitle btn-open-modal" data-modal="lead-form-modal" role="button" tabindex="0" <?php echo program_track_attr( 'button', 'hero-slide-1-cta', 'hero-carousel', 'componentButton' ); ?>>
					Global challenges are waiting for new ways of thinking. Discover your true north and start creating a more inclusive and sustainable world 
					<span class="slide-arrow-gold">&rarr;</span>
				</p>
			</div>

			<!-- Slide 2 -->
			<div class="hero-slide" data-slide="1">
				<h1 class="hero-slide-title">World-Class British Degrees in Mumbai</h1>
				<p class="hero-slide-subtitle btn-open-modal" data-modal="lead-form-modal" role="button" tabindex="0" <?php echo program_track_attr( 'button', 'hero-slide-2-cta', 'hero-carousel', 'componentButton' ); ?>>
					Equipping future innovators with cutting-edge artificial intelligence, software engineering, and global business curricula 
					<span class="slide-arrow-gold">&rarr;</span>
				</p>
			</div>

			<!-- Slide 3 -->
			<div class="hero-slide" data-slide="2">
				<h1 class="hero-slide-title">Admissions Open for Academic Year 2025-26</h1>
				<p class="hero-slide-subtitle btn-open-modal" data-modal="lead-form-modal" role="button" tabindex="0" <?php echo program_track_attr( 'button', 'hero-slide-3-cta', 'hero-carousel', 'componentButton' ); ?>>
					Apply now for undergraduate and postgraduate programmes with international faculty and scholarship opportunities 
					<span class="slide-arrow-gold">&rarr;</span>
				</p>
			</div>

		</div>

		<!-- 3 Slider Dots (Figma Exact) -->
		<div class="hero-dots-nav" id="hero-dots" role="tablist" aria-label="<?php esc_attr_e( 'Hero Slide Dots', 'aberdeen-theme' ); ?>">
			<button type="button" class="hero-dot active" data-index="0" aria-label="<?php esc_attr_e( 'Go to slide 1', 'aberdeen-theme' ); ?>" <?php echo program_track_attr( 'button', 'hero-dot-1', 'hero-carousel', 'componentButton' ); ?>></button>
			<button type="button" class="hero-dot" data-index="1" aria-label="<?php esc_attr_e( 'Go to slide 2', 'aberdeen-theme' ); ?>" <?php echo program_track_attr( 'button', 'hero-dot-2', 'hero-carousel', 'componentButton' ); ?>></button>
			<button type="button" class="hero-dot" data-index="2" aria-label="<?php esc_attr_e( 'Go to slide 3', 'aberdeen-theme' ); ?>" <?php echo program_track_attr( 'button', 'hero-dot-3', 'hero-carousel', 'componentButton' ); ?>></button>
		</div>
	</div>
</section>

<!-- =========================================================================
     2. Careers and Employability Section (Figma Exact Screenshot Match)
     ========================================================================= -->
<section class="careers-section" id="careers-section">
	<div class="aberdeen-container">
		<!-- Section Heading with underline bar -->
		<div class="careers-heading-wrapper">
			<h2 class="careers-main-title">Careers and Employability</h2>
			<div class="careers-title-bar"></div>
		</div>

		<div class="careers-grid">
			<!-- Image Column (Exact after_hero_section_img.png) -->
			<div class="careers-media">
				<img src="<?php echo esc_url( $careers_img ); ?>" alt="<?php esc_attr_e( 'Careers and Employability', 'aberdeen-theme' ); ?>" class="careers-img">
			</div>

			<!-- Content Column with exact screenshot text & See More button -->
			<div class="careers-content">
				<p class="careers-paragraph">
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
				</p>
				<p class="careers-paragraph">
					Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
				</p>
				<div class="careers-cta">
					<button type="button" class="btn btn-see-more btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'careers-see-more', 'careers-overview', 'componentButton' ); ?>>
						See More
					</button>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- =========================================================================
     3. Our Programmes Section (Figma Exact Match)
     ========================================================================= -->
<section class="programmes-section" id="our-programmes">
	<div class="aberdeen-container">
		<!-- Centered Gold Heading with Underline Bar -->
		<div class="programmes-heading-wrapper">
			<h2 class="programmes-main-title">Our Programmes</h2>
			<div class="programmes-title-bar"></div>
		</div>

		<!-- Two Main Program Track Cards (Figma Exact Match) -->
		<div class="programme-tracks-grid">
			<!-- Track 1: Undergraduate (home_cours2.png) -->
			<div class="track-card">
				<div class="track-img-container">
					<img src="<?php echo esc_url( $undergrad_img ); ?>" alt="<?php esc_attr_e( 'Undergraduate Programmes', 'aberdeen-theme' ); ?>" class="track-hero-img">
				</div>
				<div class="track-body">
					<h3 class="track-title">Undergraduate Programmes</h3>
					<div class="track-divider"></div>
					<p class="track-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante tortor.</p>
					<a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>" class="track-see-more" <?php echo program_track_attr( 'link', 'home-card-undergrad', 'programme-tracks', 'componentLink' ); ?>>
						<span class="see-more-text">See More</span>
						<i class="fa-solid fa-arrow-right track-arrow"></i>
					</a>
				</div>
			</div>

			<!-- Track 2: Postgraduate (home_cours1.jpg) -->
			<div class="track-card">
				<div class="track-img-container">
					<img src="<?php echo esc_url( $postgrad_img ); ?>" alt="<?php esc_attr_e( 'Postgraduate Programmes', 'aberdeen-theme' ); ?>" class="track-hero-img">
				</div>
				<div class="track-body">
					<h3 class="track-title">Postgraduate Programmes</h3>
					<div class="track-divider"></div>
					<p class="track-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante tortor.</p>
					<a href="<?php echo esc_url( home_url( '/programmes/postgraduate' ) ); ?>" class="track-see-more" <?php echo program_track_attr( 'link', 'home-card-postgrad', 'programme-tracks', 'componentLink' ); ?>>
						<span class="see-more-text">See More</span>
						<i class="fa-solid fa-arrow-right track-arrow"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
