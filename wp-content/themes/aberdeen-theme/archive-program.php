<?php
/**
 * Archive Template for Programmes (/programmes)
 * Displays all programs grouped and ordered by program type with headings (Task 4.2)
 * Supports Interactivity API and category filtering
 *
 * @package Aberdeen_Theme
 */

get_header();

aberdeen_breadcrumbs();

// Check if a specific program type is requested via query var or filter
$current_term_slug = get_query_var( 'program-type' );
$page_title        = 'All Programmes';

if ( $current_term_slug ) {
	$term = get_term_by( 'slug', $current_term_slug, 'program-type' );
	if ( $term ) {
		$page_title = $term->name . ' Programmes';
	}
}

// Task 7: Initialize WordPress Interactivity API Store State
if ( function_exists( 'wp_interactivity_state' ) ) {
	wp_interactivity_state( 'programsFilter', array(
		'filter'    => ! empty( $current_term_slug ) ? $current_term_slug : 'all',
		'isLoading' => false,
		'isEmpty'   => false,
	) );
}
?>

<!-- Banner Section -->
<div class="page-banner">
	<div class="aberdeen-container">
		<span class="banner-tag">Degrees & Diplomas</span>
		<h1 class="page-title"><?php echo esc_html( $page_title ); ?></h1>
		<div class="page-banner-bar"></div>
		<p class="banner-subtitle">Explore accredited programmes designed to build leadership, scientific inquiry, and technical mastery.</p>
	</div>
</div>

