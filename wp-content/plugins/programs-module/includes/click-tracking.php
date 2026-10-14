<?php
/**
 * Task 8: Click Tracking REST API & Secure JSON Lines Logger
 *
 * Provides POST /wp-json/programs/v1/track endpoint and appends
 * strictly validated click tracking payloads to wp-content/uploads/logs/data-track.log.
 *
 * @package Programs_Module
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ==========================================
// 1. Register REST Route (POST /wp-json/programs/v1/track)
// ==========================================
function aberdeen_register_click_tracking_route() {
	register_rest_route( 'programs/v1', '/track', array(
		'methods'             => WP_REST_Server::CREATABLE, // POST
		'callback'            => 'aberdeen_handle_track_event',
		'permission_callback' => '__return_true', // Public tracking endpoint protected by strict validation and body size limit
	) );
}
add_action( 'rest_api_init', 'aberdeen_register_click_tracking_route' );

// ==========================================
// 2. Handle & Validate Click Event
// ==========================================
function aberdeen_handle_track_event( WP_REST_Request $request ) {
	// Reject oversized bodies (> 10KB) to prevent resource abuse
	$raw_body = $request->get_body();
	if ( strlen( $raw_body ) > 10240 ) {
		return new WP_Error( 'payload_too_large', __( 'Payload size exceeds allowable limit.', 'programs-module' ), array( 'status' => 413 ) );
	}

	$body = $request->get_json_params();
	if ( empty( $body ) || ! is_array( $body ) ) {
		return new WP_Error( 'invalid_payload', __( 'Invalid or malformed JSON payload.', 'programs-module' ), array( 'status' => 400 ) );
	}

	// Support both nested payload format { page_url, payload } and flat payload
	$payload_data = isset( $body['payload'] ) && is_array( $body['payload'] ) ? $body['payload'] : $body;

	// Extract page_url context safely
	$page_url = isset( $body['page_url'] ) ? sanitize_text_field( $body['page_url'] ) : '';
	if ( empty( $page_url ) && isset( $_SERVER['HTTP_REFERER'] ) ) {
		$parsed_ref = wp_parse_url( $_SERVER['HTTP_REFERER'] );
		$page_url   = isset( $parsed_ref['path'] ) ? sanitize_text_field( $parsed_ref['path'] ) : '/';
	}
	if ( empty( $page_url ) ) {
		$page_url = '/';
	}

	// 1. Validate type strictly (must be "click")
	$type = isset( $payload_data['type'] ) ? sanitize_text_field( $payload_data['type'] ) : '';
	if ( 'click' !== $type ) {
		return new WP_Error( 'invalid_type', __( 'Payload type must be click.', 'programs-module' ), array( 'status' => 422 ) );
	}

	// 2. Validate event strictly (must be "link" or "button")
	$event = isset( $payload_data['event'] ) ? sanitize_text_field( $payload_data['event'] ) : '';
	if ( ! in_array( $event, array( 'link', 'button' ), true ) ) {
		return new WP_Error( 'invalid_event', __( 'Event must be either link or button.', 'programs-module' ), array( 'status' => 422 ) );
	}

	// 3. Validate and sanitize label (short sanitized slug)
	$label = '';
	if ( 'link' === $event && isset( $payload_data['link']['label'] ) ) {
		$label = sanitize_title( substr( (string) $payload_data['link']['label'], 0, 100 ) );
	} elseif ( 'button' === $event && isset( $payload_data['button']['label'] ) ) {
		$label = sanitize_title( substr( (string) $payload_data['button']['label'], 0, 100 ) );
	}

	if ( empty( $label ) ) {
		return new WP_Error( 'missing_label', __( 'Click event must contain a valid label.', 'programs-module' ), array( 'status' => 422 ) );
	}

	// 4. Validate and sanitize content_data (strings only)
	$content_data_raw = isset( $payload_data['content_data'] ) && is_array( $payload_data['content_data'] ) ? $payload_data['content_data'] : array();
	$section_name     = isset( $content_data_raw['sectionName'] ) ? sanitize_text_field( $content_data_raw['sectionName'] ) : '';
	$ui_component     = isset( $content_data_raw['uiComponent'] ) ? sanitize_text_field( $content_data_raw['uiComponent'] ) : '';

	// 5. Drop unknown keys: strictly build canonical clean payload
	$clean_payload = array(
		'type'         => 'click',
		'event'        => $event,
		$event         => array(
			'label' => $label,
		),
		'content_data' => array(
			'sectionName' => $section_name,
			'uiComponent' => $ui_component,
		),
	);

	// 6. Build the exact log line schema specified by PDF Page 7:
	// {"timestamp":"2026-10-01T10:15:30+00:00","page_url":"/programmes/undergraduate","payload":{"type":"click","event":"link","link":{"label":"apply-now"},"content_data":{"sectionName":"programme-overview","uiComponent":"componentLink"}}}
	$log_entry = array(
		'timestamp' => gmdate( 'c' ),
		'page_url'  => $page_url,
		'payload'   => $clean_payload,
	);

	// Write to JSON Lines log file
	$written = aberdeen_write_track_log( $log_entry );

	if ( false === $written ) {
		return new WP_Error( 'log_write_failed', __( 'Could not write tracking log.', 'programs-module' ), array( 'status' => 500 ) );
	}

	return rest_ensure_response( array(
		'success'   => true,
		'timestamp' => $log_entry['timestamp'],
		'event'     => $event,
		'label'     => $label,
	) );
}

// ==========================================
// 3. Append to JSON Lines Log File (.log)
// ==========================================
function aberdeen_write_track_log( $entry ) {
	$log_dir = WP_CONTENT_DIR . '/uploads/logs';

	// Create directory if missing
	if ( ! file_exists( $log_dir ) ) {
		wp_mkdir_p( $log_dir );
	}

	// Ensure .htaccess deny rule exists
	$htaccess = $log_dir . '/.htaccess';
	if ( ! file_exists( $htaccess ) ) {
		file_put_contents( $htaccess, "Order Deny,Allow\nDeny from all\n<Files ~ \"^.*\">\n  Deny from all\n</Files>\n" );
	}

	// Ensure index.php exists
	$index_php = $log_dir . '/index.php';
	if ( ! file_exists( $index_php ) ) {
		file_put_contents( $index_php, "<?php\n// Silence is golden.\n" );
	}

	// Filterable log file path (PDF requirement: inside uploads/logs/ with name data-track.log)
	$log_file = apply_filters( 'programs_track_log_path', $log_dir . '/data-track.log' );

	$json_line = wp_json_encode( $entry, JSON_UNESCAPED_SLASHES ) . PHP_EOL;

	// Write with LOCK_EX for atomic append
	return ( false !== file_put_contents( $log_file, $json_line, FILE_APPEND | LOCK_EX ) );
}

// ==========================================
// 4. Log Rotation & 30-Day Cleanup via WP-Cron (Bonus 5)
// ==========================================
if ( ! function_exists( 'aberdeen_schedule_log_cleanup_cron' ) ) {
	function aberdeen_schedule_log_cleanup_cron() {
		if ( ! wp_next_scheduled( 'aberdeen_log_maintenance_cron' ) ) {
			wp_schedule_event( time(), 'daily', 'aberdeen_log_maintenance_cron' );
		}
	}
	add_action( 'init', 'aberdeen_schedule_log_cleanup_cron' );
}

if ( ! function_exists( 'aberdeen_run_log_maintenance' ) ) {
	function aberdeen_run_log_maintenance() {
		$log_dir = WP_CONTENT_DIR . '/uploads/logs';
		if ( ! is_dir( $log_dir ) ) {
			return;
		}

		// 1. Log Rotation: If data-track.log > 5MB, rotate to archive
		$current_log = $log_dir . '/data-track.log';
		if ( file_exists( $current_log ) && filesize( $current_log ) > ( 5 * 1024 * 1024 ) ) {
			$rotated_name = $log_dir . '/data-track-' . gmdate( 'Y-m-d-His' ) . '.log';
			@rename( $current_log, $rotated_name );
		}

		// 2. Automatic Cleanup: Delete log files older than 30 days
		$thirty_days_ago = time() - ( 30 * DAY_IN_SECONDS );
		$files           = glob( $log_dir . '/*.log' );

		if ( ! empty( $files ) && is_array( $files ) ) {
			foreach ( $files as $file ) {
				// Don't delete active log if recent
				if ( basename( $file ) === 'data-track.log' ) {
					continue;
				}

				if ( file_exists( $file ) && filemtime( $file ) < $thirty_days_ago ) {
					@unlink( $file );
				}
			}
		}
	}
	add_action( 'aberdeen_log_maintenance_cron', 'aberdeen_run_log_maintenance' );
}

