<?php
/**
 * Front Page Template (Home Page matching Figma Desktop Design)
 *
 * @package Aberdeen_Theme
 */

get_header();

// Customizer values
$hero_title    = get_theme_mod( 'aberdeen_hero_title', 'Join the University of Aberdeen in India' );
$hero_subtitle = get_theme_mod( 'aberdeen_hero_subtitle', 'Discover world-class undergraduate and postgraduate programmes delivered with British academic excellence.' );
$hero_cta_text = get_theme_mod( 'aberdeen_hero_cta_text', 'Explore Programmes' );
$hero_cta_url  = get_theme_mod( 'aberdeen_hero_cta_url', '#our-programmes' );
$hero_bg_image = get_theme_mod( 'aberdeen_hero_image', '' );

$careers_title    = get_theme_mod( 'aberdeen_careers_title', 'Careers and Employability' );
$careers_text     = get_theme_mod( 'aberdeen_careers_text', 'Our globally recognized degrees equip graduates with cutting-edge skills, professional accreditations, and strong industry linkages to thrive in international careers.' );
$careers_image    = get_theme_mod( 'aberdeen_careers_image', '' );
$careers_btn_text = get_theme_mod( 'aberdeen_careers_btn_text', 'Read More' );
$careers_btn_url  = get_theme_mod( 'aberdeen_careers_btn_url', '#our-programmes' );
?>

<!-- 1. Hero Section (Figma Desktop) -->
<section class="hero-section" id="hero-section" <?php if ( $hero_bg_image ) : ?>style="background-image: url('<?php echo esc_url( $hero_bg_image ); ?>');"<?php endif; ?>>
	<div class="hero-overlay"></div>
	<div class="aberdeen-container hero-content">
		<div class="hero-badge">🎓 Top 20 UK University (Guardian 2024)</div>
		<h1 class="hero-title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
		
		<div class="hero-buttons">
			<a href="<?php echo esc_url( $hero_cta_url ); ?>" class="btn btn-gold" <?php echo program_track_attr( 'link', 'hero-explore-programmes', 'hero-banner', 'componentLink' ); ?>>
				<?php echo esc_html( $hero_cta_text ); ?>
			</a>
			<button type="button" class="btn btn-outline-white btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'hero-open-enquiry', 'hero-banner', 'componentButton' ); ?>>
				Register Interest
			</button>
		</div>

		<!-- Slider Dots Indicator (Figma) -->
		<div class="slider-indicators" aria-hidden="true">
			<span class="dot active"></span>
			<span class="dot"></span>
			<span class="dot"></span>
		</div>
	</div>
</section>

<!-- 2. Careers and Employability Section (Figma Desktop) -->
<section class="careers-section section-padding" id="careers-section">
	<div class="aberdeen-container">
		<div class="careers-grid">
			<!-- Image Column -->
			<div class="careers-media">
				<?php if ( $careers_image ) : ?>
					<img src="<?php echo esc_url( $careers_image ); ?>" alt="<?php echo esc_attr( $careers_title ); ?>" class="careers-img">
				<?php else : ?>
					<div class="careers-placeholder-media">
						<div class="media-illustration">
							<span class="icon-campus">🏛️</span>
							<p>World-Class Campus Experience</p>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- Content Column -->
			<div class="careers-content">
				<span class="section-tag">Global Pathways</span>
				<h2 class="section-title"><?php echo esc_html( $careers_title ); ?></h2>
				<p class="section-text"><?php echo esc_html( $careers_text ); ?></p>
				<div class="careers-features">
					<div class="feature-item">
						<span class="feature-check">✓</span>
						<span>Internships with Global Tech & Business Leaders</span>
					</div>
					<div class="feature-item">
						<span class="feature-check">✓</span>
						<span>Dual Campus Study Opportunities</span>
					</div>
					<div class="feature-item">
						<span class="feature-check">✓</span>
						<span>96% Graduate Employment Rate</span>
					</div>
				</div>
				<div class="careers-cta">
					<a href="<?php echo esc_url( $careers_btn_url ); ?>" class="btn btn-gold" <?php echo program_track_attr( 'link', 'careers-read-more', 'careers-overview', 'componentLink' ); ?>>
						<?php echo esc_html( $careers_btn_text ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- 3. Our Programmes Section (Figma Desktop) -->
<section class="programmes-section section-padding" id="our-programmes">
	<div class="aberdeen-container">
		<div class="section-header text-center">
			<span class="section-tag">Academic Excellence</span>
			<h2 class="section-title">Our Programmes</h2>
			<p class="section-subtitle">Choose from internationally accredited degrees designed to launch your global career.</p>
		</div>

		<!-- Two Main Program Track Cards (Figma) -->
		<div class="programme-tracks-grid">
			<!-- Card 1: Undergraduate -->
			<div class="track-card track-undergrad">
				<div class="track-media">
					<div class="track-tag">Undergraduate</div>
					<div class="track-illustration">💻 AI & Computing</div>
				</div>
				<div class="track-body">
					<h3 class="track-title">Undergraduate Programmes</h3>
					<p class="track-desc">Comprehensive 3 & 4 year degrees in Computer Applications, Software Engineering, and International Business.</p>
					<a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>" class="btn btn-outline-gold" <?php echo program_track_attr( 'link', 'home-card-undergrad', 'programme-tracks', 'componentLink' ); ?>>
						View Undergraduate Programmes &rarr;
					</a>
				</div>
			</div>

			<!-- Card 2: Postgraduate -->
			<div class="track-card track-postgrad">
				<div class="track-media">
					<div class="track-tag">Postgraduate</div>
					<div class="track-illustration">🔬 Advanced Engineering</div>
				</div>
				<div class="track-body">
					<h3 class="track-title">Postgraduate Programmes</h3>
					<p class="track-desc">Specialized master's degrees providing deep research immersion, executive mentorship, and industry capstones.</p>
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
				// Fallback demonstration cards if query hasn't been seeded yet
				$demo_programs = array(
					array( 'title' => 'Bachelor of Computer Application (BCA)', 'year' => '2025-26', 'duration' => '3 Years' ),
					array( 'title' => 'Bachelor of Engineering (B.E.) in CS', 'year' => '2025-26', 'duration' => '4 Years' ),
					array( 'title' => 'Master of Computer Application (MCA)', 'year' => '2025-26', 'duration' => '2 Years' ),
				);
				foreach ( $demo_programs as $index => $demo ) :
			?>
				<article class="program-card">
					<div class="card-media">
						<div class="card-placeholder-img">
							<span>🎓 <?php echo esc_html( $demo['title'] ); ?></span>
						</div>
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
