# Changelog
All notable changes to WooCommerce Order Number Prefix will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [1.0.1] - 2025-09-10

### Changed
- Updated plugin name to "Order number prefix for WooCommerce" for better clarity
- Updated text domain to "order-number-prefix-for-woocommerce" to match plugin directory name
- Corrected license information in plugin header
- Updated plugin URI to reflect new repository name

## [1.0.0] - 2025-09-10

### Added
- Initial release of WooCommerce Order Number Prefix
- Custom prefix functionality for WooCommerce order numbers
- Integration with WooCommerce general settings page
- Support for alphanumeric characters, hyphens, and underscores in prefixes
- Maximum prefix length of 20 characters
- Pattern validation in settings field
- Search functionality for prefixed order numbers in admin
- Full compatibility with WooCommerce High-Performance Order Storage (HPOS)
- Internationalization support with text domain loading
- Proper sanitization and escaping for security
- WordPress coding standards compliance
- Singleton pattern implementation for main plugin class
- Activation and deactivation hooks
- Admin notice when WooCommerce is not active
- Settings persistence across deactivation/reactivation

### Security
- Input sanitization for all user-provided data
- Output escaping for all displayed content
- Capability checks for admin functions
- Nonce verification where appropriate
- Pattern validation for prefix input

### Technical
- Object-oriented architecture with singleton pattern
- Efficient WooCommerce detection
- Constants for option names and default values
- Proper hook priorities to avoid conflicts
- Clean uninstall handling

[1.0.1]: https://github.com/maikunari/order-number-prefix-for-woocommerce/releases/tag/v1.0.1
[1.0.0]: https://github.com/maikunari/woo-order-number-prefix/releases/tag/v1.0.0