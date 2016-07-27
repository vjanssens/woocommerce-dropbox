<?php

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
		$this->method_title       = __( 'Dropbox Integration', 'woocommerce-dropbox' );
		$this->method_description = __( 'Easily add downloadable products right from your Dropbox folder. Before you can start using our plugin, you will need to make a Dropbox app.<br>Don\'t worry, it sounds more difficult than it actually is. Please carefully read <a href="http://wordpress.org/plugins/woocommerce-dropbox/installation/" target="_blank">these instructions</a>.', 'woocommerce-dropbox' );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables.
		$this->api_key          = $this->get_option( 'api_key' );

		// Actions.
		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );

		// Add our custom scripts
		if($this->api_key) {
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
				'title'             => __( 'API Key', 'woocommerce-dropbox' ),
				'type'              => 'text',
				'description'       => __( 'Please provide your Dropbox API key. Please read <a href="http://wordpress.org/plugins/woocommerce-dropbox/installation/" target="_blank">these instructions</a> in order to obtain your API key.', 'woocommerce-dropbox' ),
				'desc_tip'          => false,
				'default'           => ''
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

		// register and enqueue style
		wp_register_style( 'woocommerce-dropbox', WCDB_URL . 'assets/css/woocommerce-dropbox.css', false, WCDB_VERSION );
        wp_enqueue_style( 'woocommerce-dropbox' );

		// register and enqueue script
		wp_register_script( 'woocommerce-dropbox', WCDB_URL . 'assets/js/woocommerce-dropbox.js', array( 'jquery', 'underscore' ), WCDB_VERSION );
		wp_enqueue_script( 'woocommerce-dropbox' );

		// register translations
		$translation_array = array(
			'choose_from_dropbox' => __( 'Choose from Dropbox', 'woocommerce-dropbox' )
		);
		wp_localize_script( 'woocommerce-dropbox', 'woocommerce_dropbox_translation', $translation_array );

	}
}