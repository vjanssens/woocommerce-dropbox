<?php
/*
Plugin Name: WooCommerce Dropbox
Version: 1.0.2
Description: WooCommerce Dropbox integration for downloadable products.
Author: Vadiem Janssens
Author URI: http://www.vadiemjanssens.nl
Plugin URI: http://www.vadiemjanssens.nl/woocommerce-dropbox
Text Domain: woocommerce-dropbox
Domain Path: /languages

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

define('WCDB_VERSION', '1.0.2');

class WC_Dropbox {

	/**
	 * Add our Integration to the WooCommerce settings page
	 */
	public static function add_integration( $integrations ) {
		global $woocommerce;

		if ( is_object( $woocommerce ) && version_compare( $woocommerce->version, '2.1', '>=' ) ) {
			include_once( 'classes/class-wcintegration.php' );
			$integrations[] = 'WC_Dropbox_Integration';
		}

		return $integrations;
	}
}

add_filter( 'woocommerce_integrations', array('WC_Dropbox', 'add_integration'), 10 );