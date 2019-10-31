<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       lucasgerroir.com
 * @since      1.0.0
 *
 * @package    Instapull
 * @subpackage Instapull/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Instapull
 * @subpackage Instapull/admin
 * @author     Lucas Gerroir <lucasgerroir@gmail.com>
 */
class Instapull_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instapull_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instapull_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/instapull-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instapull_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instapull_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/instapull-admin.js', array( 'jquery' ), $this->version, false );

	}

	
	/**
	 * Method to add wordpress menu nav item.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_settings() {

		/*
		 * Add a settings page for Insta Pull to the Wordpress settings nav.
		 */

		add_options_page( 'WP Insta Pull Settings', 'WP Insta Pull', 'manage_options', $this->plugin_name, array($this, 'display_plugin_settings_page')
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @param    array    $links          Array of links for the wordpress menu. 
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {

		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);

		return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_settings_page() {
		
		// set a max of 12 here so the user can only set a max limit of 12
		// this is because the instagram graphql api call we are using only
		// returns 12 posts without setting up pagination or lazyload
		$limit_max = 12;
		
		include_once( 'partials/instapull-admin-display.php' );
	}

	/**
	*
	* When the admin settings page is submitted we want to validate the fields
	*
	* @since    1.0.0
	**/
	public function options_update() {

		register_setting($this->plugin_name, $this->plugin_name,  array(
			'sanitize_callback' => array( $this, 'validate_fields' ),
		 ));
		 
	 }

	/**
	*
	* This function validates and sanatizes the admin fields to avoid injections
	*
	* @param      array    $atts              All the inputs of the admin settings page.
	* @return     array    $valid             An array of validated fields.
	* @since    1.0.0
	**/
	public function validate_fields($input) {
		    
		$valid = array();
		
		// sanatize and validate
		$valid['feed'] = (isset($input['feed']) && !empty($input['feed'])) ? sanitize_text_field($input['feed']) : null;
		$valid['limit'] = (isset($input['limit']) && !empty($input['limit'])) ? sanitize_text_field($input['limit']): 10;
		$valid['title'] = (isset($input['title']) && !empty($input['title'])) ? sanitize_text_field($input['title']): null;

		return $valid;
	}


}
