<?php
/**
 * Content Structure: Custom Post Type & Hierarchical Taxonomy
 *
 * @package Programs_Module
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// 1. Register Taxonomy: program-type (Hierarchical)
// =============================================================================
if ( ! function_exists( 'aberdeen_register_program_taxonomy' ) ) {
	function aberdeen_register_program_taxonomy() {
		$labels = array(
			'name'              => _x( 'Program Types', 'taxonomy general name', 'programs-module' ),
			'singular_name'     => _x( 'Program Type', 'taxonomy singular name', 'programs-module' ),
			'search_items'      => __( 'Search Program Types', 'programs-module' ),
			'all_items'         => __( 'All Program Types', 'programs-module' ),
			'parent_item'       => __( 'Parent Program Type', 'programs-module' ),
			'parent_item_colon' => __( 'Parent Program Type:', 'programs-module' ),
			'edit_item'         => __( 'Edit Program Type', 'programs-module' ),
			'update_item'       => __( 'Update Program Type', 'programs-module' ),
			'add_new_item'      => __( 'Add New Program Type', 'programs-module' ),
			'new_item_name'     => __( 'New Program Type Name', 'programs-module' ),
			'menu_name'         => __( 'Program Types', 'programs-module' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rewrite'           => false, // Handled explicitly below to avoid URL collision
		);

		register_taxonomy( 'program-type', array( 'program' ), $args );
	}
	add_action( 'init', 'aberdeen_register_program_taxonomy', 0 );
}

/**
 * Clean term link for program-type taxonomy (/programmes/{slug})
 */
if ( ! function_exists( 'aberdeen_program_type_term_link' ) ) {
	function aberdeen_program_type_term_link( $url, $term, $taxonomy ) {
		if ( 'program-type' === $taxonomy ) {
			return home_url( '/programmes/' . $term->slug );
		}
		return $url;
	}
	add_filter( 'term_link', 'aberdeen_program_type_term_link', 10, 3 );
}

