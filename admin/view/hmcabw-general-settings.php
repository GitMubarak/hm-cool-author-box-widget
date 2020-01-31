<?php
$hmcabwCurrentUser = wp_get_current_user();

$hmcabwShowGeneralMessage = false;

if(isset($_POST['updateGeneralSettings'])){
     $hmcabwGeneralSettingsInfo = array (
                'hmcabw_author_name'=> (!empty($_POST['hmcabw_author_name']) && (sanitize_text_field($_POST['hmcabw_author_name'])!='')) ? sanitize_text_field($_POST['hmcabw_author_name']) : $hmcabwCurrentUser->display_name,
                'hmcabw_author_title'=> (!empty($_POST['hmcabw_author_title']) && (sanitize_text_field($_POST['hmcabw_author_title'])!='')) ? sanitize_text_field($_POST['hmcabw_author_title']) : '',
                'hmcabw_author_email'=> (!empty($_POST['hmcabw_author_email']) && (sanitize_text_field($_POST['hmcabw_author_email'])!='')) ? sanitize_text_field($_POST['hmcabw_author_email']) : $hmcabwCurrentUser->user_email,
                'hmcabw_author_website'=> (!empty($_POST['hmcabw_author_website']) && (sanitize_text_field($_POST['hmcabw_author_website'])!='')) ? sanitize_text_field($_POST['hmcabw_author_website']) : $hmcabwCurrentUser->user_url,
                'hmcabw_biographical_info' => !empty($_POST['hmcabw_biographical_info']) ? wp_kses_post($_POST['hmcabw_biographical_info']) : $hmcabwCurrentUser->description,
                'hmcabw_biographical_info_font_size' => (sanitize_file_name($_POST['hmcabw_biographical_info_font_size'])!='') ? sanitize_file_name($_POST['hmcabw_biographical_info_font_size']) : '12',
                'hmcabw_photograph' => (sanitize_file_name($_POST['hmcabw_photograph'])!='') ? sanitize_file_name($_POST['hmcabw_photograph']) : '',
                'hmcabw_author_image_selection' => !(empty($_POST['hmcabw_author_image_selection'])) ? sanitize_text_field($_POST['hmcabw_author_image_selection']) : ''
                              );
     $hmcabwShowGeneralMessage = update_option('hmcabw_general_settings', serialize($hmcabwGeneralSettingsInfo));
}
$hmcabwGeneralSettings = stripslashes_deep(unserialize(get_option('hmcabw_general_settings')));
//echo "<pre>";
//print_r($hmcabwGeneralSettings);
?>
<div id="wph-wrap-all" class="wrap hmcabw-settings-page">
    <div class="settings-banner">
        <h2><?php esc_html_e('Author Box General Settings', 'hm-cool-author-box-widget'); ?></h2>
    </div>
    <?php //if($hmcabwShowGeneralMessage): $this->hmcabw_display_notification('success', 'Your information updated successfully.'); endif; ?>

    <form name="hmcabw_general_settings_form" role="form" class="form-horizontal" method="post" action="" id="hmcabw-general-settings-form">
        <table class="form-table">
        <tr class="hmcabw_author_name">
            <th scope="row">
                <label for="hmcabw_author_name"><?php esc_html_e('Name:', 'hm-cool-author-box-widget'); ?></label>
            </th>
            <td>
                <input type="text" name="hmcabw_author_name" placeholder="name" class="regular-text" value="<?php esc_attr_e($hmcabwGeneralSettings['hmcabw_author_name'], 'hm-cool-author-box-widget'); ?>">
                <br>
                <code><i><?php esc_html_e('Keep null to display profile Display Name', 'hm-cool-author-box-widget'); ?></i></code>
            </td>
        </tr>

        <tr class="hmcabw_author_title">
            <th scope="row">
                <label for="hmcabw_author_title"><?php esc_html_e('Title:', 'hm-cool-author-box-widget'); ?></label>
            </th>
            <td>
                <input type="text" name="hmcabw_author_title" placeholder="title" class="regular-text" value="<?php esc_attr_e($hmcabwGeneralSettings['hmcabw_author_title'], 'hm-cool-author-box-widget'); ?>">
            </td>
        </tr>
        <tr class="hmcabw_author_email">
            <th scope="row">
                <label for="hmcabw_author_email"><?php esc_html_e('Email:', 'hm-cool-author-box-widget'); ?></label>
            </th>
            <td>
                <input name="hmcabw_author_email" type="text" placeholder="email" class="regular-text" value="<?php esc_attr_e($hmcabwGeneralSettings['hmcabw_author_email'], 'hm-cool-author-box-widget'); ?>">
                <br>
                <code><i><?php esc_html_e('Keep null to display profile Email', 'hm-cool-author-box-widget'); ?></i></code>
            </td>
        </tr>
        <tr class="hmcabw_author_website">
            <th scope="row">
                <label for="hmcabw_author_website"><?php esc_html_e('Website:', 'hm-cool-author-box-widget'); ?></label>
            </th>
            <td>
                <input name="hmcabw_author_website" type="text" placeholder="website" class="regular-text" value="<?php esc_attr_e($hmcabwGeneralSettings['hmcabw_author_website'], 'hm-cool-author-box-widget'); ?>">
                <br>
                <code><i><?php esc_html_e('Keep null to display profile Website', 'hm-cool-author-box-widget'); ?></i></code>
            </td>
        </tr>
        <tr class="hmcabw_biographical_info">
            <th scope="row">
                <label for="hmcabw_biographical_info"><?php esc_html_e('Biographical Info', 'hm-cool-author-box-widget'); ?></label>
            </th>
            <td>
                <div style="width:700px;">
                <?php
                $hmcabwBiographicalInfoSettings = array( 'media_buttons' => false, 'textarea_rows' => '10' );
                $hmcabwBiographicalInfoContent = wp_kses_post($hmcabwGeneralSettings['hmcabw_biographical_info']);
                $hmcabwBiographicalInfoId = 'hmcabw_biographical_info';
                wp_editor( $hmcabwBiographicalInfoContent, $hmcabwBiographicalInfoId, $hmcabwBiographicalInfoSettings );
                ?>
                </div>
                <br>
                <code><i><?php esc_html_e('Keep null to display profile Biographical Info', 'hm-cool-author-box-widget'); ?></i></code>
            </td>
        </tr>
        <tr class="hmcabw_biographical_info_font_size">
            <th scope="row">
                <label for="hmcabw_biographical_info_font_size"><?php esc_html_e('Biographical Info Font Size:', 'hm-cool-author-box-widget'); ?></label>
            </th>
            <td>
                <input type="number" name="hmcabw_biographical_info_font_size" class="small-text" min="12" max="28" step="1" value="<?php echo esc_attr($hmcabwGeneralSettings['hmcabw_biographical_info_font_size']); ?>">
            </td>
        </tr>
        <tr class="hmcabw_author_image_selection">
            <th scope="row">
                    <label for="hmcabw_author_image_selection"><?php esc_html_e('Author Image?', 'hm-cool-author-box-widget'); ?></label>
            </th>
            <td>
                <input type="radio" name="hmcabw_author_image_selection" value="gravatar" <?php if($hmcabwGeneralSettings['hmcabw_author_image_selection'] != "upload_image") { echo 'checked'; } ?>>
                <label for="hmcabw_author_image_selection"><span></span><?php esc_html_e('Gravatar', 'hm-cool-author-box-widget'); ?></label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="hmcabw_author_image_selection" value="upload_image" <?php if($hmcabwGeneralSettings['hmcabw_author_image_selection'] == "upload_image") { echo 'checked'; } ?>>
                <label for="hmcabw_author_image_selection"><span></span><?php esc_html_e('Upload Image', 'hm-cool-author-box-widget'); ?></label>
            </td>
        </tr>
        <tr class="hmcabw_photograph" id="hmcabw_photograph_th">
            <th scope="row">
                <label for="hmcabw_photograph"><?php esc_html_e('Upload Image:', 'hm-cool-author-box-widget'); ?></label>
            </th>
            <td>
                <input type="hidden" name="hmcabw_photograph" id="hmcabw_photograph" value="<?php echo esc_attr( $hmcabwGeneralSettings['hmcabw_photograph'] ); ?>" class="regular-text" />
                <input type='button' class="button-primary" value="<?php echo esc_attr( 'Select Photograph' ); ?>" id="hmcabw-media-manager"/>
                <br><br>
                <?php
                $hmcabwImageId = $hmcabwGeneralSettings['hmcabw_photograph'];
                $hmcabwImage = "";
                if( intval( $hmcabwImageId ) > 0 ) {
                        $hmcabwImage = wp_get_attachment_image( $hmcabwImageId, 'thumbnail', false, array( 'id' => 'hmcabw-preview-image' ) );
                }
                ?>
                <div id="hmcabw-preview-image"><?php echo $hmcabwImage; ?></div>
            </td>
        </tr>
        </table>
        <p class="submit"><button id="updateGeneralSettings" name="updateGeneralSettings" class="button button-primary"><?php esc_attr_e('Update General Settings', 'hm-cool-author-box-widget'); ?></button></p>
    </form>
</div>