<?php
/**
 * Task 3: Custom Fields & React Admin Metabox
 *
 * Handles post meta registration, modern card-based React admin metabox,
 * media library integration, and secure server-side sanitization.
 *
 * @package Aberdeen_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ==========================================
// 1. Register Post Meta (REST API Ready)
// ==========================================
function aberdeen_register_program_meta() {
	// 1. Academic Year (e.g. "2025-26")
	register_post_meta( 'program', '_program_academic_year', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'description'       => __( 'Academic session/intake year (e.g. 2025-26)', 'aberdeen-theme' ),
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );

	// Public alias for REST
	register_post_meta( 'program', 'academic_year', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	// 2. Duration (e.g. "3 Years")
	register_post_meta( 'program', '_program_duration', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'description'       => __( 'Program study duration (e.g. 3 Years)', 'aberdeen-theme' ),
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );

	// Public alias for REST
	register_post_meta( 'program', 'duration', array(
		'show_in_rest'      => true,
		'single'            => true,
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	// 3. Content Sections (Repeater: array of objects)
	$repeater_schema = array(
		'type'  => 'array',
		'items' => array(
			'type'       => 'object',
			'properties' => array(
				'id'          => array( 'type' => 'string' ),
				'title'       => array( 'type' => 'string' ),
				'description' => array( 'type' => 'string' ),
				'image_id'    => array( 'type' => 'integer' ),
				'image_url'   => array( 'type' => 'string' ),
			),
		),
	);

	register_post_meta( 'program', '_program_content_sections', array(
		'show_in_rest'      => array(
			'schema' => $repeater_schema,
		),
		'single'            => true,
		'type'              => 'array',
		'description'       => __( 'Repeater array of rich program content sections', 'aberdeen-theme' ),
		'sanitize_callback' => 'aberdeen_sanitize_repeater_sections',
		'auth_callback'     => function() {
			return current_user_can( 'edit_posts' );
		},
	) );

	register_post_meta( 'program', 'content_sections', array(
		'show_in_rest'      => array(
			'schema' => $repeater_schema,
		),
		'single'            => true,
		'type'              => 'array',
		'sanitize_callback' => 'aberdeen_sanitize_repeater_sections',
	) );
}
add_action( 'init', 'aberdeen_register_program_meta' );

/**
 * Sanitizer for Content Sections array
 */
function aberdeen_sanitize_repeater_sections( $sections ) {
	if ( is_string( $sections ) ) {
		$decoded = json_decode( $sections, true );
		$sections = is_array( $decoded ) ? $decoded : array();
	}

	if ( ! is_array( $sections ) ) {
		return array();
	}

	$clean = array();
	foreach ( $sections as $section ) {
		if ( ! is_array( $section ) ) {
			continue;
		}

		$clean[] = array(
			'id'          => ! empty( $section['id'] ) ? sanitize_key( $section['id'] ) : 'sec_' . wp_generate_password( 8, false ),
			'title'       => ! empty( $section['title'] ) ? sanitize_text_field( $section['title'] ) : '',
			'description' => ! empty( $section['description'] ) ? wp_kses_post( $section['description'] ) : '',
			'image_id'    => ! empty( $section['image_id'] ) ? absint( $section['image_id'] ) : 0,
			'image_url'   => ! empty( $section['image_url'] ) ? esc_url_raw( $section['image_url'] ) : '',
		);
	}

	return $clean;
}

