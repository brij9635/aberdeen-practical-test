<?php
/**
 * Test Suite: Click Tracking Helper & REST Endpoint Validation (Bonus 3)
 */

class Aberdeen_Click_Tracking_Tests {

	private $log_file;

	public function __construct() {
		$this->log_file = WP_CONTENT_DIR . '/uploads/logs/data-track.log';
	}

	public function run() {
		echo "========================================\n";
		echo "Running Programs Module Test Suite\n";
		echo "========================================\n\n";

		$passed = 0;
		$failed = 0;

		$tests = array(
			'test_helper_generates_valid_json_attribute',
			'test_helper_sanitizes_label_slugs',
			'test_endpoint_rejects_empty_payload',
			'test_endpoint_rejects_invalid_event_type',
			'test_endpoint_accepts_valid_click_and_appends_log',
		);

		foreach ( $tests as $test ) {
			try {
				$this->$test();
				echo " [PASS] {$test}\n";
				$passed++;
			} catch ( Exception $e ) {
				echo " [FAIL] {$test}: " . $e->getMessage() . "\n";
				$failed++;
			}
		}

		echo "\n----------------------------------------\n";
		echo "Results: {$passed} passed, {$failed} failed.\n";
		echo "----------------------------------------\n";

		return ( $failed === 0 );
	}

	/**
	 * Test 1: Helper generates valid data-track attribute
	 */
	public function test_helper_generates_valid_json_attribute() {
		$attr = program_track_attr( 'link', 'apply-now', 'programme-overview', 'componentLink' );

		if ( strpos( $attr, 'data-track="' ) !== 0 ) {
			throw new Exception( 'Attribute does not start with data-track="' );
		}

		// Extract JSON
		preg_match( '/^data-track="([^"]+)"$/', $attr, $matches );
		if ( empty( $matches[1] ) ) {
			throw new Exception( 'Could not extract JSON from data-track attribute' );
		}

		$decoded = json_decode( html_entity_decode( $matches[1], ENT_QUOTES, 'UTF-8' ), true );
		if ( ! is_array( $decoded ) ) {
			throw new Exception( 'Failed to decode JSON payload' );
		}

		if ( $decoded['type'] !== 'click' || $decoded['event'] !== 'link' ) {
			throw new Exception( 'type or event does not match expected values' );
		}

		if ( $decoded['link']['label'] !== 'apply-now' ) {
			throw new Exception( 'label does not match apply-now' );
		}

		if ( $decoded['content_data']['sectionName'] !== 'programme-overview' ) {
			throw new Exception( 'sectionName mismatch' );
		}
	}

	/**
	 * Test 2: Helper sanitizes labels properly
	 */
	public function test_helper_sanitizes_label_slugs() {
		$attr = program_track_attr( 'button', 'Enquire Now Here!', 'hero', 'componentButton' );
		preg_match( '/^data-track="([^"]+)"$/', $attr, $matches );
		$decoded = json_decode( html_entity_decode( $matches[1], ENT_QUOTES, 'UTF-8' ), true );

		if ( $decoded['button']['label'] !== 'enquire-now-here' ) {
			throw new Exception( 'Label was not sanitized to slug: ' . $decoded['button']['label'] );
		}
	}

	/**
	 * Test 3: REST endpoint rejects empty or malformed payload
	 */
	public function test_endpoint_rejects_empty_payload() {
		$request = new WP_REST_Request( 'POST', '/programs/v1/track' );
		$request->set_header( 'Content-Type', 'application/json' );
		$request->set_body( '' );

		$response = rest_do_request( $request );
		if ( $response->get_status() !== 400 ) {
			throw new Exception( 'Expected status 400, got: ' . $response->get_status() );
		}
	}

	/**
	 * Test 4: REST endpoint rejects invalid event types
	 */
	public function test_endpoint_rejects_invalid_event_type() {
		$request = new WP_REST_Request( 'POST', '/programs/v1/track' );
		$request->set_header( 'Content-Type', 'application/json' );
		$request->set_body( wp_json_encode( array(
			'payload' => array(
				'type'  => 'hover',
				'event' => 'custom',
			),
		) ) );

		$response = rest_do_request( $request );
		if ( $response->get_status() !== 422 ) {
			throw new Exception( 'Expected status 422, got: ' . $response->get_status() );
		}
	}

	/**
	 * Test 5: REST endpoint accepts valid payload and writes JSON Lines log
	 */
	public function test_endpoint_accepts_valid_click_and_appends_log() {
		$initial_lines = file_exists( $this->log_file ) ? count( file( $this->log_file ) ) : 0;

		$request = new WP_REST_Request( 'POST', '/programs/v1/track' );
		$request->set_header( 'Content-Type', 'application/json' );
		$request->set_body( wp_json_encode( array(
			'page_url' => '/programmes/bca',
			'payload'  => array(
				'type'         => 'click',
				'event'        => 'link',
				'link'         => array( 'label' => 'unit-test-click' ),
				'content_data' => array(
					'sectionName' => 'unit-test-suite',
					'uiComponent' => 'componentLink',
				),
			),
		) ) );

		$response = rest_do_request( $request );
		if ( $response->get_status() !== 200 ) {
			throw new Exception( 'Expected status 200, got: ' . $response->get_status() );
		}

		$new_lines = file_exists( $this->log_file ) ? count( file( $this->log_file ) ) : 0;
		if ( $new_lines <= $initial_lines ) {
			throw new Exception( 'Log line was not appended to data-track.log' );
		}

		// Verify last line content matches schema
		$lines     = file( $this->log_file );
		$last_line = trim( end( $lines ) );
		$decoded   = json_decode( $last_line, true );

		if ( ! isset( $decoded['timestamp'] ) || ! isset( $decoded['page_url'] ) || ! isset( $decoded['payload'] ) ) {
			throw new Exception( 'Appended log line does not match required schema' );
		}

		if ( $decoded['payload']['link']['label'] !== 'unit-test-click' ) {
			throw new Exception( 'Appended log line payload content mismatch' );
		}
	}
}
