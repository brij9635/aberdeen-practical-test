<?php
/**
 * Plugin Name:       Programs Module
 * Plugin URI:        https://www.abdn.ac.uk/
 * Description:       Core backend module for University of Aberdeen: Program Custom Post Type, Taxonomy, Custom Fields with React Admin UI, and REST API Click-Tracking Engine.
 * Version:           1.0.0
 * Author:            University of Aberdeen / Brijesh
 * Author URI:        https://www.abdn.ac.uk/
 * Text Domain:       programs-module
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      7.4
 *
 * @package Programs_Module
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Constants
define( 'PROGRAMS_MODULE_VERSION', '1.0.0' );
define( 'PROGRAMS_MODULE_FILE', __FILE__ );
define( 'PROGRAMS_MODULE_PATH', plugin_dir_path( __FILE__ ) );
define( 'PROGRAMS_MODULE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Main Programs Module Class
 */
final class Programs_Module {

	/**
	 * Single instance of the class
	 *
	 * @var Programs_Module
	 */
	private static $instance = null;

	/**
	 * Get class instance
	 *
	 * @return Programs_Module
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required files
	 */
	private function includes() {
		require_once PROGRAMS_MODULE_PATH . 'includes/cpt-program.php';
		require_once PROGRAMS_MODULE_PATH . 'includes/custom-fields.php';
		require_once PROGRAMS_MODULE_PATH . 'includes/click-tracking.php';
		require_once PROGRAMS_MODULE_PATH . 'includes/seed-data.php';
	}

	/**
	 * Initialize WordPress hooks
	 */
	private function init_hooks() {
		register_activation_hook( PROGRAMS_MODULE_FILE, array( $this, 'activate' ) );
		register_deactivation_hook( PROGRAMS_MODULE_FILE, array( $this, 'deactivate' ) );
	}

	/**
	 * Plugin Activation
	 */
	public function activate() {
		// 1. Ensure CPT & taxonomy are registered before flushing
		if ( function_exists( 'aberdeen_register_program_taxonomy' ) ) {
			aberdeen_register_program_taxonomy();
		}
		if ( function_exists( 'aberdeen_register_program_cpt' ) ) {
			aberdeen_register_program_cpt();
		}
		if ( function_exists( 'aberdeen_seed_program_terms' ) ) {
			aberdeen_seed_program_terms();
		}

		// 2. Flush rewrite rules
		flush_rewrite_rules();

		// 3. Ensure secure logging directory exists for Task 8
		$log_dir = WP_CONTENT_DIR . '/uploads/logs';
		if ( ! file_exists( $log_dir ) ) {
			wp_mkdir_p( $log_dir );
		}

		// Protect logs directory with .htaccess and empty index.php
		$htaccess_file = $log_dir . '/.htaccess';
		if ( ! file_exists( $htaccess_file ) ) {
			file_put_contents( $htaccess_file, "Order Deny,Allow\nDeny from all\n<Files ~ \"^.*\">\n  Deny from all\n</Files>\n" );
		}

		$index_file = $log_dir . '/index.php';
		if ( ! file_exists( $index_file ) ) {
			file_put_contents( $index_file, "<?php\n// Silence is golden.\n" );
		}
	}

	/**
	 * Plugin Deactivation
	 */
	public function deactivate() {
		flush_rewrite_rules();
	}
}

/**
 * Bootstrap the plugin
 */
function programs_module() {
	return Programs_Module::get_instance();
}
programs_module();
