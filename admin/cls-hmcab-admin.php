<?php
/**
*	Admin Panel Parent Class
*/
class Hmcabw_Admin {
	
	private $hmcabw_version;
	private $hmcabw_option_group;
	private $hmcabw_assets_prefix;

	public function __construct( $version ) {
		$this->hmcabw_version = $version;
		$this->hmcabw_assets_prefix = substr(HMCABW_PREFIX, 0, -1) . '-';
	}
	
	/**
	*	Loading the admin menu
	*/
	public function hmcabw_admin_menu() {
		
		add_menu_page(	esc_html__('HM Author Box', 'hm-cool-author-box-widget'),
						esc_html__('HM Author Box', 'hm-cool-author-box-widget'),
						'',
						'hm-cool-author-box',
						'',
						'dashicons-admin-users',
						95
					);
		
		add_submenu_page( 	'hm-cool-author-box',
							esc_html__('Information Settings', 'hm-cool-author-box-widget'),
							esc_html__('Information Settings', 'hm-cool-author-box-widget'),
							'manage_options',
							'hmcabw-general-settings',
							array( $this, 'hmcabw_general_settings' )
						);

		add_submenu_page( 	'hm-cool-author-box',
							esc_html__('Social Settings', 'hm-cool-author-box-widget'),
							esc_html__('Social Settings', 'hm-cool-author-box-widget'),
							'manage_options',
							'hmcabw-social-settings',
							array( $this, 'hmcabw_social_settings' )
						);

		add_submenu_page( 	'hm-cool-author-box',
							esc_html__('Template Settings', 'hm-cool-author-box-widget'),
							esc_html__('Template Settings', 'hm-cool-author-box-widget'),
							'manage_options',
							'hmcabw-template-settings',
							array( $this, 'hmcabw_template_settings' )
						);
	}
	
	/**
	*	Loading admin panel styles
	*/
	public function hmcabw_enqueue_assets() {
		
		wp_enqueue_style(
							$this->hmcabw_assets_prefix . 'admin-style',
							HMCABW_ASSETS . 'css/' . $this->hmcabw_assets_prefix . 'admin-style.css',
							array(),
							$this->hmcabw_version,
							FALSE
						);
		
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');

		wp_enqueue_media();

		if ( !wp_script_is( 'jquery' ) ) {
			wp_enqueue_script('jquery');
		}
		wp_enqueue_script(
							$this->hmcabw_assets_prefix . 'admin-script',
							HMCABW_ASSETS . 'js/' . $this->hmcabw_assets_prefix . 'admin-script.js',
							array('jquery'),
							$this->hmcabw_version,
							TRUE
						);

	}
	
	/**
	*	Loading admin panel view/forms
	*/
	function hmcabw_general_settings(){
		require_once HMCABW_PATH . 'admin/view/' . $this->hmcabw_assets_prefix . 'general-settings.php';
	}

	function hmcabw_social_settings(){
		require_once HMCABW_PATH . 'admin/view/' . $this->hmcabw_assets_prefix . 'social-settings.php';
	}
	
	public function hmcabw_template_settings() {
		require_once HMCABW_PATH . 'admin/view/' . $this->hmcabw_assets_prefix . 'template-settings.php';
	}


	function hmcabw_get_image() {
		if(isset($_GET['id']) ){
			$image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'thumbnail', false, array( 'id' => 'hmcabw-preview-image' ) );
			$data = array(
							'image' => $image,
						);
			wp_send_json_success( $data );
		} else {
			wp_send_json_error();
		}
	}

	protected function get_social_media(){
		$socilaMedia = array(
								'facebook',
								'instagram',
								'twitter',
								'tumblr',
								'linkedin',
								'pinterest',
								'youtube',
								'quora',
								'github',
								'flickr',
								'stackoverflow',
								'reddit'
							);
		return $socilaMedia;
	}
	
	function hmcabw_display_notification($type, $msg){ ?>
		<div class="hmcabw-alert <?php printf('%s', $type); ?>">
			<span class="hmcabw-closebtn">&times;</span> 
			<strong><?php esc_html_e(ucfirst($type), 'hm-cool-author-box-widget'); ?>!</strong> <?php esc_html_e($msg, 'hm-cool-author-box-widget'); ?>
		</div>
	<?php }
}
?>