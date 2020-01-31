<?php
$hmcabwCurrentUser = wp_get_current_user();
if(is_array(stripslashes_deep(unserialize(get_option('hmcabw_general_settings'))))){
	$hmcabwGeneralSettings = stripslashes_deep(unserialize(get_option('hmcabw_general_settings')));
	$hmcabwPhotograph = !empty($hmcabwGeneralSettings['hmcabw_photograph']) ? $hmcabwGeneralSettings['hmcabw_photograph'] : "";
	$hmcabwAuthorName = !empty($hmcabwGeneralSettings['hmcabw_author_name']) ? $hmcabwGeneralSettings['hmcabw_author_name'] : $hmcabwCurrentUser->display_name;
	$hmcabwAuthorTitle = !empty($hmcabwGeneralSettings['hmcabw_author_title']) ? $hmcabwGeneralSettings['hmcabw_author_title'] : '';
	$hmcabwAuthorEmail = !empty($hmcabwGeneralSettings['hmcabw_author_email']) ? $hmcabwGeneralSettings['hmcabw_author_email'] : $hmcabwCurrentUser->user_email;
	$hmcabwAuthorWebsite = !empty($hmcabwGeneralSettings['hmcabw_author_website']) ? $hmcabwGeneralSettings['hmcabw_author_website'] : $hmcabwCurrentUser->user_url;
	$hmcabwBiographicalInfo = !empty($hmcabwGeneralSettings['hmcabw_biographical_info']) ? wp_kses_post($hmcabwGeneralSettings['hmcabw_biographical_info']) : $hmcabwCurrentUser->description;
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

if(is_array(stripslashes_deep(unserialize(get_option('hmcabw_Social_settings'))))){
	$hmcabwSocialSettings = stripslashes_deep(unserialize(get_option('hmcabw_Social_settings')));
} else{
	$hmcabwSocialSettings = array();
}

$hmcabwSocials = $this->get_social_media();
?>
<div class="hmcabw-main-wrapper <?php printf( '%s', $hmcabwTemplate ); ?>">
	<div class="hmcabw-parent-container">
		<div class="hmcabw-image-container <?php echo esc_attr($hmcabwIconShape); ?>">
			<?php
			$hmcabwImage = array();
			$hmcabwPhotograph2 = "";
			if('upload_image' === $hmcabwAuthorImage){
			//if( intval( $hmcabwPhotograph ) > 0 ) {
				$hmcabwImage = wp_get_attachment_image_src($hmcabwPhotograph, 'fulll', false);
				$hmcabwPhotograph2 = $hmcabwImage[0]; ?>
				<img src="<?php echo esc_attr($hmcabwPhotograph2); ?>" width="<?php echo esc_attr($hmcabwPhotoWidth); ?>px">
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