// ==========================================
// 2. Add Custom Metabox
// ==========================================
function aberdeen_add_program_metaboxes() {
	add_meta_box(
		'aberdeen_program_details_metabox',
		__( 'Programme Specifications & Content Sections', 'aberdeen-theme' ),
		'aberdeen_render_program_metabox_callback',
		'program',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_program', 'aberdeen_add_program_metaboxes' );

/**
 * Render root container and hidden inputs
 */
function aberdeen_render_program_metabox_callback( $post ) {
	// Add nonce for verification
	wp_nonce_field( 'aberdeen_save_program_meta_action', 'aberdeen_program_meta_nonce' );

	$academic_year    = get_post_meta( $post->ID, '_program_academic_year', true );
	$duration         = get_post_meta( $post->ID, '_program_duration', true );
	$content_sections = get_post_meta( $post->ID, '_program_content_sections', true );
	if ( empty( $content_sections ) || ! is_array( $content_sections ) ) {
		$content_sections = array();
	}
	?>
	<!-- React Root Container -->
	<div id="aberdeen-program-metabox-root">
		<div style="padding: 20px; text-align: center; color: #64748b;">
			<span class="dashicons dashicons-update spin"></span>
			<em>Loading Programme Custom Fields (React UI)...</em>
		</div>
	</div>

	<!-- Hidden inputs synced with React state for native form submission -->
	<input type="hidden" id="aberdeen_academic_year_field" name="aberdeen_academic_year" value="<?php echo esc_attr( $academic_year ); ?>" />
	<input type="hidden" id="aberdeen_duration_field" name="aberdeen_duration" value="<?php echo esc_attr( $duration ); ?>" />
	<input type="hidden" id="aberdeen_content_sections_json_field" name="aberdeen_content_sections_json" value="<?php echo esc_attr( wp_json_encode( $content_sections ) ); ?>" />
	<?php
}

// ==========================================
// 3. Enqueue Admin Assets (CSS, JS & Media)
// ==========================================
function aberdeen_enqueue_program_admin_assets( $hook ) {
	global $post;

	// Only enqueue on post.php and post-new.php for post type 'program'
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'program' !== $screen->post_type ) {
		return;
	}

	// Native WordPress Media Uploader Modal
	wp_enqueue_media();

	// Custom Metabox CSS
	$css_file = get_template_directory() . '/assets/css/admin-metabox.css';
	$css_ver  = file_exists( $css_file ) ? filemtime( $css_file ) : '1.0.0';
	wp_enqueue_style(
		'aberdeen-admin-metabox-css',
		get_template_directory_uri() . '/assets/css/admin-metabox.css',
		array( 'dashicons' ),
		$css_ver
	);

	// React Repeater JS
	$js_file = get_template_directory() . '/assets/js/admin-repeater.js';
	$js_ver  = file_exists( $js_file ) ? filemtime( $js_file ) : '1.0.0';
	wp_enqueue_script(
		'aberdeen-admin-repeater-js',
		get_template_directory_uri() . '/assets/js/admin-repeater.js',
		array( 'wp-element', 'wp-components', 'wp-i18n' ),
		$js_ver,
		true
	);

	// Fetch existing data for current post
	$post_id          = $post ? $post->ID : 0;
	$academic_year    = $post_id ? get_post_meta( $post_id, '_program_academic_year', true ) : '';
	$duration         = $post_id ? get_post_meta( $post_id, '_program_duration', true ) : '';
	$content_sections = $post_id ? get_post_meta( $post_id, '_program_content_sections', true ) : array();
	if ( empty( $content_sections ) || ! is_array( $content_sections ) ) {
		$content_sections = array();
	}

	// Localize script with initial data
	wp_localize_script(
		'aberdeen-admin-repeater-js',
		'aberdeenMetaboxData',
		array(
			'academicYear'    => $academic_year,
			'duration'        => $duration,
			'contentSections' => $content_sections,
		)
	);
}
add_action( 'admin_enqueue_scripts', 'aberdeen_enqueue_program_admin_assets' );

// ==========================================
// 4. Save Custom Fields Data
// ==========================================
function aberdeen_save_program_meta( $post_id ) {
	// Nonce verification
	if ( ! isset( $_POST['aberdeen_program_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aberdeen_program_meta_nonce'] ) ), 'aberdeen_save_program_meta_action' ) ) {
		return;
	}

	// Prevent auto-save and revision overwriting
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	// Check user capability
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// 1. Save Academic Year
	if ( isset( $_POST['aberdeen_academic_year'] ) ) {
		$clean_year = sanitize_text_field( wp_unslash( $_POST['aberdeen_academic_year'] ) );
		update_post_meta( $post_id, '_program_academic_year', $clean_year );
		update_post_meta( $post_id, 'academic_year', $clean_year );
	}

	// 2. Save Duration
	if ( isset( $_POST['aberdeen_duration'] ) ) {
		$clean_duration = sanitize_text_field( wp_unslash( $_POST['aberdeen_duration'] ) );
		update_post_meta( $post_id, '_program_duration', $clean_duration );
		update_post_meta( $post_id, 'duration', $clean_duration );
	}

	// 3. Save Content Sections Repeater
	if ( isset( $_POST['aberdeen_content_sections_json'] ) ) {
		$raw_json = wp_unslash( $_POST['aberdeen_content_sections_json'] );
		$clean_sections = aberdeen_sanitize_repeater_sections( $raw_json );

		update_post_meta( $post_id, '_program_content_sections', $clean_sections );
		update_post_meta( $post_id, 'content_sections', $clean_sections );
	}
}
add_action( 'save_post_program', 'aberdeen_save_program_meta' );
