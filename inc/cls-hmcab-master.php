<?php
/**
 * Our main plugin class
*/
class HMCABW_Master {

	protected $hmcabw_loader;
	protected $hmcabw_version;
	
	/**
	 * Class Constructor
	*/
	public function __construct() {
		$this->hmcabw_version = HMCABW_VERSION;
		add_action( 'plugins_loaded', array($this, 'hmcabw_load_plugin_textdomain') );
		$this->hmcabw_load_dependencies();
		$this->hmcabw_trigger_widget_hooks();
		$this->hmcabw_trigger_admin_hooks();
		$this->hmcabw_trigger_front_hooks();
	}
	
	function hmcabw_load_plugin_textdomain(){
		load_plugin_textdomain( HMCABW_TXT_DOMAIN, FALSE, HMCABW_TXT_DOMAIN . '/languages/' );
	}

	private function hmcabw_load_dependencies() {

		require_once HMCABW_PATH . 'widget/' . HMCABW_CLASSPREFIX . 'widget.php';
		require_once HMCABW_PATH . 'admin/' . HMCABW_CLASSPREFIX . 'admin.php';
		require_once HMCABW_PATH . 'front/' . HMCABW_CLASSPREFIX . 'front.php';
		
		require_once HMCABW_PATH . 'inc/' . HMCABW_CLASSPREFIX . 'loader.php';
		$this->hmcabw_loader = new HMCABW_Loader();
	}
	
	private function hmcabw_trigger_widget_hooks() {

		new Hmcabw_Widget();
		add_action( 'widgets_init', function(){ register_widget( 'Hmcabw_Widget' ); });
	}
	
	private function hmcabw_trigger_admin_hooks() {
		$hmcabw_admin = new Hmcabw_Admin( $this->hmcabw_version() );
		$this->hmcabw_loader->add_action( 'admin_menu', $hmcabw_admin, HMCABW_PREFIX . 'admin_menu' );
		$this->hmcabw_loader->add_action( 'admin_enqueue_scripts', $hmcabw_admin, HMCABW_PREFIX . 'enqueue_assets' );
		$this->hmcabw_loader->add_action( 'wp_ajax_hmcabw_get_image', $hmcabw_admin, 'hmcabw_get_image' );
		$this->hmcabw_loader->add_action( 'wp_ajax_nopriv_hmcabw_get_image', $hmcabw_admin, 'hmcabw_get_image' );
	}
	
	private function hmcabw_trigger_front_hooks() {
		$hmcabw_front = new HMCABW_Front( $this->hmcabw_version() );
		$this->hmcabw_loader->add_action( 'wp_enqueue_scripts', $hmcabw_front, HMCABW_PREFIX . 'enqueue_assets' );
		$this->hmcabw_loader->add_filter( 'the_content', $hmcabw_front, 'hmcabw_author_info_display' );
	}
	
	public function hmcabw_run() {
		$this->hmcabw_loader->hmcabw_run();
	}
	
	public function hmcabw_version() {
		return $this->hmcabw_version;
	}

	function hmcabw_unregister_settings(){
		global $wpdb;
	
		$tbl = $wpdb->prefix . 'options';
		$search_string = HMCABW_PREFIX . '%';
		
		$sql = $wpdb->prepare( "SELECT option_name FROM $tbl WHERE option_name LIKE %s", $search_string );
		$options = $wpdb->get_results( $sql , OBJECT );
	
		if(is_array($options) && count($options)) {
			foreach( $options as $option ) {
				delete_option( $option->option_name );
				delete_site_option( $option->option_name );
			}
		}
	}
}
?>