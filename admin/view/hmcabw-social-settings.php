<?php
$hmcabwSocialMediaArray = $this->get_social_media();
$hmcabwShowSocialMessage = false;
if( isset( $_POST['updateSocialSettings'] ) ){
    $hmcabwSocialSettingsInfo = array();
    foreach( $hmcabwSocialMediaArray as $hmcabwSocial ):
        $hmcabwSocialSettingsInfo['hmcabw_' . $hmcabwSocial . '_enable'] = ( isset( $_POST['hmcabw_' . $hmcabwSocial . '_enable'] ) && filter_var( $_POST['hmcabw_' . $hmcabwSocial . '_enable'], FILTER_SANITIZE_NUMBER_INT ) ) ? $_POST['hmcabw_' . $hmcabwSocial . '_enable'] : '';
        $hmcabwSocialSettingsInfo['hmcabw_' . $hmcabwSocial . '_link'] = (!empty($_POST['hmcabw_' . $hmcabwSocial . '_link']) && (sanitize_text_field($_POST['hmcabw_' . $hmcabwSocial . '_link'])!='')) ? sanitize_text_field($_POST['hmcabw_' . $hmcabwSocial . '_link']) : '';
    endforeach;

    $hmcabwShowSocialMessage = update_option('hmcabw_Social_settings', serialize($hmcabwSocialSettingsInfo));
}
if( is_array( stripslashes_deep( unserialize( get_option('hmcabw_Social_settings') ) ) ) ) {
	$hmcabwSocialSettings = stripslashes_deep( unserialize( get_option('hmcabw_Social_settings') ) );
} else {
	$hmcabwSocialSettings = array();
}
?>
<div id="wph-wrap-all" class="wrap hmcabw-settings-page">
    <div class="settings-banner">
        <h2><?php esc_html_e('Author Box Social Settings', HMCABW_TXT_DOMAIN); ?></h2>
    </div>
    <?php //if($hmcabwShowSocialMessage): $this->hmcabw_display_notification('success', 'Your information updated successfully.'); endif; ?>

    <form name="wpre-table" role="form" class="form-horizontal" method="post" action="">
        <div style="width:100%; height:550px; overflow-y:scroll; overflow-x:hidden;">
        <table class="form-table" id="table-admin-social-id">
        <?php
        foreach( $hmcabwSocialMediaArray as $hmcabwSocialMedia ):
            $hmcabwSocialMediaUpper = ucfirst( $hmcabwSocialMedia );
            $hmcabwEnabled = ( isset( $hmcabwSocialSettings['hmcabw_'.$hmcabwSocialMedia.'_enable'] ) && $hmcabwSocialSettings['hmcabw_'.$hmcabwSocialMedia.'_enable'] == 1 ) ? 1 : 0;
            $hmcabwLink = isset( $hmcabwSocialSettings['hmcabw_'.$hmcabwSocialMedia.'_link'] ) ? $hmcabwSocialSettings['hmcabw_'.$hmcabwSocialMedia.'_link'] : '';
        ?>
        <tr class="hmcabw_<?php echo esc_attr( $hmcabwSocialMedia ); ?>_enable">
            <th scope="row">
                <label for="hmcabw_<?php echo esc_attr( $hmcabwSocialMedia ); ?>_enable"><?php printf(esc_html('Show %s?', $hmcabwSocialMediaUpper, 'hm-cool-author-box-widget'), $hmcabwSocialMediaUpper ); ?></label>
            </th>
            <td>
                <input type="checkbox" name="hmcabw_<?php echo esc_attr( $hmcabwSocialMedia ); ?>_enable" value="1" <?php if( 1 === $hmcabwEnabled ) { echo 'checked'; } ?>>
            </td>
        </tr>
        <tr class="hmcabw_<?php echo esc_attr( $hmcabwSocialMedia ); ?>_link">
            <th scope="row">
                <label for="hmcabw_<?php echo esc_attr( $hmcabwSocialMedia ); ?>_link"><?php printf(esc_html('%s Url:', $hmcabwSocialMediaUpper, 'hm-cool-author-box-widget'), $hmcabwSocialMediaUpper ); ?></label>
            </th>
            <td>
                <input type="text" name="hmcabw_<?php echo esc_attr( $hmcabwSocialMedia ); ?>_link" class="regular-text" value="<?php echo esc_url( $hmcabwLink ); ?>">
            </td>
        </tr>
        <?php endforeach; ?>
        </table>
        </div>
        <p class="submit"><button id="updateSocialSettings" name="updateSocialSettings" class="button button-primary"><?php esc_attr_e('Update Social Settings', 'hm-cool-author-box-widget'); ?></button></p>
    </form>
</div>