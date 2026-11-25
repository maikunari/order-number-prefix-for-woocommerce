<?php
/**
 * Plugin Name: Order number prefix for WooCommerce
 * Plugin URI: https://github.com/maikunari/woo-order-number-prefix
 * Description: Add prefixes to WooCommerce order numbers.
 * Version: 1.0.3
 * Author: Sonic Pixel
 * Author URI: https://sonicpixel.io
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: order-number-prefix-for-woocommerce
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Requires Plugins: woocommerce
 * WC requires at least: 3.0
 * WC tested up to: 11.3
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check if WooCommerce is active
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Core WordPress hook.
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    return;
}

/**
 * Declare compatibility with WooCommerce High-Performance Order Storage (HPOS).
 *
 * The plugin only reads orders through the WC_Order API, so it works with both
 * the posts and the custom order tables storage.
 */
add_action('before_woocommerce_init', 'order_number_prefix_declare_hpos_compatibility');
function order_number_prefix_declare_hpos_compatibility() {
    if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
}

/**
 * Add prefix to WooCommerce order numbers
 *
 * @param string $order_id The original order ID
 * @param WC_Order $order The order object
 * @return string The modified order number with prefix
 */
add_filter('woocommerce_order_number', 'change_woocommerce_order_number', 10, 2);
function change_woocommerce_order_number($order_id, $order) {
    $prefix = 'WC-';
    
    // Use the getter method instead of direct property access
    return $prefix . $order->get_id();
}

// Optional: Add a settings page to customize the prefix
add_filter('woocommerce_general_settings', 'order_number_prefix_add_setting');
function order_number_prefix_add_setting($settings) {
    $updated_settings = array();
    
    foreach ($settings as $section) {
        $updated_settings[] = $section;
        
        if (isset($section['id']) && 'general_options' == $section['id'] && 
            isset($section['type']) && 'sectionend' == $section['type']) {
            
            $updated_settings[] = array(
                'name'     => __('Order Number Prefix', 'order-number-prefix-for-woocommerce'),
                'desc_tip' => __('This prefix will be added to all order numbers.', 'order-number-prefix-for-woocommerce'),
                'id'       => 'wc_order_number_prefix',
                'type'     => 'text',
                'css'      => 'min-width:300px;',
                'default'  => 'WC-',
                'desc'     => __('Enter the prefix for order numbers.', 'order-number-prefix-for-woocommerce'),
            );
        }
    }
    
    return $updated_settings;
}

// Use the customizable prefix from settings
add_filter('woocommerce_order_number', 'change_woocommerce_order_number_with_setting', 10, 2);
function change_woocommerce_order_number_with_setting($order_id, $order) {
    // Get the prefix from settings, default to 'WC-' if not set
    $prefix = get_option('wc_order_number_prefix', 'WC-');
    
    return $prefix . $order->get_id();
}
?>