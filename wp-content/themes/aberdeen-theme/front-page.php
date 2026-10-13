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
				<h1 class="hero-slide-title">Join the University of Aberdeen India</h1>
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

		<!-- 3 Slider Dots (Figma Exact: Active filled, Others hollow) -->
		<div class="hero-dots-nav" id="hero-dots" role="tablist" aria-label="<?php esc_attr_e( 'Hero Slide Dots', 'aberdeen-theme' ); ?>">
			<button type="button" class="hero-dot active" data-index="0" aria-label="<?php esc_attr_e( 'Go to slide 1', 'aberdeen-theme' ); ?>" <?php echo program_track_attr( 'button', 'hero-dot-1', 'hero-carousel', 'componentButton' ); ?>></button>
			<button type="button" class="hero-dot" data-index="1" aria-label="<?php esc_attr_e( 'Go to slide 2', 'aberdeen-theme' ); ?>" <?php echo program_track_attr( 'button', 'hero-dot-2', 'hero-carousel', 'componentButton' ); ?>></button>
			<button type="button" class="hero-dot" data-index="2" aria-label="<?php esc_attr_e( 'Go to slide 3', 'aberdeen-theme' ); ?>" <?php echo program_track_attr( 'button', 'hero-dot-3', 'hero-carousel', 'componentButton' ); ?>></button>
		</div>
	</div>
</section>

<!-- =========================================================================
     2. Careers and Employability Section (Figma Desktop)
     ========================================================================= -->
<section class="careers-section section-padding" id="careers-section">
	<div class="aberdeen-container">
		<div class="careers-grid">
			<!-- Image Column (Exact after_hero_section_img.png) -->
			<div class="careers-media">
				<img src="<?php echo esc_url( $careers_img ); ?>" alt="<?php esc_attr_e( 'Students at Aberdeen', 'aberdeen-theme' ); ?>" class="careers-img">
			</div>

			<!-- Content Column -->
			<div class="careers-content">
				<span class="section-tag">Global Pathways</span>
				<h2 class="section-title">Careers and Employability</h2>
				<p class="section-text">
					Our globally recognized degrees equip graduates with cutting-edge skills, professional accreditations, and strong industry linkages to thrive in international careers.
				</p>
				<div class="careers-features">
					<div class="feature-item">
						<span class="feature-check">✓</span>
						<span>Internships with Global Tech & Business Leaders</span>
					</div>
					<div class="feature-item">
						<span class="feature-check">✓</span>
						<span>Dual Campus Study Opportunities in UK & India</span>
					</div>
					<div class="feature-item">
						<span class="feature-check">✓</span>
						<span>96% Graduate Employment Rate</span>
					</div>
				</div>
				<div class="careers-cta">
					<button type="button" class="btn btn-gold btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'careers-read-more', 'careers-overview', 'componentButton' ); ?>>
						Read More
					</button>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- =========================================================================
     3. Our Programmes Section (Figma Desktop)
     ========================================================================= -->
<section class="programmes-section section-padding" id="our-programmes">
	<div class="aberdeen-container">
		<div class="section-header text-center">
			<span class="section-tag">Academic Excellence</span>
			<h2 class="section-title">Our Programmes</h2>
			<p class="section-subtitle">Choose from internationally accredited degrees designed to launch your global career.</p>
		</div>

		<!-- Two Main Program Track Cards (Figma Exact Images) -->
		<div class="programme-tracks-grid">
			<!-- Track 1: Undergraduate (home_cours2.png) -->
			<div class="track-card track-undergrad">
				<div class="track-img-container">
					<img src="<?php echo esc_url( $undergrad_img ); ?>" alt="<?php esc_attr_e( 'Undergraduate Programmes', 'aberdeen-theme' ); ?>" class="track-hero-img">
					<div class="track-tag">Undergraduate</div>
				</div>
				<div class="track-body">
					<h3 class="track-title">Undergraduate Programmes</h3>
					<p class="track-desc">Bachelor of Computer Application (BCA), Computer Engineering, and Software Design degrees.</p>
					<a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>" class="btn btn-outline-gold" <?php echo program_track_attr( 'link', 'home-card-undergrad', 'programme-tracks', 'componentLink' ); ?>>
						View Undergraduate Programmes &rarr;
					</a>
				</div>
			</div>

			<!-- Track 2: Postgraduate (home_cours1.jpg) -->
			<div class="track-card track-postgrad">
				<div class="track-img-container">
					<img src="<?php echo esc_url( $postgrad_img ); ?>" alt="<?php esc_attr_e( 'Postgraduate Programmes', 'aberdeen-theme' ); ?>" class="track-hero-img">
					<div class="track-tag">Postgraduate</div>
				</div>
				<div class="track-body">
					<h3 class="track-title">Postgraduate Programmes</h3>
					<p class="track-desc">Master of Computer Application (MCA), Data Science, and Executive Management degrees.</p>
					<a href="<?php echo esc_url( home_url( '/programmes/postgraduate' ) ); ?>" class="btn btn-outline-gold" <?php echo program_track_attr( 'link', 'home-card-postgrad', 'programme-tracks', 'componentLink' ); ?>>
						View Postgraduate Programmes &rarr;
					</a>
				</div>
			</div>
		</div>

		<!-- Featured Program Cards Grid (Figma) -->
		<div class="featured-programs-header">
			<h3 class="sub-heading">Featured Degree Programmes</h3>
			<a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" class="view-all-link" <?php echo program_track_attr( 'link', 'view-all-programmes', 'programme-overview', 'componentLink' ); ?>>
				Browse All Programmes &rarr;
			</a>
		</div>

		<div class="programs-grid grid-3-cols">
			<?php
			$featured_query = new WP_Query( array(
				'post_type'      => 'program',
				'posts_per_page' => 6,
				'post_status'    => 'publish',
			) );

			if ( $featured_query->have_posts() ) :
				while ( $featured_query->have_posts() ) :
					$featured_query->the_post();
					get_template_part( 'template-parts/program-card', null, array( 'post_id' => get_the_ID() ) );
				endwhile;
				wp_reset_postdata();
			else :
				// Demonstration cards matching Figma
				$demo_programs = array(
					array( 'title' => 'Bachelor of Computer Application (BCA)', 'year' => '2025-26', 'duration' => '3 Years', 'img' => $theme_uri . '/assets/images/program_img.jpg' ),
					array( 'title' => 'Bachelor of Engineering (B.E.) in CS', 'year' => '2025-26', 'duration' => '4 Years', 'img' => $theme_uri . '/assets/images/program_img2.jpg' ),
					array( 'title' => 'Master of Computer Application (MCA)', 'year' => '2025-26', 'duration' => '2 Years', 'img' => $theme_uri . '/assets/images/home_cours1.jpg' ),
				);
				foreach ( $demo_programs as $index => $demo ) :
			?>
				<article class="program-card">
					<div class="card-media">
						<img src="<?php echo esc_url( $demo['img'] ); ?>" alt="<?php echo esc_attr( $demo['title'] ); ?>" class="card-img">
					</div>
					<div class="card-body">
						<div class="card-meta">
							<span class="badge badge-year">📅 <?php echo esc_html( $demo['year'] ); ?></span>
							<span class="badge badge-duration">⏱️ <?php echo esc_html( $demo['duration'] ); ?></span>
						</div>
						<h3 class="card-title">
							<a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" class="card-link" <?php echo program_track_attr( 'link', 'demo-card-' . $index, 'programme-card', 'componentCard' ); ?>>
								<?php echo esc_html( $demo['title'] ); ?>
							</a>
						</h3>
					</div>
				</article>
			<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
</section>

<?php
get_footer();
