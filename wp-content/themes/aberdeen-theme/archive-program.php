<?php
/**
 * Archive Template for Programmes (/programmes)
 * Matching Figma Listing Screen with Breadcrumbs and Interactivity API Filter Support
 *
 * @package Aberdeen_Theme
 */

get_header();

aberdeen_breadcrumbs();

// Check if a specific program type is requested
$current_term_slug = get_query_var( 'program-type' );
$page_title        = 'Programmes';

if ( $current_term_slug ) {
	$term = get_term_by( 'slug', $current_term_slug, 'program-type' );
	if ( $term ) {
		$page_title = $term->name . ' Programmes';
	}
}
?>

<div class="page-banner">
	<div class="aberdeen-container">
		<span class="banner-tag">Degrees & Diplomas</span>
		<h1 class="page-title"><?php echo esc_html( $page_title ); ?></h1>
		<p class="banner-subtitle">Explore accredited programmes designed to build leadership and technical mastery.</p>
	</div>
</div>

<section class="archive-section section-padding">
	<div class="aberdeen-container">

		<!-- Filter Bar (Task 7 & Figma Design) -->
		<!-- Supports Interactivity API data-wp-interactive and no-JS fallback links -->
		<div class="programs-filter-bar" data-wp-interactive="programsFilter">
			<ul class="filter-tabs" role="tablist">
				<li class="filter-item">
					<a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>"
					   class="filter-link <?php echo empty( $current_term_slug ) ? 'active' : ''; ?>"
					   data-filter="all"
					   <?php echo program_track_attr( 'link', 'filter-all', 'programme-filter', 'componentLink' ); ?>>
						All Programmes
					</a>
				</li>
				<li class="filter-item">
					<a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>"
					   class="filter-link <?php echo ( 'undergraduate' === $current_term_slug ) ? 'active' : ''; ?>"
					   data-filter="undergraduate"
					   <?php echo program_track_attr( 'link', 'filter-undergraduate', 'programme-filter', 'componentLink' ); ?>>
						Undergraduate
					</a>
				</li>
				<li class="filter-item">
					<a href="<?php echo esc_url( home_url( '/programmes/postgraduate' ) ); ?>"
					   class="filter-link <?php echo ( 'postgraduate' === $current_term_slug ) ? 'active' : ''; ?>"
					   data-filter="postgraduate"
					   <?php echo program_track_attr( 'link', 'filter-postgraduate', 'programme-filter', 'componentLink' ); ?>>
						Postgraduate
					</a>
				</li>
			</ul>

			<!-- Loading Indicator for dynamic filter -->
			<div class="filter-loading-indicator" style="display: none;" aria-live="polite">
				<span class="spinner"></span> Loading programmes...
			</div>
		</div>

		<!-- Programs Grid Container -->
		<div class="programs-grid-wrapper" id="programs-grid-wrapper">
			<?php
			if ( have_posts() ) :
			?>
				<div class="programs-grid grid-3-cols" id="programs-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/program-card', null, array( 'post_id' => get_the_ID() ) );
					endwhile;
					?>
				</div>

				<div class="programs-pagination">
					<?php the_posts_pagination( array(
						'mid_size'  => 2,
						'prev_text' => __( '&larr; Previous', 'aberdeen-theme' ),
						'next_text' => __( 'Next &rarr;', 'aberdeen-theme' ),
					) ); ?>
				</div>

			<?php else : ?>
				<div class="programs-empty-state text-center">
					<div class="empty-icon">🔍</div>
					<h3>No programmes found</h3>
					<p>We are currently updating our syllabus for this category. Please check back shortly or register your interest.</p>
					<button type="button" class="btn btn-gold btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'empty-state-enquire', 'programme-listing', 'componentButton' ); ?>>
						Register Interest
					</button>
				</div>
			<?php endif; ?>
		</div>

	</div>
</section>

<?php
get_footer();
