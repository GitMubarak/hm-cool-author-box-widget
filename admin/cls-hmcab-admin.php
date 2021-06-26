<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include_once HMCABW_PATH . 'common/hmcab-general-settigns.php';
include_once HMCABW_PATH . 'common/hmcab-social-settigns.php';
include_once HMCABW_PATH . 'common/hmcab-common.php';

/**
*	Admin Panel Master Class
*/
class Hmcabw_Admin {

	use Hmcab_General_Settings, Hmcab_Social_Settings, Hmcab_Common;
	
	private $hmcabw_version;
	private $hmcabw_option_group;
	private $hmcabw_assets_prefix;

	public function __construct( $version ) {

		$this->hmcabw_version = $version;
		$this->hmcabw_assets_prefix = substr(HMCABW_PREFIX, 0, -1) . '-';
	}
	
	/**
	*	Function for loading admin menu
	*/
	public function hmcabw_admin_menu() {
		
		add_menu_page(	__('HM Author Box', 'hm-cool-author-box-widget'),
						__('HM Author Box', 'hm-cool-author-box-widget'),
						'',
						'hm-cool-author-box',
						'',
						'dashicons-id',
						95
					);
		
		add_submenu_page( 	'hm-cool-author-box',
							__('Information Settings', 'hm-cool-author-box-widget'),
							__('Information Settings', 'hm-cool-author-box-widget'),
							'manage_options',
							'hmcab-general-settings',
							array( $this, 'hmcab_general_settings' )
						);

		add_submenu_page( 	'hm-cool-author-box',
							__('Social Settings', 'hm-cool-author-box-widget'),
							__('Social Settings', 'hm-cool-author-box-widget'),
							'manage_options',
							'hmcab-social-settings',
							array( $this, 'hmcab_social_settings' )
						);

		add_submenu_page( 	'hm-cool-author-box',
							__('Template Settings', 'hm-cool-author-box-widget'),
							__('Template Settings', 'hm-cool-author-box-widget'),
							'manage_options',
							'hmcab-template-settings',
							array( $this, 'hmcab_template_settings' )
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
	function hmcab_general_settings() {

		$hmcabwShowGeneralMessage = false;

		if ( isset( $_POST['updateGeneralSettings'] ) ) {

			$hmcabwShowGeneralMessage = $this->set_general_settings( $_POST );
		}

		$hmcabwGeneralSettings	= $this->get_general_settings();

		include_once HMCABW_PATH . 'admin/view/' . $this->hmcabw_assets_prefix . 'general-settings.php';
	}

	function hmcab_social_settings() {

		$hmcabwShowSocialMessage 	= false;
		$hmcabSocialNetworks		= $this->get_social_network();
		
		if ( isset( $_POST['updateSocialSettings'] ) ) {

			$hmcabwShowSocialMessage = $this->set_social_settings( $hmcabSocialNetworks, $_POST );
		}

		$hmcabwSocialSettings = $this->get_social_settings();

		include_once HMCABW_PATH . 'admin/view/' . $this->hmcabw_assets_prefix . 'social-settings.php';
	}
	
	function hmcab_template_settings() {
		include_once HMCABW_PATH . 'admin/view/' . $this->hmcabw_assets_prefix . 'template-settings.php';
	}


	function hmcabw_get_image() {

		if ( isset( $_GET['id'] ) ) {

			$image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'thumbnail', false, array( 'id' => 'hmcabw-preview-image' ) );
			$data = array(
				'image' => $image,
			);

			wp_send_json_success( $data );
		
		} else {

			wp_send_json_error();
		}
	}
	
	protected function hmcab_display_notification( $type, $msg ) { 
		?>
		<div class="hmcabw-alert <?php printf('%s', $type); ?>">
			<span class="hmcabw-closebtn">&times;</span> 
			<strong><?php esc_html_e( ucfirst( $type ), HMCABW_TXT_DOMAIN ); ?>!</strong> <?php esc_html_e($msg, HMCABW_TXT_DOMAIN); ?>
		</div>
		<?php 
	}
}
?>