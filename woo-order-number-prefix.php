<?php
/**
 * Plugin Name: WooCommerce Order Number Prefix
 * Plugin URI: https://sonicpixel.ca/
 * Description: Add prefixes to WooCommerce order numbers.
 * Version: 1.0.0
 * Author: Mike Sewell
 * Author URI: https://sonicpixel.ca
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wc-order-prefix
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * WC requires at least: 3.0
 * WC tested up to: 8.0
 *
 * @package WC_Order_Prefix
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
class WC_Order_Number_Prefix {

	/**
	 * Instance of this class.
	 *
	 * @var WC_Order_Number_Prefix
	 */
	private static $instance = null;

	/**
	 * Option name for storing the prefix.
	 *
	 * @var string
	 */
	const OPTION_NAME = 'wconp_order_number_prefix';

	/**
	 * Default prefix value.
	 *
	 * @var string
	 */
	const DEFAULT_PREFIX = 'WC-';

	/**
	 * Get instance of this class.
	 *
	 * @return WC_Order_Number_Prefix
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		// Load text domain.
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		// Check for WooCommerce.
		add_action( 'plugins_loaded', array( $this, 'check_requirements' ), 20 );
	}

	/**
	 * Load plugin text domain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'wc-order-prefix', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Check if requirements are met.
	 */
	public function check_requirements() {
		if ( ! $this->is_woocommerce_active() ) {
			add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
			return;
		}

		// Initialize plugin functionality.
		$this->init();
	}

	/**
	 * Check if WooCommerce is active.
	 *
	 * @return bool
	 */
	private function is_woocommerce_active() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Display admin notice when WooCommerce is not active.
	 */
	public function woocommerce_missing_notice() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		?>
		<div class="notice notice-error">
			<p>
				<?php
				printf(
					/* translators: %s: WooCommerce plugin name */
					esc_html__( 'WooCommerce Order Number Prefix requires %s to be installed and active.', 'wc-order-prefix' ),
					'<strong>WooCommerce</strong>'
				);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Initialize plugin hooks.
	 */
	private function init() {
		// Add settings field.
		add_filter( 'woocommerce_general_settings', array( $this, 'add_settings_field' ) );

		// Sanitize setting value.
		add_filter( 'woocommerce_admin_settings_sanitize_option_' . self::OPTION_NAME, array( $this, 'sanitize_prefix' ) );

		// Modify order number.
		add_filter( 'woocommerce_order_number', array( $this, 'add_prefix_to_order_number' ), 10, 2 );

		// Handle order search.
		add_filter( 'woocommerce_shop_order_search_fields', array( $this, 'search_by_prefixed_number' ) );

		// Support HPOS tables.
		add_action( 'before_woocommerce_init', array( $this, 'declare_hpos_compatibility' ) );
	}

	/**
	 * Declare High-Performance Order Storage compatibility.
	 */
	public function declare_hpos_compatibility() {
		if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
				'custom_order_tables',
				__FILE__,
				true
			);
		}
	}

	/**
	 * Add settings field to WooCommerce settings.
	 *
	 * @param array $settings Existing settings.
	 * @return array Modified settings.
	 */
	public function add_settings_field( $settings ) {
		$new_settings = array();
		$added        = false;

		foreach ( $settings as $setting ) {
			$new_settings[] = $setting;

			// Add our setting after the general options section.
			if ( ! $added &&
				isset( $setting['id'] ) &&
				'general_options' === $setting['id'] &&
				isset( $setting['type'] ) &&
				'sectionend' === $setting['type'] ) {

				$new_settings[] = array(
					'title'             => __( 'Order Number Prefix', 'wc-order-prefix' ),
					'desc'              => __( 'Enter the prefix for order numbers. Only alphanumeric characters, hyphens, and underscores are allowed (max 20 characters).', 'wc-order-prefix' ),
					'id'                => self::OPTION_NAME,
					'type'              => 'text',
					'default'           => self::DEFAULT_PREFIX,
					'css'               => 'width: 200px;',
					'desc_tip'          => true,
					'custom_attributes' => array(
						'maxlength' => '20',
						'pattern'   => '[A-Za-z0-9_-]*',
					),
				);
				$added          = true;
			}
		}

		return $new_settings;
	}

	/**
	 * Sanitize the prefix value.
	 *
	 * @param string $value Raw value.
	 * @return string Sanitized value.
	 */
	public function sanitize_prefix( $value ) {
		// Remove invalid characters.
		$sanitized = preg_replace( '/[^A-Za-z0-9_-]/', '', $value );

		// Limit length.
		$sanitized = substr( $sanitized, 0, 20 );

		// Return default if empty.
		return empty( $sanitized ) ? self::DEFAULT_PREFIX : $sanitized;
	}

	/**
	 * Add prefix to order number.
	 *
	 * @param string   $order_number Original order number.
	 * @param WC_Order $order        Order object.
	 * @return string Modified order number.
	 */
	public function add_prefix_to_order_number( $order_number, $order ) {
		// Validate order object.
		if ( ! $order instanceof WC_Order ) {
			return $order_number;
		}

		// Get and sanitize prefix.
		$prefix = $this->get_prefix();

		// Return prefixed order number.
		return $prefix . $order->get_id();
	}

	/**
	 * Get the current prefix setting.
	 *
	 * @return string
	 */
	private function get_prefix() {
		$prefix = get_option( self::OPTION_NAME, self::DEFAULT_PREFIX );
		return $this->sanitize_prefix( $prefix );
	}

	/**
	 * Extend search fields to handle prefixed order numbers.
	 *
	 * @param array $search_fields Default search fields.
	 * @return array Modified search fields.
	 */
	public function search_by_prefixed_number( $search_fields ) {
		global $wpdb;

		// Get the search term if available.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$search_term = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';

		if ( ! empty( $search_term ) ) {
			$prefix = $this->get_prefix();

			// Check if search term starts with our prefix.
			if ( 0 === strpos( $search_term, $prefix ) ) {
				// Extract the order ID.
				$order_id = absint( str_replace( $prefix, '', $search_term ) );

				if ( $order_id > 0 ) {
					// Add direct ID search.
					$search_fields[] = 'ID';

					// Modify the search to look for the exact ID.
					add_filter(
						'woocommerce_order_query_args',
						function ( $args ) use ( $order_id ) {
							$args['p'] = $order_id;
							unset( $args['s'] );
							return $args;
						},
						10,
						1
					);
				}
			}
		}

		return $search_fields;
	}

	/**
	 * Plugin activation hook.
	 */
	public static function activate() {
		// Set default option if not exists.
		if ( false === get_option( self::OPTION_NAME ) ) {
			add_option( self::OPTION_NAME, self::DEFAULT_PREFIX );
		}
	}

	/**
	 * Plugin deactivation hook.
	 */
	public static function deactivate() {
		// Optionally clean up - keeping settings for now in case of reactivation.
	}
}

// Initialize the plugin.
WC_Order_Number_Prefix::get_instance();

// Register activation/deactivation hooks.
register_activation_hook( __FILE__, array( 'WC_Order_Number_Prefix', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WC_Order_Number_Prefix', 'deactivate' ) );