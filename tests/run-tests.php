<?php
/**
 * Test Runner Script (Bonus 3)
 * Usage: php tests/run-tests.php
 */

// Load WordPress environment
require_once dirname( __DIR__ ) . '/wp-load.php';
require_once __DIR__ . '/test-click-tracking.php';

$suite = new Aberdeen_Click_Tracking_Tests();
$success = $suite->run();

exit( $success ? 0 : 1 );
