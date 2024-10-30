<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://boostools.app/wp/
 * @since      1.0.0
 *
 * @package    boostools
 * @subpackage boostools/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    boostools
 * @subpackage boostools/admin
 * @author     boostools Team <hello@boostools.com>
 */
class boostools_Admin {

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
		 * defined in boostools_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The boostools_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boostools-admin.css', array(), $this->version, 'all' );

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
		 * defined in boostools_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The boostools_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boostools-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	public function display_options_page() {
		include_once 'partials/boostools-admin-display.php';
	}
		
	public function register_setting() {
		add_settings_section(
			'boostools_general',
			__( 'General', 'Boostools' ),
			array( $this, 'boostools_general_cb' ),
			$this->plugin_name
		);
		add_settings_field(
			'boostools_option_subdomain_id',
			'Boostools script ON',
			array( $this, 'boostools_option_subdomain_cb' ),
			$this->plugin_name, 
			'boostools_general'
		);
		register_setting( $this->plugin_name, 'boostools_option_subdomain', array( $this, 'boostools_getcode' ) );
	}
	
	public function boostools_option_subdomain_cb() {
		/* echo "|".get_option('boostools_script')."|";
		print_r(get_option('boostools_script'));die; */
		if (get_option('boostools_script') == "") {
			echo '<input type="checkbox" name="boostools_option_subdomain" id="boostools_option_subdomain_id" value="on"> ';
		} else {
			echo '<input type="checkbox" name="boostools_option_subdomain" id="boostools_option_subdomain_id" checked value="on"> ';
		}
	}
	
	public function boostools_getcode($val) {

		if ($val == "on") {
			$val_t = get_site_url();
			$val_t = str_replace(".", "-", $val_t);
			$val_t = str_replace("http://", "", $val_t);
			$val_t = str_replace("https://", "", $val_t);
			
			$resp = json_decode(wp_remote_retrieve_body( wp_remote_get("https://boostools.app/help/config?subdomain=".urlencode($val_t), array('sslverify' => FALSE))));

			if(!$resp){ return "Domain not found!"; 	}
			if(isset($resp->errors) && $resp->errors ){ return "Domain not found!"; 	}
			$script = $resp->data;
			$script = "<script type='text/javascript'>(function(w,e,b) {e=w.createElement('script');e.type='text/javascript';e.async=true;e.src='https://cdn.boostools.app/js/$script.js';b=w.getElementsByTagName('script')[0];b.parentNode.insertBefore(e,b); })(document);</script>";
			update_option('boostools_script', $script);
		} else {
			update_option('boostools_script', "");
		}
		
		return $val;
	}
	
	public function boostools_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'Boostools' ) . '</p>';
	}
	
	public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Boostools Settings', 'Boostools' ),
			__( 'Boostools', 'Boostools' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	
	}

}
