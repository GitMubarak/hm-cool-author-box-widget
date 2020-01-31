<?php
/**
* Adds HM_Cool_Author_Box_Widget widget.
*/
class Hmcabw_Widget extends WP_Widget {
	
	/**
	* Register widget with WordPress.
	*/
	function __construct() {
		parent::__construct(
			'hm-cool-author-box-widget', // Base ID
			__('HM Cool Author Box', 'text_domain'), // Widget name which will display in the widget area
			array( 'description' => __( 'Display HM Cool Author Box', 'text_domain' ), ) // Args
		);
	}
	
	/**
	* Front-end display of widget.
	*
	* @see WP_Widget::widget()
	*
	* @param array $args Widget arguments.
	* @param array $instance Saved values from database.
	*/
	public function widget( $args, $instance )
	{	
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$hmcabwCurrentUser = wp_get_current_user();
		if(is_array(stripslashes_deep(unserialize(get_option('hmcabw_general_settings'))))){
			$hmcabwGeneralSettings = stripslashes_deep(unserialize(get_option('hmcabw_general_settings')));
			$hmcabwPhotograph = !empty($hmcabwGeneralSettings['hmcabw_photograph']) ? $hmcabwGeneralSettings['hmcabw_photograph'] : "";
			$hmcabwAuthorName = !empty($hmcabwGeneralSettings['hmcabw_author_name']) ? $hmcabwGeneralSettings['hmcabw_author_name'] : $hmcabwCurrentUser->display_name;
			$hmcabwAuthorTitle = !empty($hmcabwGeneralSettings['hmcabw_author_title']) ? $hmcabwGeneralSettings['hmcabw_author_title'] : '';
			$hmcabwAuthorEmail = !empty($hmcabwGeneralSettings['hmcabw_author_email']) ? $hmcabwGeneralSettings['hmcabw_author_email'] : $hmcabwCurrentUser->user_email;
			$hmcabwAuthorWebsite = !empty($hmcabwGeneralSettings['hmcabw_author_website']) ? $hmcabwGeneralSettings['hmcabw_author_website'] : $hmcabwCurrentUser->user_url;
			$hmcabwBiographicalInfo = !empty($hmcabwGeneralSettings['hmcabw_biographical_info']) ? $hmcabwGeneralSettings['hmcabw_biographical_info'] : $hmcabwCurrentUser->description;
			$hmcabwBIFontSize = !empty($hmcabwGeneralSettings['hmcabw_biographical_info_font_size']) ? $hmcabwGeneralSettings['hmcabw_biographical_info_font_size'] : '12';
			$hmcabwAuthorImage = !empty($hmcabwGeneralSettings['hmcabw_author_image_selection']) ? $hmcabwGeneralSettings['hmcabw_author_image_selection'] : 'gravatar';
		} else{
			$hmcabwPhotograph = "";
			$hmcabwAuthorName = $hmcabwCurrentUser->display_name;
			$hmcabwBiographicalInfo = $hmcabwCurrentUser->description;
			$hmcabwAuthorEmail = $hmcabwCurrentUser->user_email;
			$hmcabwAuthorWebsite =  $hmcabwCurrentUser->user_url;
			$hmcabwAuthorTitle = "";
			$hmcabwAuthorImage = 'gravatar';
			$hmcabwBIFontSize = '12';
		}
		
		$hmcabwSocialSettings = array();
		if(is_array(stripslashes_deep(unserialize(get_option('hmcabw_Social_settings'))))){
			$hmcabwSocialSettings = stripslashes_deep(unserialize(get_option('hmcabw_Social_settings')));
		} else{
			$hmcabwSocialSettings[] = '';
		}
		
		if(is_array(stripslashes_deep(unserialize(get_option('hmcabw_temp_settings'))))){
			$hmcabwTempSettings = stripslashes_deep(unserialize(get_option('hmcabw_temp_settings')));
			$hmcabwTemplate = !empty($hmcabwTempSettings['hmcabw_select_template']) ? $hmcabwTempSettings['hmcabw_select_template'] : "temp_1";
			$hmcabwDisplayPosition = (filter_var($hmcabwTempSettings['hmcabw_display_selection'], FILTER_SANITIZE_STRING)) ? $hmcabwTempSettings['hmcabw_display_selection'] : 'bottom';
			$hmcabwDisplayTitle = (filter_var($hmcabwTempSettings['hmcabw_display_title'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_title'] : '';
			$hmcabwDisplayEmail = (filter_var($hmcabwTempSettings['hmcabw_display_email'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_email'] : '';
			$hmcabwDisplayWeb = (filter_var($hmcabwTempSettings['hmcabw_display_web'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_display_web'] : '';
			$hmcabwIconShape = (filter_var($hmcabwTempSettings['hmcabw_icon_shape'], FILTER_SANITIZE_STRING)) ? $hmcabwTempSettings['hmcabw_icon_shape'] : 'square';
			$hmcabwPhotoWidth = (filter_var($hmcabwTempSettings['hmcabw_photo_width'], FILTER_SANITIZE_NUMBER_INT)) ? $hmcabwTempSettings['hmcabw_photo_width'] : '50';
		} else{
			$hmcabwTempSettings = array();
			$hmcabwTemplate = "temp_1";
			$hmcabwDisplayPosition = "bottom";		
			$hmcabwDisplayTitle = "";
			$hmcabwDisplayEmail = "";
			$hmcabwDisplayWeb = "";
			$hmcabwIconShape = "square";
			$hmcabwPhotoWidth = '50';
		}
		$hmcabwSocials = $this->get_social_media();
		?>
		<div class="hmcabw-main-wrapper-widget <?php printf( '%s', $hmcabwTemplate ); ?>">
			<div class="hmcabw-parent-container">
				<div class="hmcabw-image-container <?php echo esc_attr($hmcabwIconShape); ?>">
					<?php
					$hmcabwImage = array();
					$hmcabwPhotograph2 = "";
					if('upload_image' === $hmcabwAuthorImage){
					//if( intval( $hmcabwPhotograph ) > 0 ) {
						$hmcabwImage = wp_get_attachment_image_src($hmcabwPhotograph, 'full', false); ?>
						<img src="<?php echo esc_attr($hmcabwImage[0]); ?>" width="<?php echo esc_attr($hmcabwPhotoWidth); ?>px">
					<?php } else{
						//$hmcabwPhotograph2 = HMCABW_ASSETS . 'img/noimage.jpg';
						?>
						<?php echo get_avatar( $hmcabwAuthorEmail, $hmcabwPhotoWidth ); ?>
					<?php } ?>
				</div>
				<div class="hmcabw-info-container" style="font-size:<?php echo esc_attr($hmcabwBIFontSize); ?>px">
					<h3 class="hmcabw-name"><?php echo esc_html($hmcabwAuthorName); ?></h3>
					<?php if($hmcabwDisplayTitle == 1) { ?>
						<p class="hmcabw-title"><?php echo esc_html($hmcabwAuthorTitle); ?></p>
					<?php } ?>
					<?php echo nl2br(wp_kses_post($hmcabwBiographicalInfo)); ?>
				</div>
			</div>
			<div class="hmcabw-email-url-container">
				<?php if($hmcabwDisplayEmail == 1) { ?>
					<div>
						<p class="hmcabw-email"><span class="dashicons dashicons-email-alt"></span><?php echo esc_html($hmcabwAuthorEmail); ?></p>
					</div>
				<?php } ?>
				<?php if($hmcabwDisplayWeb == 1) { ?>
					<div>
						<a href="<?php echo esc_url($hmcabwAuthorWebsite); ?>" class="hmcabw-website"><span class="dashicons dashicons-admin-site"></span><?php echo esc_url($hmcabwAuthorWebsite); ?></a>
					</div>
				<?php } ?>
			</div>
			<div class="hmcabw-social-container">
				<?php 
				foreach($hmcabwSocials as $hmcabwSocial):
					if(isset($hmcabwSocialSettings['hmcabw_'.$hmcabwSocial.'_enable'])):
						if(filter_var($hmcabwSocialSettings['hmcabw_'.$hmcabwSocial.'_enable'], FILTER_SANITIZE_NUMBER_INT) == 1):
						?>
						<div class="<?php echo esc_attr($hmcabwIconShape); ?>">
							<a href="<?php echo esc_url($hmcabwSocialSettings['hmcabw_'.$hmcabwSocial.'_link']); ?>">	
								<img src="<?php echo HMCABW_ASSETS . 'img/icon/' . $hmcabwSocial . '.png'; ?>" height="24" alt="<?php echo esc_attr($hmcabwSocial); ?>" title="<?php echo esc_attr($hmcabwSocial); ?>">
							</a>
						</div>
						<?php
						endif;
					endif;
				endforeach; ?>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
	
	/**
	* Widget Form
	*
	* @see WP_Widget::form()
	*
	* @param array $instance Previously saved values from database.
	*/
	public function form( $instance ) 
	{	
		if ( isset( $instance[ 'title' ] ) ){
			$title = $instance[ 'title' ];
		}else{
			$title = 'Author Box';
		} ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
	
	/*
	* Update Widget Value
	*
	* @see WP_Widget::update()
	*
	* @param array $new_instance Values just sent to be saved.
	* @param array $old_instance Previously saved values from database.
	*
	* @return array Updated safe values to be saved.
	*/
	public function update( $new_instance, $old_instance ) 
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Author Box';
		return $instance;
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