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
		add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );

		// Add our custom scripts
		if($this->api_key) {
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
	 * Load the Dropbox API and our own script
	 * TODO: make the API call work via wp_enqueue_script (but with id and data attributes!)
	 */
	public function add_scripts() {
		echo '<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="' . $this->api_key . '"></script>';

		wp_register_script( 'woocommerce-dropbox', WCDB_URL . 'js/app.min.js', array( 'jquery', 'underscore' ), WCDB_VERSION );
		$translation_array = array(
			'filename' => __( 'File Name', 'woocommerce' ),
			'url' => __( "http://", 'woocommerce' ),
			'choosefile' => __( 'Choose file', 'woocommerce' ),
			'choosefilebutton' => str_replace( ' ', '&nbsp;', __( 'Choose file', 'woocommerce' )),
			'insertfileurl' => __( 'Insert file URL', 'woocommerce' ),
			'delete' => __( 'delete', 'woocommerce' )
		);
		wp_localize_script( 'woocommerce-dropbox', 'woocommerce_dropbox_translation', $translation_array );
		wp_enqueue_script( 'woocommerce-dropbox' );
	}
}