// =============================================================================
// 2. Register CPT: program
// =============================================================================
if ( ! function_exists( 'aberdeen_register_program_cpt' ) ) {
	function aberdeen_register_program_cpt() {
		$labels = array(
			'name'                  => _x( 'Programs', 'Post type general name', 'programs-module' ),
			'singular_name'         => _x( 'Program', 'Post type singular name', 'programs-module' ),
			'menu_name'             => _x( 'Programs', 'Admin Menu text', 'programs-module' ),
			'name_admin_bar'        => _x( 'Program', 'Add New on Toolbar', 'programs-module' ),
			'add_new'               => __( 'Add New', 'programs-module' ),
			'add_new_item'          => __( 'Add New Program', 'programs-module' ),
			'new_item'              => __( 'New Program', 'programs-module' ),
			'edit_item'             => __( 'Edit Program', 'programs-module' ),
			'view_item'             => __( 'View Program', 'programs-module' ),
			'all_items'             => __( 'All Programs', 'programs-module' ),
			'search_items'          => __( 'Search Programs', 'programs-module' ),
			'not_found'             => __( 'No programs found.', 'programs-module' ),
			'not_found_in_trash'    => __( 'No programs found in Trash.', 'programs-module' ),
			'featured_image'        => __( 'Program Cover Image', 'programs-module' ),
			'set_featured_image'    => __( 'Set program cover image', 'programs-module' ),
			'remove_featured_image' => __( 'Remove program cover image', 'programs-module' ),
			'use_featured_image'    => __( 'Use as cover image', 'programs-module' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array(
				'slug'       => 'programmes',
				'with_front' => false,
			),
			'capability_type'    => 'post',
			'has_archive'        => 'programmes',
			'hierarchical'       => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'program', $args );

		// 1. Taxonomy routes with top priority
		add_rewrite_rule(
			'^programmes/(undergraduate|postgraduate)/?$',
			'index.php?program-type=$matches[1]',
			'top'
		);
		add_rewrite_tag( '%program-type%', '([^&]+)' );

		// 2. Single program detail route
		add_rewrite_rule(
			'^programmes/([^/]+)/?$',
			'index.php?program=$matches[1]',
			'bottom'
		);
	}
	add_action( 'init', 'aberdeen_register_program_cpt', 0 );
}

// =============================================================================
// 3. Ensure Default Terms: Undergraduate & Postgraduate
// =============================================================================
if ( ! function_exists( 'aberdeen_seed_program_terms' ) ) {
	function aberdeen_seed_program_terms() {
		if ( ! taxonomy_exists( 'program-type' ) ) {
			return;
		}

		$default_terms = array(
			'undergraduate' => 'Undergraduate',
			'postgraduate'  => 'Postgraduate',
		);

		foreach ( $default_terms as $slug => $name ) {
			if ( ! term_exists( $slug, 'program-type' ) ) {
				wp_insert_term( $name, 'program-type', array(
					'slug' => $slug,
				) );
			}
		}
	}
	add_action( 'init', 'aberdeen_seed_program_terms', 10 );
}

// =============================================================================
// 4. Ensure Rewrite Rules Are Flushed Automatically
// =============================================================================
if ( ! function_exists( 'aberdeen_program_check_rewrite_rules' ) ) {
	function aberdeen_program_check_rewrite_rules() {
		$rules = get_option( 'rewrite_rules' );
		if ( empty( $rules ) || ! isset( $rules['^programmes/([^/]+)/?$'] ) || ! isset( $rules['^programmes/(undergraduate|postgraduate)/?$'] ) ) {
			flush_rewrite_rules( false );
		}
	}
	add_action( 'init', 'aberdeen_program_check_rewrite_rules', 20 );
}

// =============================================================================
// 5. Template Routing for Category Pages
// =============================================================================
if ( ! function_exists( 'aberdeen_program_template_router' ) ) {
	function aberdeen_program_template_router( $template ) {
		$term_slug = get_query_var( 'program-type' );
		if ( empty( $term_slug ) ) {
			$req_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			if ( strpos( $req_uri, '/programmes/undergraduate' ) !== false ) {
				$term_slug = 'undergraduate';
			} elseif ( strpos( $req_uri, '/programmes/postgraduate' ) !== false ) {
				$term_slug = 'postgraduate';
			}
		}

		if ( ! empty( $term_slug ) && in_array( $term_slug, array( 'undergraduate', 'postgraduate' ), true ) ) {
			global $wp_query;
			if ( isset( $wp_query ) ) {
				$wp_query->is_404 = false;
			}
			status_header( 200 );
			set_query_var( 'program-type', $term_slug );

			$custom_template = locate_template( array( 'taxonomy-program-type.php', 'taxonomy.php', 'archive.php' ) );
			if ( ! empty( $custom_template ) ) {
				return $custom_template;
			}
		}

		return $template;
	}
	add_filter( 'template_include', 'aberdeen_program_template_router', 99 );
}

// =============================================================================
// 6. REST API Endpoint for Program Filtering (Task 7 Interactivity API)
// =============================================================================
if ( ! function_exists( 'aberdeen_register_program_filter_route' ) ) {
	function aberdeen_register_program_filter_route() {
		register_rest_route( 'programs/v1', '/filter', array(
			'methods'             => WP_REST_Server::READABLE, // GET
			'callback'            => 'aberdeen_rest_filter_programs',
			'permission_callback' => '__return_true', // Public endpoint
			'args'                => array(
				'type' => array(
					'required'          => false,
					'default'           => 'all',
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_key',
				),
			),
		) );
	}
	add_action( 'rest_api_init', 'aberdeen_register_program_filter_route' );
}

if ( ! function_exists( 'aberdeen_rest_filter_programs' ) ) {
	function aberdeen_rest_filter_programs( WP_REST_Request $request ) {
		$type = $request->get_param( 'type' );
		$type = ! empty( $type ) ? sanitize_key( $type ) : 'all';
		if ( ! in_array( $type, array( 'all', 'undergraduate', 'postgraduate' ), true ) ) {
			$type = 'all';
		}

		// Bonus 1: Check transient cache
		$cache_key   = 'aberdeen_programs_rest_' . $type;
		$cached_data = get_transient( $cache_key );
		if ( false !== $cached_data && is_array( $cached_data ) ) {
			return rest_ensure_response( $cached_data );
		}

		ob_start();
		$total_rendered = 0;

		if ( 'all' === $type ) {
			$types = array(
				'undergraduate' => 'Undergraduate Programmes',
				'postgraduate'  => 'Postgraduate Programmes',
			);

			foreach ( $types as $slug => $label ) {
				$term_obj = get_term_by( 'slug', $slug, 'program-type' );
				if ( ! $term_obj ) {
					continue;
				}

				$query = new WP_Query( array(
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

				if ( $query->have_posts() ) {
					$total_rendered += $query->post_count;
					?>
					<section class="programme-group-section" id="group-<?php echo esc_attr( $slug ); ?>" data-program-type="<?php echo esc_attr( $slug ); ?>">
						<div class="group-header">
							<div class="group-header-left">
								<h2 class="group-title"><?php echo esc_html( $label ); ?></h2>
								<div class="group-title-bar"></div>
							</div>
							<a href="<?php echo esc_url( home_url( '/programmes/' . $slug ) ); ?>" class="btn-group-view-all" <?php echo function_exists( 'program_track_attr' ) ? program_track_attr( 'link', 'view-all-' . $slug, 'programme-listing', 'componentLink' ) : ''; ?>>
								View all <?php echo esc_html( $term_obj->name ); ?> &rarr;
							</a>
						</div>
						<div class="programs-grid grid-3-cols">
							<?php
							while ( $query->have_posts() ) {
								$query->the_post();
								get_template_part( 'template-parts/program-card', null, array( 'post_id' => get_the_ID() ) );
							}
							wp_reset_postdata();
							?>
						</div>
					</section>
					<?php
				}
			}
		} else {
			$term_obj  = get_term_by( 'slug', $type, 'program-type' );
			$term_name = $term_obj ? $term_obj->name : ucfirst( $type );

			$query = new WP_Query( array(
				'post_type'      => 'program',
				'posts_per_page' => -1,
				'tax_query'      => array(
					array(
						'taxonomy' => 'program-type',
						'field'    => 'slug',
						'terms'    => $type,
					),
				),
				'orderby'        => 'title',
				'order'          => 'ASC',
			) );

			if ( $query->have_posts() ) {
				$total_rendered += $query->post_count;
				?>
				<section class="programme-group-section" id="group-<?php echo esc_attr( $type ); ?>">
					<div class="group-header">
						<div class="group-header-left">
							<h2 class="group-title"><?php echo esc_html( $term_name ); ?> Programmes</h2>
							<div class="group-title-bar"></div>
						</div>
						<a href="<?php echo esc_url( home_url( '/programmes' ) ); ?>" class="btn-group-view-all" <?php echo function_exists( 'program_track_attr' ) ? program_track_attr( 'link', 'view-all-programmes', 'programme-listing', 'componentLink' ) : ''; ?>>
							&larr; View all programmes
						</a>
					</div>
					<div class="programs-grid grid-3-cols">
						<?php
						while ( $query->have_posts() ) {
							$query->the_post();
							get_template_part( 'template-parts/program-card', null, array( 'post_id' => get_the_ID() ) );
						}
						wp_reset_postdata();
						?>
					</div>
				</section>
				<?php
			}
		}

		$html = ob_get_clean();

		$response_data = array(
			'success' => true,
			'filter'  => $type,
			'count'   => $total_rendered,
			'html'    => $html,
		);

		// Bonus 1: Cache response for 12 hours
		set_transient( 'aberdeen_programs_rest_' . $type, $response_data, 12 * HOUR_IN_SECONDS );

		return rest_ensure_response( $response_data );
	}
}

// =============================================================================
// 7. Transient Cache Invalidation (Bonus 1)
// =============================================================================
if ( ! function_exists( 'aberdeen_clear_programs_cache' ) ) {
	function aberdeen_clear_programs_cache() {
		delete_transient( 'aberdeen_programs_rest_all' );
		delete_transient( 'aberdeen_programs_rest_undergraduate' );
		delete_transient( 'aberdeen_programs_rest_postgraduate' );
		delete_transient( 'aberdeen_archive_query_all' );
		delete_transient( 'aberdeen_archive_query_undergraduate' );
		delete_transient( 'aberdeen_archive_query_postgraduate' );
	}
	add_action( 'save_post_program', 'aberdeen_clear_programs_cache' );
	add_action( 'deleted_post', 'aberdeen_clear_programs_cache' );
	add_action( 'created_program-type', 'aberdeen_clear_programs_cache' );
	add_action( 'edited_program-type', 'aberdeen_clear_programs_cache' );
	add_action( 'delete_program-type', 'aberdeen_clear_programs_cache' );
}


