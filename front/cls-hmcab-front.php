<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include_once HMCABW_PATH . 'common/hmcab-general-settigns.php';
include_once HMCABW_PATH . 'common/hmcab-social-settigns.php';

/**
*	Front Master CLass
*/
class HMCABW_Front {

	use Hmcab_General_Settings, Hmcab_Social_Settings;
	
	private $hmcabw_version;

	public function __construct( $version ) {

		$this->hmcabw_version = $version;
		$this->hmcabw_assets_prefix = substr(HMCABW_PREFIX, 0, -1) . '-';
	}
	
	public function hmcabw_enqueue_assets() {

		wp_enqueue_style(
							$this->hmcabw_assets_prefix . 'front-style',
							HMCABW_ASSETS . 'css/' . $this->hmcabw_assets_prefix . 'front-style.css',
							array(),
							$this->hmcabw_version,
							FALSE
		);

		wp_enqueue_style(
							$this->hmcabw_assets_prefix . 'widget-style',
							HMCABW_ASSETS . 'css/' . $this->hmcabw_assets_prefix . 'widget-style.css',
							array(),
							$this->hmcabw_version,
							FALSE
		);

		if ( !wp_script_is( 'jquery' ) ) {
			wp_enqueue_script('jquery');
		}

		wp_enqueue_script(
							$this->hmcabw_assets_prefix . 'front-script',
							HMCABW_ASSETS . 'js/' . $this->hmcabw_assets_prefix . 'front-script.js',
							array('jquery'),
							$this->hmcabw_version,
							TRUE
						);
	}
	
	public function hmcabw_front_view_initialize() {
		
		add_filter( "the_content", array( $this, 'hmcabw_front_view_load' ) );
	}
	
	public function hmcabw_front_view_load() {

		if ( is_single() || is_page() || is_author() || is_archive() ) {
			echo get_the_content();
			echo 'Hello';
		}
		else
			echo 'Hi';
	}
	
	function hmcabw_load_shortcode() {

		add_shortcode( 'hm_cool_author_box', array( $this, 'hmcabw_load_shortcode_view' ) );
	}
	
	function hmcabw_load_shortcode_view() {

		$output = '';
		ob_start();
		include HMCABW_PATH . 'front/view/hmcabw-front-view.php';
		$output .= ob_get_clean();
		return $output;
	}

	function hmcabw_author_info_display( $content ){

		global $post;

		$hmcabwCurrentUser = wp_get_current_user();

		// General Settings Data
		$hmcabwGeneralSettings	= $this->get_general_settings();
		$hmcabwPhotograph 		= isset( $hmcabwGeneralSettings['hmcabw_photograph'] ) ? $hmcabwGeneralSettings['hmcabw_photograph'] : '';
		$hmcabwAuthorName  		= isset( $hmcabwGeneralSettings['hmcabw_author_name'] ) ? $hmcabwGeneralSettings['hmcabw_author_name'] :  $hmcabwCurrentUser->display_name;
		$hmcabwAuthorTitle 		= isset( $hmcabwGeneralSettings['hmcabw_author_title'] ) ? $hmcabwGeneralSettings['hmcabw_author_title'] : '';
		$hmcabwAuthorEmail 		= isset( $hmcabwGeneralSettings['hmcabw_author_email'] ) ? $hmcabwGeneralSettings['hmcabw_author_email'] : $hmcabwCurrentUser->user_email;
		$hmcabwAuthorWebsite 	= isset( $hmcabwGeneralSettings['hmcabw_author_website'] ) ? $hmcabwGeneralSettings['hmcabw_author_website'] : $hmcabwCurrentUser->user_url;
		$hmcabwBiographicalInfo = isset( $hmcabwGeneralSettings['hmcabw_biographical_info'] ) ? $hmcabwGeneralSettings['hmcabw_biographical_info'] : $hmcabwCurrentUser->description;
		$hmcabwBIFontSize 		= isset( $hmcabwGeneralSettings['hmcabw_biographical_info_font_size'] ) ? $hmcabwGeneralSettings['hmcabw_biographical_info_font_size'] : '12';
		$hmcabwAuthorImage 		= isset( $hmcabwGeneralSettings['hmcabw_author_image_selection'] ) ? $hmcabwGeneralSettings['hmcabw_author_image_selection'] : 'gravatar';

		// Social Settings Data
		$hmcabwSocialSettings	= $this->get_social_settings();

		// Get all social networks
		$hmcabwSocials = $this->get_social_network();

		// Template Settings Data
		$hmcabwTempSettings 	= stripslashes_deep( unserialize( get_option('hmcabw_temp_settings') ) );
		$hmcabwTemplate 		= isset( $hmcabwTempSettings['hmcabw_select_template'] ) ? $hmcabwTempSettings['hmcabw_select_template'] : "temp_0";
		$hmcabwDisplayPosition 	= (filter_var($hmcabwTempSettings['hmcabw_display_selection'], FILTER_SANITIZE_STRING)) ? $hmcabwTempSettings['hmcabw_display_selection'] : 'bottom';
		$hmcabwDisplayTitle 	= (filter_var($hmcabwTempSettings['hmcabw_display_title'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_title'] : '';
		$hmcabwDisplayEmail 	= (filter_var($hmcabwTempSettings['hmcabw_display_email'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_email'] : '';
		$hmcabwDisplayWeb 		= (filter_var($hmcabwTempSettings['hmcabw_display_web'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_web'] : '';
		$hmcabwIconShape 		= (filter_var($hmcabwTempSettings['hmcabw_icon_shape'], FILTER_SANITIZE_STRING)) ? $hmcabwTempSettings['hmcabw_icon_shape'] : 'square';
		$hmcabwPhotoWidth 		= (filter_var($hmcabwTempSettings['hmcabw_photo_width'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_photo_width'] : '100';
		$hmcabwSisplayPostPage 	= (filter_var($hmcabwTempSettings['hmcabw_display_in_post_page'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_in_post_page'] : '';
		
		$output = '';

		if ( $hmcabwSisplayPostPage ) {

			ob_start();

			include_once HMCABW_PATH . 'front/view/hmcabw-front-view.php';
			
			$output .= ob_get_clean();
		
			if ( is_single() ) {

				if ( $hmcabwDisplayPosition === "top" ) {

					return $output . $content;
				} else {

					return $content . $output;
				}
			}
		}

		return $content;
	}
}
?>