<?php
/**
 * Aberdeen University Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Theme Setup
function aberdeen_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'style', 'script' ) );

	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'aberdeen-theme' ),
	) );
}
add_action( 'after_setup_theme', 'aberdeen_theme_setup' );

// 2. Enqueue Styles & Scripts
function aberdeen_enqueue_assets() {
	wp_enqueue_style(
		'aberdeen-google-fonts',
		'https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'aberdeen-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
		array(),
		'6.5.1'
	);

	$css_file = get_template_directory() . '/assets/css/main.css';
	$css_ver  = file_exists( $css_file ) ? filemtime( $css_file ) : time();
	wp_enqueue_style(
		'aberdeen-main-style',
		get_template_directory_uri() . '/assets/css/main.css',
		array( 'aberdeen-google-fonts' ),
		$css_ver
	);

	wp_enqueue_script(
		'aberdeen-theme-script',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		'1.0.0',
		true
	);

	wp_localize_script( 'aberdeen-theme-script', 'aberdeenData', array(
		'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
		'restUrl'       => esc_url_raw( rest_url( 'programs/v1/track' ) ),
		'filterRestUrl' => esc_url_raw( rest_url( 'programs/v1/filter' ) ),
		'restNonce'     => wp_create_nonce( 'wp_rest' ),
		'leadNonce'     => wp_create_nonce( 'aberdeen_lead_nonce' ),
	) );

	if ( function_exists( 'wp_register_script_module' ) && function_exists( 'wp_enqueue_script_module' ) ) {
		wp_register_script_module(
			'aberdeen-interactivity-filter',
			get_template_directory_uri() . '/assets/js/interactivity-filter.js',
			array( '@wordpress/interactivity' ),
			'1.0.0'
		);
		wp_enqueue_script_module( 'aberdeen-interactivity-filter' );
	}
}
add_action( 'wp_enqueue_scripts', 'aberdeen_enqueue_assets' );

// 3. Click Tracking Helper (Task 8)
function program_track_attr( $event, $label, $section, $component ) {
	$event = in_array( $event, array( 'link', 'button' ), true ) ? $event : 'link';

	$payload = array(
		'type'         => 'click',
		'event'        => $event,
		$event         => array(
			'label' => sanitize_title( $label ),
		),
		'content_data' => array(
			'sectionName' => sanitize_text_field( $section ),
			'uiComponent' => sanitize_text_field( $component ),
		),
	);

	return 'data-track="' . esc_attr( wp_json_encode( $payload ) ) . '"';
}

// 4. Lead Form AJAX Handler
function aberdeen_handle_lead_form() {
	check_ajax_referer( 'aberdeen_lead_nonce', 'security' );

	$first_name     = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last_name      = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
	$email          = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone          = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$enquiring_as   = isset( $_POST['enquiring_as'] ) ? sanitize_text_field( wp_unslash( $_POST['enquiring_as'] ) ) : '';
	$level_interest = isset( $_POST['level_of_interest'] ) ? sanitize_text_field( wp_unslash( $_POST['level_of_interest'] ) ) : '';
	$prog_interest  = isset( $_POST['programme_of_interest'] ) ? sanitize_text_field( wp_unslash( $_POST['programme_of_interest'] ) ) : '';
	$country        = isset( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : '';
	$city           = isset( $_POST['city'] ) ? sanitize_text_field( wp_unslash( $_POST['city'] ) ) : '';

	if ( empty( $first_name ) || empty( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'aberdeen-theme' ) ) );
	}

	wp_send_json_success( array(
		'message' => __( "We'll send you helpful information and updates about this programme, the application process, and more.", 'aberdeen-theme' ),
	) );
}
add_action( 'wp_ajax_aberdeen_submit_lead', 'aberdeen_handle_lead_form' );
add_action( 'wp_ajax_nopriv_aberdeen_submit_lead', 'aberdeen_handle_lead_form' );

// 5. Breadcrumbs Helper
function aberdeen_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="aberdeen-breadcrumbs" aria-label="Breadcrumb">';
	echo '<div class="aberdeen-container">';
	echo '<ol class="breadcrumbs-list">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" ' . program_track_attr( 'link', 'breadcrumb-home', 'navigation-breadcrumbs', 'componentLink' ) . '>Home</a></li>';

	if ( is_singular( 'program' ) ) {
		echo '<li><span class="sep">/</span><a href="' . esc_url( home_url( '/programmes' ) ) . '" ' . program_track_attr( 'link', 'breadcrumb-programmes', 'navigation-breadcrumbs', 'componentLink' ) . '>Programmes</a></li>';
		$terms = get_the_terms( get_the_ID(), 'program-type' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$term = $terms[0];
			echo '<li><span class="sep">/</span><a href="' . esc_url( home_url( '/programmes/' . $term->slug ) ) . '" ' . program_track_attr( 'link', 'breadcrumb-' . $term->slug, 'navigation-breadcrumbs', 'componentLink' ) . '>' . esc_html( $term->name ) . '</a></li>';
		}
		echo '<li aria-current="page"><span class="sep">/</span>' . esc_html( get_the_title() ) . '</li>';
	} elseif ( is_tax( 'program-type' ) ) {
		echo '<li><span class="sep">/</span><a href="' . esc_url( home_url( '/programmes' ) ) . '" ' . program_track_attr( 'link', 'breadcrumb-programmes', 'navigation-breadcrumbs', 'componentLink' ) . '>Programmes</a></li>';
		echo '<li aria-current="page"><span class="sep">/</span>' . esc_html( single_term_title( '', false ) ) . '</li>';
	} elseif ( is_post_type_archive( 'program' ) || ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/programmes' ) !== false ) ) {
		echo '<li aria-current="page"><span class="sep">/</span>Programmes</li>';
	} else {
		echo '<li aria-current="page"><span class="sep">/</span>' . esc_html( get_the_title() ) . '</li>';
	}

	echo '</ol>';
	echo '</div>';
	echo '</nav>';
}

/**
 * Shortcode-Free Helper Function to render Reusable Program Card (Task 5 Specification)
 * Usable on any template, page, or query simply by passing post ID.
 *
 * @param int  $post_id Optional. Program post ID. Defaults to current post.
 * @param bool $echo    Optional. Whether to echo or return HTML. Defaults to true.
 * @return string|void
 */
function aberdeen_render_program_card( $post_id = 0, $echo = true ) {
	$target_id = ! empty( $post_id ) ? absint( $post_id ) : get_the_ID();
	if ( ! $target_id ) {
		return '';
	}

	if ( ! $echo ) {
		ob_start();
		get_template_part( 'template-parts/program-card', null, array( 'post_id' => $target_id ) );
		return ob_get_clean();
	}

	get_template_part( 'template-parts/program-card', null, array( 'post_id' => $target_id ) );
}

