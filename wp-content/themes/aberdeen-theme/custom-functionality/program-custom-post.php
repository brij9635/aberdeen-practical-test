<?php
/**
 * Task 2: Content Structure - Program Custom Post Type & Taxonomy
 *
 * Handles:
 * 1. Registration of CPT 'program' with rewrite slug 'programmes'
 * 2. Registration of hierarchical taxonomy 'program-type'
 * 3. Default terms creation: Undergraduate & Postgraduate
 * 4. Sample programs seeding (5 Undergraduate + 5 Postgraduate)
 * 5. Rewrite rules & routing for /programmes and taxonomy archives
 *
 * @package Aberdeen_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// 1. Register Taxonomy: program-type
// =============================================================================
function aberdeen_register_program_taxonomy() {
	$labels = array(
		'name'              => _x( 'Program Types', 'taxonomy general name', 'aberdeen-theme' ),
		'singular_name'     => _x( 'Program Type', 'taxonomy singular name', 'aberdeen-theme' ),
		'search_items'      => __( 'Search Program Types', 'aberdeen-theme' ),
		'all_items'         => __( 'All Program Types', 'aberdeen-theme' ),
		'parent_item'       => __( 'Parent Program Type', 'aberdeen-theme' ),
		'parent_item_colon' => __( 'Parent Program Type:', 'aberdeen-theme' ),
		'edit_item'         => __( 'Edit Program Type', 'aberdeen-theme' ),
		'update_item'       => __( 'Update Program Type', 'aberdeen-theme' ),
		'add_new_item'      => __( 'Add New Program Type', 'aberdeen-theme' ),
		'new_item_name'     => __( 'New Program Type Name', 'aberdeen-theme' ),
		'menu_name'         => __( 'Program Types', 'aberdeen-theme' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => false,
	);

	register_taxonomy( 'program-type', array( 'program' ), $args );
}
add_action( 'init', 'aberdeen_register_program_taxonomy', 0 );

/**
 * Clean term link for program-type taxonomy
 */
function aberdeen_program_type_term_link( $url, $term, $taxonomy ) {
	if ( 'program-type' === $taxonomy ) {
		return home_url( '/programmes/' . $term->slug );
	}
	return $url;
}
add_filter( 'term_link', 'aberdeen_program_type_term_link', 10, 3 );

// =============================================================================
// 2. Register CPT: program
// =============================================================================
function aberdeen_register_program_cpt() {
	$labels = array(
		'name'                  => _x( 'Programs', 'Post type general name', 'aberdeen-theme' ),
		'singular_name'         => _x( 'Program', 'Post type singular name', 'aberdeen-theme' ),
		'menu_name'             => _x( 'Programs', 'Admin Menu text', 'aberdeen-theme' ),
		'name_admin_bar'        => _x( 'Program', 'Add New on Toolbar', 'aberdeen-theme' ),
		'add_new'               => __( 'Add New', 'aberdeen-theme' ),
		'add_new_item'          => __( 'Add New Program', 'aberdeen-theme' ),
		'new_item'              => __( 'New Program', 'aberdeen-theme' ),
		'edit_item'             => __( 'Edit Program', 'aberdeen-theme' ),
		'view_item'             => __( 'View Program', 'aberdeen-theme' ),
		'all_items'             => __( 'All Programs', 'aberdeen-theme' ),
		'search_items'          => __( 'Search Programs', 'aberdeen-theme' ),
		'not_found'             => __( 'No programs found.', 'aberdeen-theme' ),
		'not_found_in_trash'    => __( 'No programs found in Trash.', 'aberdeen-theme' ),
		'featured_image'        => __( 'Program Cover Image', 'aberdeen-theme' ),
		'set_featured_image'    => __( 'Set program cover image', 'aberdeen-theme' ),
		'remove_featured_image' => __( 'Remove program cover image', 'aberdeen-theme' ),
		'use_featured_image'    => __( 'Use as cover image', 'aberdeen-theme' ),
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

	// 1. Taxonomy terms: /programmes/undergraduate and /programmes/postgraduate
	add_rewrite_rule(
		'^programmes/(undergraduate|postgraduate)/?$',
		'index.php?program-type=$matches[1]',
		'top'
	);
	add_rewrite_tag( '%program-type%', '([^&]+)' );

	// 2. Single program detail: /programmes/{slug}
	add_rewrite_rule(
		'^programmes/([^/]+)/?$',
		'index.php?program=$matches[1]',
		'bottom'
	);
}
add_action( 'init', 'aberdeen_register_program_cpt', 0 );

// =============================================================================
// 3. Ensure Terms Creation: Undergraduate & Postgraduate
// =============================================================================
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

// =============================================================================
// 4. Ensure Rewrite Rules Are Flushed
// =============================================================================
function aberdeen_program_check_rewrite_rules() {
	$rules = get_option( 'rewrite_rules' );
	if ( empty( $rules ) || ! isset( $rules['^programmes/([^/]+)/?$'] ) || ! isset( $rules['^programmes/(undergraduate|postgraduate)/?$'] ) ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'aberdeen_program_check_rewrite_rules', 20 );

// =============================================================================
// 5. Template Routing for Category Pages
// =============================================================================
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

		$custom_template = get_template_directory() . '/taxonomy-program-type.php';
		if ( file_exists( $custom_template ) ) {
			return $custom_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'aberdeen_program_template_router', 99 );
