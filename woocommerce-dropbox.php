<?php
/*
Plugin Name: WooCommerce Dropbox
Version: 1.1.0
Description: WooCommerce Dropbox integration for downloadable products.
Author: Vadiem Janssens
Author URI: https://www.vadiemjanssens.nl
Plugin URI: https://www.vadiemjanssens.nl/woocommerce-dropbox
Text Domain: woocommerce-dropbox
Domain Path: /lang

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! defined( 'WCDB_URL' ) ) {
	define( 'WCDB_URL', plugin_dir_url(__FILE__) );
}

if ( ! defined( 'WCDB_PATH' ) ) {
	define( 'WCDB_PATH', plugin_dir_path(__FILE__) );
}

define('WCDB_VERSION', '1.1.0');

class WC_Dropbox {

	public function init() {

		// load translations
		add_action( 'plugins_loaded', array($this, 'load_translations') );

		// add integration
		add_filter( 'woocommerce_integrations', array($this, 'add_integration'), 10 );

		// add settings link to plugins overview page
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links') );
	}

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
			'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=integration' ) . '" title="' . esc_attr( __( 'View WooCommerce Dropbox Settings', 'woocommerce-dropbox' ) ) . '">' . __( 'Settings', 'woocommerce-dropbox' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}
}

$wcdropbox = new WC_Dropbox();
$wcdropbox->init();
