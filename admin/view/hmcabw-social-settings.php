<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div id="wph-wrap-all" class="wrap hmcabw-settings-page">

    <div class="settings-banner">
        <h2><?php _e('Social Settings', HMCABW_TXT_DOMAIN); ?>::</h2>
    </div>
    
    <?php 
        if ( $hmcabwShowSocialMessage ) {
            $this->hmcab_display_notification('success', 'Your information updated successfully.');
        }
    ?>

    <div class="hmcab-wrap">

        <div class="hmcab_personal_wrap hmcab_personal_help" style="width: 845px; float: left; margin-top: 5px;">
            <form name="wpre-table" role="form" class="form-horizontal" method="post" action="">
                <div style="width:100%; height:550px; overflow-y:scroll; overflow-x:hidden;">
                    <table class="form-table" id="table-admin-social-id">
                        <?php
                        foreach ( $hmcabSocialNetworks as $hmcabwSocialMedia ) {

                            $hmcabwSocialMediaUpper = ucfirst( $hmcabwSocialMedia );
                            $hmcabwEnabled          = ( isset( $hmcabwSocialSettings['hmcabw_'.$hmcabwSocialMedia.'_enable'] ) && $hmcabwSocialSettings['hmcabw_'.$hmcabwSocialMedia.'_enable'] == 1 ) ? 1 : 0;
                            $hmcabwLink             = isset( $hmcabwSocialSettings['hmcabw_'.$hmcabwSocialMedia.'_link'] ) ? $hmcabwSocialSettings['hmcabw_'.$hmcabwSocialMedia.'_link'] : '';
                            ?>
                            <tr>
                                <th>
                                    <label for="hmcabw_<?php esc_attr_e( $hmcabwSocialMedia ); ?>_enable"><?php printf( esc_html('Show %s?', $hmcabwSocialMediaUpper, HMCABW_TXT_DOMAIN), $hmcabwSocialMediaUpper ); ?></label>
                                </th>
                                <td>
                                    <input type="checkbox" name="hmcabw_<?php esc_attr_e( $hmcabwSocialMedia ); ?>_enable" id="hmcabw_<?php esc_attr_e( $hmcabwSocialMedia ); ?>_enable" value="1" <?php echo $hmcabwEnabled ? 'checked' : ''; ?>>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="hmcabw_<?php esc_attr_e( $hmcabwSocialMedia ); ?>_link"><?php printf(esc_html('%s Url:', $hmcabwSocialMediaUpper, HMCABW_TXT_DOMAIN), $hmcabwSocialMediaUpper ); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="hmcabw_<?php esc_attr_e( $hmcabwSocialMedia ); ?>_link" class="regular-text" value="<?php echo esc_url( $hmcabwLink ); ?>">
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <p class="submit">
                    <button id="updateSocialSettings" name="updateSocialSettings" class="button button-primary"><?php _e('Save Settings', HMCABW_TXT_DOMAIN); ?></button>
                </p>
            </form>
        </div>
        
        <?php $this->load_admin_sidebar(); ?>

    </div>
</div>