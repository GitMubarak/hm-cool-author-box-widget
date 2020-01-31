<?php
/**
*	Front CLass
*/
class HMCABW_Front {
	
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

	function hmcabw_author_info_display($content){
		global $post;
		if(is_array(stripslashes_deep(unserialize(get_option('hmcabw_temp_settings'))))){
			$hmcabwTempSettings = stripslashes_deep(unserialize(get_option('hmcabw_temp_settings')));
			$hmcabwTemplate = !empty($hmcabwTempSettings['hmcabw_select_template']) ? $hmcabwTempSettings['hmcabw_select_template'] : "temp_1";
			$hmcabwDisplayPosition = (filter_var($hmcabwTempSettings['hmcabw_display_selection'], FILTER_SANITIZE_STRING)) ? $hmcabwTempSettings['hmcabw_display_selection'] : 'bottom';
			$hmcabwDisplayTitle = (filter_var($hmcabwTempSettings['hmcabw_display_title'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_title'] : '';
			$hmcabwDisplayEmail = (filter_var($hmcabwTempSettings['hmcabw_display_email'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_email'] : '';
			$hmcabwDisplayWeb = (filter_var($hmcabwTempSettings['hmcabw_display_web'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_web'] : '';
			$hmcabwIconShape = (filter_var($hmcabwTempSettings['hmcabw_icon_shape'], FILTER_SANITIZE_STRING)) ? $hmcabwTempSettings['hmcabw_icon_shape'] : 'square';
			$hmcabwSisplayPostPage = (filter_var($hmcabwTempSettings['hmcabw_display_in_post_page'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_in_post_page'] : '';
			$hmcabwPhotoWidth = (filter_var($hmcabwTempSettings['hmcabw_photo_width'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_photo_width'] : '50';
		} else{
			$hmcabwTempSettings = array();
			$hmcabwTemplate = "temp_1";
			$hmcabwDisplayPosition = "bottom";		
			$hmcabwDisplayTitle = "";
			$hmcabwDisplayEmail = "";
			$hmcabwDisplayWeb = "";
			$hmcabwIconShape = "square";
			$hmcabwSisplayPostPage = "";
			$hmcabwPhotoWidth = '50';
		}
		
		$output = '';
		if(1 == $hmcabwSisplayPostPage){
			ob_start();
			include HMCABW_PATH . 'front/view/hmcabw-front-view.php';
			$output .= ob_get_clean();
		
			if( is_single() || is_page() ){
				if( $hmcabwDisplayPosition == "top" ){
					//include HMCABW_PATH . 'front/view/hmcabw-front-view.php';
					return $content . $output;
				}else{
					//echo $content;
					//include HMCABW_PATH . 'front/view/hmcabw-front-view.php';
					return $content . $output;
				}
			}
		}
		return $content;
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
}
?>