<section class="archive-section section-padding">
	<div class="aberdeen-container">

		<!-- Filter Tabs Bar (Task 7: Interactivity API & Progressive Enhancement) -->
		<div class="programs-filter-bar" data-wp-interactive="programsFilter" data-wp-init="callbacks.init">
			<ul class="filter-tabs" role="tablist">
				<li class="filter-item">
					<a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>"
					   class="filter-link <?php echo empty( $current_term_slug ) ? 'active' : ''; ?>"
					   data-filter="all"
					   data-wp-on--click="actions.filterProgrammes"
					   data-wp-class--active="state.isAllActive"
					   data-wp-bind--aria-selected="state.isAllActive"
					   <?php echo program_track_attr( 'link', 'filter-all', 'programme-filter', 'componentLink' ); ?>>
						All Programmes
					</a>
				</li>
				<li class="filter-item">
					<a href="<?php echo esc_url( home_url( '/programmes/undergraduate' ) ); ?>"
					   class="filter-link <?php echo ( 'undergraduate' === $current_term_slug ) ? 'active' : ''; ?>"
					   data-filter="undergraduate"
					   data-wp-on--click="actions.filterProgrammes"
					   data-wp-class--active="state.isUndergraduateActive"
					   data-wp-bind--aria-selected="state.isUndergraduateActive"
					   <?php echo program_track_attr( 'link', 'filter-undergraduate', 'programme-filter', 'componentLink' ); ?>>
						Undergraduate
					</a>
				</li>
				<li class="filter-item">
					<a href="<?php echo esc_url( home_url( '/programmes/postgraduate' ) ); ?>"
					   class="filter-link <?php echo ( 'postgraduate' === $current_term_slug ) ? 'active' : ''; ?>"
					   data-filter="postgraduate"
					   data-wp-on--click="actions.filterProgrammes"
					   data-wp-class--active="state.isPostgraduateActive"
					   data-wp-bind--aria-selected="state.isPostgraduateActive"
					   <?php echo program_track_attr( 'link', 'filter-postgraduate', 'programme-filter', 'componentLink' ); ?>>
						Postgraduate
					</a>
				</li>
			</ul>

			<!-- Loading Indicator for dynamic filter -->
			<div class="filter-loading-indicator" data-wp-bind--hidden="!state.isLoading" style="display: none;" aria-live="polite">
				<span class="spinner"></span> Loading programmes...
			</div>
		</div>

		<!-- Empty State when no programmes match (Managed by Interactivity API) -->
		<div class="programs-empty-state text-center" id="programs-empty-state" data-wp-bind--hidden="!state.isEmpty" style="display: none;">
			<div class="empty-icon">🔍</div>
			<h3>No programmes found</h3>
			<p>We are currently updating our syllabus. Please check back shortly or register your interest with our admissions team.</p>
			<button type="button" class="btn btn-gold btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'empty-state-enquire', 'programme-listing', 'componentButton' ); ?>>
				Register Interest
			</button>
		</div>

		<!-- Programs Grid Container -->
		<div class="programs-groups-wrapper" id="programs-groups-wrapper">
			<?php
			if ( empty( $current_term_slug ) ) :
				// =============================================================
				// TASK 4.2: ALL PROGRAMMES LISTING - GROUPED BY PROGRAM TYPE
				// =============================================================
				$types = array(
					'undergraduate' => 'Undergraduate Programmes',
					'postgraduate'  => 'Postgraduate Programmes',
				);

				$total_rendered = 0;

				foreach ( $types as $slug => $label ) :
					$term_obj = get_term_by( 'slug', $slug, 'program-type' );
					if ( ! $term_obj ) {
						continue;
					}

					$group_query = new WP_Query( array(
						'post_type'      => 'program',
						'posts_per_page' => -1,
						'tax_query'      => array(
							array(
								'taxonomy' => 'program-type',
								'field'    => 'slug',
								'terms'    => $slug,
							),
						),
						'orderby'        => 'title',
						'order'          => 'ASC',
					) );

					if ( $group_query->have_posts() ) :
						$total_rendered += $group_query->post_count;
						?>
						<section class="programme-group-section" id="group-<?php echo esc_attr( $slug ); ?>" data-program-type="<?php echo esc_attr( $slug ); ?>">
							<div class="group-header">
								<div class="group-header-left">
									<h2 class="group-title"><?php echo esc_html( $label ); ?></h2>
									<div class="group-title-bar"></div>
								</div>
								<a href="<?php echo esc_url( home_url( '/programmes/' . $slug ) ); ?>" class="btn-group-view-all" <?php echo program_track_attr( 'link', 'view-all-' . $slug, 'programme-listing', 'componentLink' ); ?>>
									View all <?php echo esc_html( $term_obj->name ); ?> &rarr;
								</a>
							</div>

							<div class="programs-grid grid-3-cols">
								<?php
								while ( $group_query->have_posts() ) :
									$group_query->the_post();
									get_template_part( 'template-parts/program-card', null, array( 'post_id' => get_the_ID() ) );
								endwhile;
								wp_reset_postdata();
								?>
							</div>
						</section>
						<?php
					endif;
				endforeach;

				if ( 0 === $total_rendered ) :
					?>
					<div class="programs-empty-state text-center">
						<div class="empty-icon">🔍</div>
						<h3>No programmes found</h3>
						<p>We are currently updating our syllabus. Please check back shortly or register your interest.</p>
						<button type="button" class="btn btn-gold btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'empty-state-enquire', 'programme-listing', 'componentButton' ); ?>>
							Register Interest
						</button>
					</div>
					<?php
				endif;

			else :
				// =============================================================
				// FILTERED VIEW: SINGLE PROGRAM TYPE
				// =============================================================
				$single_term = get_term_by( 'slug', $current_term_slug, 'program-type' );
				$single_name = $single_term ? $single_term->name : ucfirst( $current_term_slug );

				$filtered_query = new WP_Query( array(
					'post_type'      => 'program',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'program-type',
							'field'    => 'slug',
							'terms'    => $current_term_slug,
						),
					),
					'orderby'        => 'title',
					'order'          => 'ASC',
				) );

				if ( $filtered_query->have_posts() ) :
					?>
					<section class="programme-group-section" id="group-<?php echo esc_attr( $current_term_slug ); ?>">
						<div class="group-header">
							<div class="group-header-left">
								<h2 class="group-title"><?php echo esc_html( $single_name ); ?> Programmes</h2>
								<div class="group-title-bar"></div>
							</div>
							<a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" class="btn-group-view-all" <?php echo program_track_attr( 'link', 'view-all-programmes', 'programme-listing', 'componentLink' ); ?>>
								&larr; View all programmes
							</a>
						</div>

						<div class="programs-grid grid-3-cols">
							<?php
							while ( $filtered_query->have_posts() ) :
								$filtered_query->the_post();
								get_template_part( 'template-parts/program-card', null, array( 'post_id' => get_the_ID() ) );
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</section>
					<?php
				else :
					?>
					<div class="programs-empty-state text-center">
						<div class="empty-icon">🔍</div>
						<h3>No programmes found for <?php echo esc_html( $single_name ); ?></h3>
						<p>Please browse other categories or register your interest with our admissions team.</p>
						<button type="button" class="btn btn-gold btn-open-modal" data-modal="lead-form-modal" <?php echo program_track_attr( 'button', 'empty-state-enquire', 'programme-listing', 'componentButton' ); ?>>
							Register Interest
						</button>
					</div>
					<?php
				endif;
			endif;
			?>
		</div>

	</div>
</section>

<?php
get_footer();
