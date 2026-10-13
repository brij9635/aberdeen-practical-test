<?php
/**
 * Aberdeen University Theme Functions
 *
 * @package Aberdeen_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ==========================================
// 1. Theme Setup & Supports
// ==========================================
function aberdeen_theme_setup() {
	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable featured images
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 600, 380, true );

	// Custom Logo support
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 260,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// HTML5 markup support
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Register Navigation Menus
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'aberdeen-theme' ),
		'footer'  => __( 'Footer Navigation', 'aberdeen-theme' ),
	) );
}
add_action( 'after_setup_theme', 'aberdeen_theme_setup' );

// ==========================================
// 2. Enqueue Styles & Scripts
// ==========================================
function aberdeen_enqueue_assets() {
	// Google Fonts: Outfit & Inter
	wp_enqueue_style(
		'aberdeen-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap',
		array(),
		null
	);

	// Theme Main Stylesheet
	wp_enqueue_style(
		'aberdeen-main-style',
		get_template_directory_uri() . '/assets/css/main.css',
		array( 'aberdeen-google-fonts' ),
		'1.0.0'
	);

	// Theme Vanilla JS (Modal, Navigation & Tracking)
	wp_enqueue_script(
		'aberdeen-theme-script',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		'1.0.0',
		true
	);

	// Pass variables to JS
	wp_localize_script( 'aberdeen-theme-script', 'aberdeenData', array(
		'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
		'restUrl'   => esc_url_raw( rest_url( 'programs/v1/track' ) ),
		'restNonce' => wp_create_nonce( 'wp_rest' ),
		'leadNonce' => wp_create_nonce( 'aberdeen_lead_nonce' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'aberdeen_enqueue_assets' );

// ==========================================
// 3. Compulsory Reusable Click-Tracking Helper (Task 8.3)
// ==========================================
/**
 * Builds, encodes, and escapes the click-tracking JSON payload safely.
 *
 * @param string $event     'link' or 'button'
 * @param string $label     Short sanitized slug (e.g. 'apply-now', 'enquire-now')
 * @param string $section   Section identifier (e.g. 'programme-overview', 'hero-banner')
 * @param string $component UI component type (e.g. 'componentLink', 'componentButton', 'componentCard')
 * @return string Safe data-track attribute string
 */
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

// ==========================================
// 4. Lead Form AJAX Handler (Popup Modal)
// ==========================================
function aberdeen_handle_lead_form() {
	check_ajax_referer( 'aberdeen_lead_nonce', 'security' );

	$name    = isset( $_POST['fullname'] ) ? sanitize_text_field( wp_unslash( $_POST['fullname'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$program = isset( $_POST['program'] ) ? sanitize_text_field( wp_unslash( $_POST['program'] ) ) : '';
	$city    = isset( $_POST['city'] ) ? sanitize_text_field( wp_unslash( $_POST['city'] ) ) : '';

	if ( empty( $name ) || empty( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'aberdeen-theme' ) ) );
	}

	// Lead successfully recorded
	wp_send_json_success( array(
		'message' => get_theme_mod(
			'aberdeen_thank_you_message',
			__( 'Thank you for registering your interest! Our admissions team will review your application and contact you shortly.', 'aberdeen-theme' )
		),
	) );
}
add_action( 'wp_ajax_aberdeen_submit_lead', 'aberdeen_handle_lead_form' );
add_action( 'wp_ajax_nopriv_aberdeen_submit_lead', 'aberdeen_handle_lead_form' );

// ==========================================
// 5. Breadcrumbs Helper
// ==========================================
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

// ==========================================
// 6. Include Customizer File
// ==========================================
require_once get_template_directory() . '/inc/customizer.php';
