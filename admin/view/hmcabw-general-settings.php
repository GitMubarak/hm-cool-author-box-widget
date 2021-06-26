<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div id="wph-wrap-all" class="wrap hmcabw-settings-page">

    <div class="settings-banner">
        <h2><?php _e('Information Settings', HMCABW_TXT_DOMAIN); ?>::</h2>
    </div>

    <?php 
        if ( $hmcabwShowGeneralMessage ) {
            $this->hmcab_display_notification('success', 'Your information updated successfully.');
        }
    ?>

    <div class="hmcab-wrap">

        <div class="hmcab_personal_wrap hmcab_personal_help" style="width: 845px; float: left; margin-top: 5px;">
    
            <form name="hmcabw_general_settings_form" role="form" class="form-horizontal" method="post" action="" id="hmcabw-general-settings-form">

                <table class="form-table">
                    <tr class="hmcabw_author_name">
                        <th scope="row">
                            <label for="hmcabw_author_name"><?php _e('Name', HMCABW_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <input type="text" name="hmcabw_author_name" placeholder="name" class="regular-text" value="<?php esc_attr_e( $hmcabwGeneralSettings['hmcabw_author_name'] ); ?>">
                        </td>
                    </tr>
                    <tr class="hmcabw_author_title">
                        <th scope="row">
                            <label for="hmcabw_author_title"><?php _e('Title', HMCABW_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <input type="text" name="hmcabw_author_title" placeholder="title" class="regular-text" value="<?php esc_attr_e( $hmcabwGeneralSettings['hmcabw_author_title'] ); ?>">
                        </td>
                    </tr>
                    <tr class="hmcabw_author_email">
                        <th scope="row">
                            <label for="hmcabw_author_email"><?php _e('Email', HMCABW_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <input name="hmcabw_author_email" type="text" placeholder="email" class="regular-text" value="<?php esc_attr_e( $hmcabwGeneralSettings['hmcabw_author_email'] ); ?>">
                        </td>
                    </tr>
                    <tr class="hmcabw_author_website">
                        <th scope="row">
                            <label for="hmcabw_author_website"><?php _e('Website', HMCABW_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <input name="hmcabw_author_website" type="text" placeholder="website" class="regular-text" value="<?php esc_attr_e( $hmcabwGeneralSettings['hmcabw_author_website'] ); ?>">
                        </td>
                    </tr>
                    <tr class="hmcabw_biographical_info">
                        <th scope="row">
                            <label for="hmcabw_biographical_info"><?php _e('Biographical Info', HMCABW_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <div style="width:700px;">
                            <?php
                            $hmcabwBiographicalInfoSettings = array( 'media_buttons' => false, 'textarea_rows' => '10' );
                            $hmcabwBiographicalInfoContent  = wp_kses_post( $hmcabwGeneralSettings['hmcabw_biographical_info'] );
                            $hmcabwBiographicalInfoId       = 'hmcabw_biographical_info';
                            wp_editor( $hmcabwBiographicalInfoContent, $hmcabwBiographicalInfoId, $hmcabwBiographicalInfoSettings );
                            ?>
                            </div>
                        </td>
                    </tr>
                    <tr class="hmcabw_biographical_info_font_size">
                        <th scope="row">
                            <label for="hmcabw_biographical_info_font_size"><?php esc_html_e('Biographical Info Font Size', HMCABW_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <input type="number" name="hmcabw_biographical_info_font_size" class="small-text" min="12" max="28" step="1" value="<?php esc_attr_e( $hmcabwGeneralSettings['hmcabw_biographical_info_font_size'] ); ?>">
                        </td>
                    </tr>
                    <tr class="hmcabw_author_image_selection">
                        <th scope="row">
                                <label for="hmcabw_author_image_selection"><?php _e('Author Image', HMCABW_TXT_DOMAIN); ?>?</label>
                        </th>
                        <td>
                            <input type="radio" name="hmcabw_author_image_selection" value="gravatar" <?php if( $hmcabwGeneralSettings['hmcabw_author_image_selection'] != "upload_image") { echo 'checked'; } ?>>
                            <label for="hmcabw_author_image_selection"><span></span><?php _e( 'Gravatar', HMCABW_TXT_DOMAIN ); ?></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="hmcabw_author_image_selection" value="upload_image" <?php if( $hmcabwGeneralSettings['hmcabw_author_image_selection'] == "upload_image") { echo 'checked'; } ?>>
                            <label for="hmcabw_author_image_selection"><span></span><?php _e('Upload Image', HMCABW_TXT_DOMAIN); ?></label>
                        </td>
                    </tr>
                    <tr class="hmcabw_photograph" id="hmcabw_photograph_th">
                        <th scope="row">
                            <label for="hmcabw_photograph"><?php _e('Upload Image', HMCABW_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <input type="hidden" name="hmcabw_photograph" id="hmcabw_photograph" value="<?php esc_attr_e( $hmcabwGeneralSettings['hmcabw_photograph'] ); ?>" class="regular-text" />
                            <input type='button' class="button-primary" value="<?php _e( 'Select Photograph', HMCABW_TXT_DOMAIN ); ?>" id="hmcabw-media-manager"/>
                            <br><br>
                            <?php
                            $hmcabwImageId = $hmcabwGeneralSettings['hmcabw_photograph'];
                            $hmcabwImage = '';
                            if ( intval( $hmcabwImageId ) > 0 ) {
                                    $hmcabwImage = wp_get_attachment_image( $hmcabwImageId, 'thumbnail', false, array( 'id' => 'hmcabw-preview-image' ) );
                            }
                            ?>
                            <div id="hmcabw-preview-image"><?php echo $hmcabwImage; ?></div>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <button id="updateGeneralSettings" name="updateGeneralSettings" class="button button-primary"><?php _e('Save Settings', HMCABW_TXT_DOMAIN); ?></button>
                </p>
        
            </form>

        </div>

        <?php $this->load_admin_sidebar(); ?>

    </div>
</div>