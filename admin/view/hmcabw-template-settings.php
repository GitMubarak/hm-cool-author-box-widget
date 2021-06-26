<?php
$showTempMessage = false;

if(isset($_POST['updateTempSettings'])){
    $hmcabwTempSettingsInfo = array(
                                   'hmcabw_select_template' => !empty($_POST['hmcabw_select_template']) ? $_POST['hmcabw_select_template'] : 'temp_1',
                                   'hmcabw_display_selection' => (filter_var($_POST['hmcabw_display_selection'], FILTER_SANITIZE_STRING)) ? $_POST['hmcabw_display_selection'] : '',
                                   'hmcabw_display_title' => (isset($_POST['hmcabw_display_title']) && filter_var($_POST['hmcabw_display_title'], FILTER_SANITIZE_NUMBER_INT)) ? $_POST['hmcabw_display_title'] : '',
                                   'hmcabw_display_email' => (isset($_POST['hmcabw_display_email']) && filter_var($_POST['hmcabw_display_email'], FILTER_SANITIZE_NUMBER_INT)) ? $_POST['hmcabw_display_email'] : '',
                                   'hmcabw_display_web' => (isset($_POST['hmcabw_display_web']) && filter_var($_POST['hmcabw_display_web'], FILTER_SANITIZE_NUMBER_INT)) ? $_POST['hmcabw_display_web'] : '',
                                   'hmcabw_icon_shape' => (filter_var($_POST['hmcabw_icon_shape'], FILTER_SANITIZE_STRING)) ? $_POST['hmcabw_icon_shape'] : 'square',
                                   'hmcabw_display_in_post_page' => (isset($_POST['hmcabw_display_in_post_page']) && filter_var($_POST['hmcabw_display_in_post_page'], FILTER_SANITIZE_NUMBER_INT)) ? $_POST['hmcabw_display_in_post_page'] : '',
                                   'hmcabw_photo_width' => (isset($_POST['hmcabw_photo_width']) && filter_var($_POST['hmcabw_photo_width'], FILTER_SANITIZE_NUMBER_INT)) ? $_POST['hmcabw_photo_width'] : '50',
                                );
     $showTempMessage = update_option('hmcabw_temp_settings', serialize($hmcabwTempSettingsInfo));
}
$hmcabw_temp_settings = array();
if(is_array(stripslashes_deep(unserialize(get_option('hmcabw_temp_settings'))))){
	$hmcabw_temp_settings = stripslashes_deep(unserialize(get_option('hmcabw_temp_settings')));
} else{
	$hmcabw_temp_settings[] = '';
}
?>
<div id="wph-wrap-all" class="wrap hmcabw-settings-page">

    <div class="settings-banner">
        <h2><?php _e('Template Settings', HMCABW_TXT_DOMAIN); ?>::</h2>
    </div>

    <?php 
        if ( $showTempMessage ) {
            $this->hmcab_display_notification('success', 'Your information updated successfully.');
        }
    ?>

    <div class="hmcab-wrap">

        <div class="hmcab_personal_wrap hmcab_personal_help" style="width: 845px; float: left; margin-top: 5px;">

            <form name="wpre-table" role="form" class="form-horizontal" method="post" action="" id="hmcabw-template-settings-form">

                <table class="form-table">
                    <tr class="hmcabw_select_template">
                        <th scope="row">
                            <label for="hmcabw_select_template"><?php _e('Template Color', HMCABW_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <div class="hmcabw-template-selector">
                                <?php 
                                for ( $i = 0; $i < 7; $i++ ) {
                                    ?>
                                    <div class="hmcabw-template-item">
                                        <input type="radio" name="hmcabw_select_template" id="<?php printf('hmcabw_select_template_%d', $i); ?>" value="<?php printf('temp_%d', $i); ?>" <?php if ( $hmcabw_temp_settings['hmcabw_select_template'] === "temp_".$i ) { echo 'checked'; } ?>>
                                        <label for="<?php printf('hmcabw_tmp_style_%d', $i);?>" class="hmcabw-template-<?php esc_attr_e( $i ); ?>"></label>
                                    </div>
                                    <?php
                                    }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr class="hmcabw_display_in_post_page">
                        <th scope="row">
                                <label for="hmcabw_display_in_post_page"><?php esc_html_e('Show In Post/Page?', 'hm-cool-author-box-widget'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="hmcabw_display_in_post_page" value="1" <?php if($hmcabw_temp_settings['hmcabw_display_in_post_page'] == "1") { echo 'checked'; } ?>>
                        </td>
                    </tr>
                    <tr class="hmcabw_display_selection">
                        <th scope="row">
                                <label for="hmcabw_display_selection"><?php esc_html_e('Where to Display?', 'hm-cool-author-box-widget'); ?></label>
                        </th>
                        <td>
                            <input type="radio" name="hmcabw_display_selection" value="top" <?php if($hmcabw_temp_settings['hmcabw_display_selection'] == "top") { echo 'checked'; } ?>>
                            <label for="hmcabw_display_selection"><span></span><?php esc_html_e('Top of Content', 'hm-cool-author-box-widget'); ?></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="hmcabw_display_selection" value="bottom" <?php if($hmcabw_temp_settings['hmcabw_display_selection'] == "bottom") { echo 'checked'; } ?>>
                            <label for="hmcabw_display_selection"><span></span><?php esc_html_e('Bottom of Content', 'hm-cool-author-box-widget'); ?></label>
                        </td>
                    </tr>
                    <tr class="hmcabw_display_title">
                        <th scope="row">
                                <label for="hmcabw_display_title"><?php esc_html_e('Display Title?', 'hm-cool-author-box-widget'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="hmcabw_display_title" value="1" <?php if($hmcabw_temp_settings['hmcabw_display_title'] == "1") { echo 'checked'; } ?>>
                        </td>
                    </tr>
                    <tr class="hmcabw_display_email">
                        <th scope="row">
                                <label for="hmcabw_display_email"><?php esc_html_e('Display Email?', 'hm-cool-author-box-widget'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="hmcabw_display_email" value="1" <?php if($hmcabw_temp_settings['hmcabw_display_email'] == "1") { echo 'checked'; } ?>>
                        </td>
                    </tr>
                    <tr class="hmcabw_display_web">
                        <th scope="row">
                                <label for="hmcabw_display_web"><?php esc_html_e('Display Website?', 'hm-cool-author-box-widget'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="hmcabw_display_web" value="1" <?php if($hmcabw_temp_settings['hmcabw_display_web'] == "1") { echo 'checked'; } ?>>
                        </td>
                    </tr>
                    <tr class="hmcabw_icon_shape">
                        <th scope="row">
                                <label for="hmcabw_icon_shape"><?php esc_html_e('Photo/Icon Shape', 'hm-cool-author-box-widget'); ?></label>
                        </th>
                        <td>
                            <input type="radio" name="hmcabw_icon_shape" value="square" <?php if($hmcabw_temp_settings['hmcabw_icon_shape'] == "square") { echo 'checked'; } ?>>
                            <label for="hmcabw_icon_shape"><span></span><?php esc_html_e('Square', 'hm-cool-author-box-widget'); ?></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="hmcabw_icon_shape" value="rounded" <?php if($hmcabw_temp_settings['hmcabw_icon_shape'] == "rounded") { echo 'checked'; } ?>>
                            <label for="hmcabw_icon_shape"><span></span><?php esc_html_e('Rounded', 'hm-cool-author-box-widget'); ?></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="hmcabw_icon_shape" value="circle" <?php if($hmcabw_temp_settings['hmcabw_icon_shape'] == "circle") { echo 'checked'; } ?>>
                            <label for="hmcabw_icon_shape"><span></span><?php esc_html_e('Circle', 'hm-cool-author-box-widget'); ?></label>
                        </td>
                    </tr>
                    <tr class="hmcabw_display_web">
                        <th scope="row">
                                <label for="hmcabw_photo_width"><?php esc_html_e('Photo/Gravatar Width', 'hm-cool-author-box-widget'); ?></label>
                        </th>
                        <td>
                            <input type="number" name="hmcabw_photo_width" min="50" step="1" value="<?php echo esc_attr($hmcabw_temp_settings['hmcabw_photo_width']); ?>">
                            <code><i><?php esc_html_e('px', 'hm-cool-author-box-widget'); ?></i></code>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <button id="updateTempSettings" name="updateTempSettings" class="button button-primary"><?php _e('Save Settings', HMCABW_TXT_DOMAIN); ?></button>
                </p>

            </form>

        </div>

        <?php $this->load_admin_sidebar(); ?>

    </div>

</div>