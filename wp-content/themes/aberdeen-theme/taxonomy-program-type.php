<?php
/**
 * Taxonomy Template: Programme Type Archive (Figma Exact "Desktop P2" Match)
 * Handles /programmes/undergraduate and /programmes/postgraduate
 *
 * @package Aberdeen_Theme
 */

get_header();

// Determine whether we are rendering Undergraduate or Postgraduate
$program_type = get_query_var( 'program-type' );
if ( empty( $program_type ) ) {
	$req_uri      = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$program_type = ( strpos( $req_uri, 'postgraduate' ) !== false ) ? 'postgraduate' : 'undergraduate';
}
$is_undergrad = ( 'undergraduate' === $program_type );
$page_title   = $is_undergrad ? 'Undergraduate Programmes' : 'Postgraduate Programmes';
?>

<!-- =========================================================================
     1. Banner Section: Exact Figma Dark Blue Background with Gold Heading
     ========================================================================= -->
<section class="p2-banner-section" id="p2-banner">
	<div class="aberdeen-container">
		<h1 class="p2-banner-title"><?php echo esc_html( $page_title ); ?></h1>
		<div class="p2-banner-bar"></div>
	</div>
</section>

<!-- =========================================================================
     2. Content Section: White Background with Centered Subtitle & 2-Col Cards
     ========================================================================= -->
<section class="p2-content-section" id="p2-content">
	<div class="aberdeen-container">
		<p class="p2-section-subtitle">
			Discover a campus that blends Scottish heritage with Indian innovation. A global education awaits!
		</p>

		<div class="p2-cards-grid">
			<?php if ( $is_undergrad ) : ?>
				<!-- Card 1: Bachelor of Computer Applications (BCA) -->
				<div class="p2-card">
					<div class="p2-card-img-wrap">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/program_img2.jpg' ); ?>" alt="<?php esc_attr_e( 'Bachelor of Computer Applications (BCA)', 'aberdeen-theme' ); ?>" class="p2-card-img">
					</div>
					<div class="p2-card-body">
						<h2 class="p2-card-title">Bachelor of Computer Applications (BCA)</h2>
						<div class="p2-card-divider"></div>
						<p class="p2-card-desc">
							Learn programming, software development, and modern technologies through practical, industry-focused education.
						</p>
					</div>
				</div>

				<!-- Card 2: Bachelor of Engineering (B.E.) -->
				<div class="p2-card">
					<div class="p2-card-img-wrap">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/program_img.jpg' ); ?>" alt="<?php esc_attr_e( 'Bachelor of Engineering (B.E.)', 'aberdeen-theme' ); ?>" class="p2-card-img">
					</div>
					<div class="p2-card-body">
						<h2 class="p2-card-title">Bachelor of Engineering (B.E.)</h2>
						<div class="p2-card-divider"></div>
						<p class="p2-card-desc">
							Gain technical knowledge and practical engineering skills to solve real-world challenges.
						</p>
					</div>
				</div>

			<?php else : ?>
				<!-- Card 1: Master of Computer Applications (MCA) -->
				<div class="p2-card">
					<div class="p2-card-img-wrap">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/program_img2.jpg' ); ?>" alt="<?php esc_attr_e( 'Master of Computer Applications (MCA)', 'aberdeen-theme' ); ?>" class="p2-card-img">
					</div>
					<div class="p2-card-body">
						<h2 class="p2-card-title">Master of Computer Applications (MCA)</h2>
						<div class="p2-card-divider"></div>
						<p class="p2-card-desc">
							Build advanced skills in software development, programming, and emerging technologies through practical learning.
						</p>
					</div>
				</div>

				<!-- Card 2: Master of Engineering (M.E.) -->
				<div class="p2-card">
					<div class="p2-card-img-wrap">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/program_img.jpg' ); ?>" alt="<?php esc_attr_e( 'Master of Engineering (M.E.)', 'aberdeen-theme' ); ?>" class="p2-card-img">
					</div>
					<div class="p2-card-body">
						<h2 class="p2-card-title">Master of Engineering (M.E.)</h2>
						<div class="p2-card-divider"></div>
						<p class="p2-card-desc">
							Advance your technical expertise through specialized engineering knowledge, innovation, and hands-on learning.
						</p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
get_footer();
