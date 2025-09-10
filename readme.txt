=== WooCommerce Order Number Prefix ===
Contributors: maikunari
Donate link: https://ko-fi.com/maikunari
Tags: woocommerce, order number, order prefix, order management, ecommerce
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
WC requires at least: 3.0
WC tested up to: 9.0

Add customizable prefixes to your WooCommerce order numbers for better organization and branding.

== Description ==

**WooCommerce Order Number Prefix** is a lightweight plugin that allows you to add custom prefixes to your WooCommerce order numbers. Perfect for stores that need to organize orders by year, location, or brand, or simply want to add their company initials to order numbers.

= Key Features =

* **Customizable Prefix**: Add any prefix to your order numbers (alphanumeric, hyphens, and underscores supported)
* **Easy Configuration**: Simple settings integration with WooCommerce general settings
* **Search Compatible**: Search for orders using either the original order ID or the prefixed version
* **HPOS Compatible**: Full support for WooCommerce High-Performance Order Storage
* **Lightweight**: Minimal performance impact with efficient code
* **Secure**: Built with WordPress and WooCommerce security best practices
* **Translation Ready**: Full internationalization support

= Use Cases =

* **Multi-brand Stores**: Use different prefixes for different brands (BRAND1-, BRAND2-)
* **Year-based Organization**: Add year prefixes (2024-, 2025-)
* **Location-based Prefixes**: Identify orders by location (NYC-, LA-, UK-)
* **Company Branding**: Add your company initials to all orders
* **Department Organization**: Separate B2B and B2C orders (B2B-, B2C-)

= How It Works =

1. Install and activate the plugin
2. Navigate to WooCommerce > Settings > General
3. Find the "Order Number Prefix" field
4. Enter your desired prefix (e.g., "WC-", "2024-", "SHOP-")
5. Save your settings

All new and existing orders will display with your chosen prefix throughout the WooCommerce admin area, customer emails, and order pages.

= Technical Details =

* Stores prefix as a separate option, doesn't modify actual order IDs
* Compatible with other WooCommerce extensions
* Follows WordPress coding standards
* Implements proper sanitization and escaping
* Supports WooCommerce order searches with prefixed numbers

= Requirements =

* WordPress 5.0 or higher
* WooCommerce 3.0 or higher
* PHP 7.2 or higher

== Installation ==

= Automatic Installation =

1. Log in to your WordPress dashboard
2. Navigate to Plugins > Add New
3. Search for "WooCommerce Order Number Prefix"
4. Click "Install Now" and then "Activate"
5. Go to WooCommerce > Settings > General to configure your prefix

= Manual Installation =

1. Download the plugin zip file
2. Log in to your WordPress dashboard
3. Navigate to Plugins > Add New
4. Click "Upload Plugin" at the top of the page
5. Choose the downloaded zip file and click "Install Now"
6. Activate the plugin through the 'Plugins' menu in WordPress
7. Go to WooCommerce > Settings > General to configure your prefix

= Via FTP =

1. Download the plugin zip file and extract it
2. Upload the `woo-order-number-prefix` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to WooCommerce > Settings > General to configure your prefix

== Frequently Asked Questions ==

= Will this plugin change my actual order IDs in the database? =

No, the plugin only adds a visual prefix to order numbers throughout WooCommerce. Your actual order IDs in the database remain unchanged, ensuring compatibility with other plugins and systems.

= Can I change the prefix after orders have been placed? =

Yes, you can change the prefix at any time. The new prefix will apply to all orders (both existing and new) immediately after saving your settings.

= What characters can I use in the prefix? =

You can use letters (A-Z, a-z), numbers (0-9), hyphens (-), and underscores (_). The prefix is limited to 20 characters maximum.

= Will this work with my existing WooCommerce extensions? =

Yes, the plugin is designed to be compatible with other WooCommerce extensions. It uses standard WooCommerce hooks and filters to modify order number display without altering core functionality.

= Can I search for orders using the prefixed number? =

Yes! The plugin includes search functionality that allows you to search for orders using either the original order ID or the prefixed version in the WooCommerce orders list.

= Is this plugin compatible with WooCommerce High-Performance Order Storage (HPOS)? =

Yes, the plugin is fully compatible with WooCommerce's High-Performance Order Storage system.

= Can I use different prefixes for different order types or conditions? =

The current version supports one global prefix for all orders. For conditional prefixes based on order type, customer group, or other criteria, custom development would be required.

= Will the prefix appear in customer emails and invoices? =

Yes, the prefix will appear wherever WooCommerce displays the order number, including customer emails, admin emails, invoices, and the customer's account area.

= What happens if I deactivate the plugin? =

If you deactivate the plugin, order numbers will return to their original format (without the prefix). Your prefix settings are preserved if you reactivate the plugin later.

= Can I remove the prefix for certain areas of my site? =

The plugin applies the prefix globally wherever WooCommerce displays order numbers. Selective removal would require custom development.

= Is the plugin multisite compatible? =

Yes, the plugin can be activated on individual sites within a multisite network. Each site can have its own unique prefix.

= How can I get support? =

For support, please use the WordPress.org support forum for this plugin, or visit https://sonicpixel.ca/ for premium support options.

== Screenshots ==

1. Settings page - Configure your order number prefix in WooCommerce general settings
2. Orders list - View orders with custom prefixes in the admin dashboard
3. Order details - See the prefixed order number on individual order pages
4. Customer email - Prefixed order numbers in customer communications
5. Order search - Search functionality works with prefixed numbers

== Changelog ==

= 1.0.0 - 2024-01-15 =
* Initial release
* Custom prefix functionality
* WooCommerce settings integration
* Search compatibility for prefixed order numbers
* HPOS compatibility
* Translation ready
* Security hardening
* WordPress coding standards compliance

== Upgrade Notice ==

= 1.0.0 =
Initial release of WooCommerce Order Number Prefix.

== Additional Information ==

= Contributing =

Development of this plugin happens on GitHub. Feel free to contribute:
https://github.com/maikunari/woo-order-number-prefix

= Privacy Policy =

This plugin does not collect, store, or transmit any personal data. It only modifies the display of order numbers within your WooCommerce installation.

= Credits =

* Developed by Mike Sewell at [SonicPixel](https://sonicpixel.ca/)
* Built for the WooCommerce community

= Support =

For bug reports and feature requests, please use the [support forum](https://wordpress.org/support/plugin/woo-order-number-prefix/).

For premium support and custom development, visit [SonicPixel](https://sonicpixel.ca/).

== License ==

This plugin is licensed under the GPL v3 or later.

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.

Om Namo Bhagavate Vadudevaya