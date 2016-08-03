<?php

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * Class WC_Dropbox_Integration
 */
class WC_Dropbox_Integration extends WC_Integration {

	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		global $woocommerce;

		$this->id                 = 'woocommerce-dropbox';
		$this->method_title       = __( 'WooCommerce Dropbox', 'woocommerce-dropbox' );
		$this->method_description = __( 'Easily add downloadable products right from your Dropbox folder. Before you can start using our plugin, you will need to make a Dropbox app.<br>Don\'t worry, it sounds more difficult than it actually is. Please carefully read <a href="http://wordpress.org/plugins/woocommerce-dropbox/installation/" target="_blank">these instructions</a>.', 'woocommerce-dropbox' );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables.
		$this->api_key            = $this->get_option( 'api_key' );

		// Actions
		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );

		// Load custom scripts in the admin area
		if($this->api_key && is_admin()) {
			add_action( 'admin_head', array( $this, 'add_dropbox_api_js' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
		}
	}

	/**
	 * Initialize integration settings form fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'api_key' => array(
				'title'             => __( 'App key', 'woocommerce-dropbox' ),
				'type'              => 'text',
				'description'       => __( 'Please read <a href="http://wordpress.org/plugins/woocommerce-dropbox/installation/" target="_blank">these instructions</a> in order to obtain your app key.', 'woocommerce-dropbox' ),
				'desc_tip'          => false,
				'default'           => '',
				'placeholder' 		=> __( 'App key', 'woocommerce-dropbox' )
			)
		);
	}

	/**
	 * Add dropins.js script to the <head> of admin page
	 * Needs to be done this way because wp_register_script
	 * does not allow data-attributes or ID.
	 */
	public function add_dropbox_api_js() {
		echo '<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="' . $this->api_key . '"></script>';
	}

	/**
	 * Load the Dropbox API and our own script
	 */
	public function add_scripts() {

		// register scripts/styles
		wp_register_style( 'woocommerce-dropbox', WCDB_URL . 'assets/css/woocommerce-dropbox.css', false, WCDB_VERSION );
		wp_register_script( 'woocommerce-dropbox', WCDB_URL . 'assets/js/woocommerce-dropbox.js', array( 'jquery', 'underscore' ), WCDB_VERSION );

		// enqueue scripts/styles
		wp_enqueue_style( 'woocommerce-dropbox' );
		wp_enqueue_script( 'woocommerce-dropbox' );

		// register translations
		$translation_array = array(
			'choose_from_dropbox' => __( 'Choose from Dropbox', 'woocommerce-dropbox' )
		);
		wp_localize_script( 'woocommerce-dropbox', 'woocommerce_dropbox_translation', $translation_array );
	}
}
