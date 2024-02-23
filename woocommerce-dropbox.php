<?php
/**
 * Plugin Name: WooCommerce Dropbox
 * Version: 1.3.0
 * Description: WooCommerce Dropbox integration for downloadable products.
 * Author: Vadiem Janssens
 * Author URI: https://www.vadiemjanssens.nl
 * Plugin URI: https://www.vadiemjanssens.nl
 * Text Domain: woocommerce-dropbox
 * Domain Path: /lang
 *
 * WC requires at least: 4.8.0
 * WC tested up to: 5.6.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'WCDB_URL', plugin_dir_url(__FILE__) );
define( 'WCDB_PATH', plugin_dir_path(__FILE__) );
define( 'WCDB_BASENAME', plugin_basename(__FILE__) );

define('WCDB_VERSION', '1.3.0');

// declare support for HPOS
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

class WC_Dropbox {

	private $api_key;

	public function init() {

		// register activation hook
		register_activation_hook( __FILE__, array($this, 'activation_hook') );

		// show admin notices
		add_action( 'admin_notices', array($this, 'activation_notice') );

		// load translations
		add_action( 'plugins_loaded', array($this, 'load_translations') );

		// add settings to integrations tab
		add_filter( 'woocommerce_integrations', array($this, 'add_integration'), 10 );

		// add extra links to plugins overview page
		add_filter( 'plugin_action_links_' . WCDB_BASENAME, array($this, 'plugin_action_links') );
		add_filter( 'plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2 );
	}

	public function activation_hook() {
		set_transient( 'activation_hook_transient', true, 5 );
	}

	/**
	 * Show a notice after activation of the plugin
	 */
	public function activation_notice() {
		if( get_transient( 'activation_hook_transient' ) ) {
			$class = 'notice updated notice is-dismissible';
			$strings = [
				__( 'Great, you\'re almost ready to start using WooCommerce Dropbox! Please go to the', 'woocommerce-dropbox' ),
				' <a href="' . admin_url( 'admin.php?page=wc-settings&tab=integration&section=woocommerce-dropbox' ) . '" title="' . esc_attr( __( 'View WooCommerce Dropbox Settings', 'woocommerce-dropbox' ) ) . '">',
				__( 'WooCommerce Settings', 'woocommerce-dropbox' ),
				'</a> ',
				__( 'to configure the plugin.', 'woocommerce-dropbox' ),
			];
			$message = implode('', $strings);

			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
			delete_transient( 'activation_hook_transient' );
		}
	}

	/**
	 * Load translation files
	 */
	public function load_translations() {
		load_plugin_textdomain( 'woocommerce-dropbox', false, WCDB_PATH . '/lang/' );
	}

	/**
	 * Add our Integration to the WooCommerce settings page
	 */
	public function add_integration( $integrations ) {
		global $woocommerce;

		if ( is_object( $woocommerce ) && version_compare( $woocommerce->version, '2.5', '>=' ) ) {
			include_once( 'classes/class-wcintegration.php' );
			$integrations[] = 'WC_Dropbox_Integration';
		}

		return $integrations;
	}

	/**
	 * Add a 'Settings' link on the plugins overview page
	 */
	public function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=integration&section=woocommerce-dropbox' ) . '" title="' . esc_attr( __( 'View WooCommerce Dropbox Settings', 'woocommerce-dropbox' ) ) . '">' . __( 'Settings', 'woocommerce-dropbox' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	public function plugin_row_meta( $links, $file ) {
		if ( $file == WCDB_BASENAME ) {
			$row_meta = array(
				'instructions'  => '<a href="' . esc_url( 'https://wordpress.org/plugins/woocommerce-dropbox/installation/' ) . '" title="' . esc_attr( __( 'View WooCommerde Dropbox Installation Instructions', 'woocommerce-dropbox' ) ) . '" target="_blank">' . __( 'Installation', 'woocommerce-dropbox' ) . '</a>',
				'support'  => '<a href="' . esc_url( 'https://wordpress.org/support/plugin/woocommerce-dropbox#postform' ) . '" title="' . esc_attr( __( 'View WooCommerde Dropbox Support Forum', 'woocommerce-dropbox' ) ) . '" target="_blank">' . __( 'Support', 'woocommerce-dropbox' ) . '</a>',
				'rate'    		=> '<a href="' . esc_url( 'https://wordpress.org/support/view/plugin-reviews/woocommerce-dropbox#postform' ) . '" title="' . esc_attr( __( 'Please Rate WooCommerde Dropbox', 'woocommerce-dropbox' ) ) . '" target="_blank">' . __( 'Rate this plugin', 'woocommerce-dropbox' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}
}

$wcdropbox = new WC_Dropbox();
$wcdropbox->init();
