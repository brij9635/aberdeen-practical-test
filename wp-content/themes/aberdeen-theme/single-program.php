<?php
/**
 * Single Program Detail Page (Task 6)
 *
 * @package Aberdeen_Theme
 */

get_header();

aberdeen_breadcrumbs();

while ( have_posts() ) :
	the_post();

	$post_id          = get_the_ID();
	$academic_year    = get_post_meta( $post_id, 'academic_year', true );
	$duration         = get_post_meta( $post_id, 'duration', true );
	$content_sections = get_post_meta( $post_id, 'content_sections', true );
	$terms            = get_the_terms( $post_id, 'program-type' );

	if ( empty( $academic_year ) ) {
		$academic_year = '2025-26';
	}
	if ( empty( $duration ) ) {
		$duration = '3 Years';
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-program-detail' ); ?>>

	<!-- Banner Header -->
	<header class="program-detail-header">
		<div class="aberdeen-container">
			<div class="detail-header-inner">
				<div class="detail-meta-top">
					<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
						<?php foreach ( $terms as $term ) : ?>
							<a href="<?php echo esc_url( home_url( '/programmes/' . $term->slug ) ); ?>" class="badge badge-type" <?php echo program_track_attr( 'link', 'detail-term-' . $term->slug, 'programme-overview', 'componentLink' ); ?>>
								<?php echo esc_html( $term->name ); ?>
							</a>
						<?php endforeach; ?>
					<?php endif; ?>
					<span class="badge badge-year">📅 Academic Year: <?php echo esc_html( $academic_year ); ?></span>
					<span class="badge badge-duration">⏱️ Duration: <?php echo esc_html( $duration ); ?></span>
				</div>

				<h1 class="detail-title"><?php the_title(); ?></h1>

				<!-- Action Buttons (Task 6 & Task 8 Tracking) -->
				<div class="detail-actions">
					<a href="#apply-section" class="btn btn-gold" <?php echo program_track_attr( 'link', 'apply-now', 'programme-overview', 'componentLink' ); ?>>
						Apply Now
					</a>
					<button type="button" class="btn btn-outline-white btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'open-enquiry-form', 'programme-overview', 'componentButton' ); ?>>
						Enquire Now
					</button>
					<a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" class="btn btn-back-link" <?php echo program_track_attr( 'link', 'back-to-programmes', 'programme-overview', 'componentLink' ); ?>>
						&larr; Back to programmes
					</a>
				</div>
			</div>
		</div>
	</header>

	<div class="aberdeen-container section-padding detail-layout">
		<div class="detail-main-content">
			<!-- Featured Image -->
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="detail-featured-media">
					<?php the_post_thumbnail( 'large', array( 'class' => 'detail-featured-img' ) ); ?>
				</div>
			<?php endif; ?>

			<!-- Main Program Overview Content -->
			<div class="program-entry-content">
				<h2 class="content-heading">Programme Overview</h2>
				<?php the_content(); ?>
			</div>

			<!-- Dynamic Repeater Content Sections (Task 3 & Task 6) -->
			<?php if ( ! empty( $content_sections ) && is_array( $content_sections ) ) : ?>
				<div class="repeater-sections-wrapper">
					<h2 class="content-heading">Curriculum & Highlights</h2>
					<div class="repeater-cards-list">
						<?php foreach ( $content_sections as $index => $section ) :
							$sec_title = ! empty( $section['title'] ) ? $section['title'] : '';
							$sec_desc  = ! empty( $section['description'] ) ? $section['description'] : '';
							$sec_image = ! empty( $section['image'] ) ? $section['image'] : '';
						?>
							<div class="repeater-section-card" id="curriculum-section-<?php echo esc_attr( $index ); ?>">
								<?php if ( $sec_image ) : ?>
									<div class="repeater-img-wrap">
										<img src="<?php echo esc_url( $sec_image ); ?>" alt="<?php echo esc_attr( $sec_title ); ?>">
									</div>
								<?php endif; ?>
								<div class="repeater-body">
									<?php if ( $sec_title ) : ?>
										<h3 class="repeater-title"><?php echo esc_html( $sec_title ); ?></h3>
									<?php endif; ?>
									<?php if ( $sec_desc ) : ?>
										<div class="repeater-text"><?php echo wp_kses_post( wpautop( $sec_desc ) ); ?></div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Apply / Enquire Bottom Section -->
			<div class="detail-bottom-cta" id="apply-section">
				<div class="cta-box">
					<h3>Ready to Apply for <?php the_title(); ?>?</h3>
					<p>Admissions for Academic Year <?php echo esc_html( $academic_year ); ?> are now open. Secure your place at the University of Aberdeen.</p>
					<div class="cta-actions">
						<button type="button" class="btn btn-gold btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'bottom-cta-enquire', 'programme-overview', 'componentButton' ); ?>>
							Start Your Application
						</button>
						<a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" class="btn btn-outline-white" <?php echo program_track_attr( 'link', 'bottom-back-to-programmes', 'programme-overview', 'componentLink' ); ?>>
							View Other Programmes
						</a>
					</div>
				</div>
			</div>

		</div>

		<!-- Sidebar Info -->
		<aside class="detail-sidebar">
			<div class="sidebar-card">
				<h3 class="sidebar-title">Key Facts</h3>
				<ul class="facts-list">
					<li>
						<strong>Study Level:</strong>
						<span>
							<?php
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
								echo esc_html( $terms[0]->name );
							} else {
								echo 'Undergraduate / Postgraduate';
							}
							?>
						</span>
					</li>
					<li>
						<strong>Duration:</strong>
						<span><?php echo esc_html( $duration ); ?></span>
					</li>
					<li>
						<strong>Academic Year:</strong>
						<span><?php echo esc_html( $academic_year ); ?></span>
					</li>
					<li>
						<strong>Campus:</strong>
						<span>India Campus & Aberdeen, UK</span>
					</li>
				</ul>
				<button type="button" class="btn btn-gold btn-block btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'sidebar-enquire-now', 'programme-sidebar', 'componentButton' ); ?>>
					Enquire Now
				</button>
			</div>
		</aside>
	</div>

</article>

<?php
endwhile;

get_footer();
