<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* Trait For General Settings
*/
trait Hmcab_General_Settings {

    protected function set_general_settings( $post ) {

        $hmcabwGeneralSettingsInfo = array(
            'hmcabw_author_name'                    => isset( $post['hmcabw_author_name'] ) ? sanitize_text_field( $post['hmcabw_author_name'] ) : '',
            'hmcabw_author_title'                   => isset( $post['hmcabw_author_title'] ) ? sanitize_text_field( $post['hmcabw_author_title'] ) : '',
            'hmcabw_author_email'                   => isset( $post['hmcabw_author_email'] ) ? sanitize_text_field( $post['hmcabw_author_email'] ) : '',
            'hmcabw_author_website'                 => isset( $post['hmcabw_author_website'] ) ? sanitize_text_field( $post['hmcabw_author_website'] ) : '',
            'hmcabw_biographical_info'              => isset( $post['hmcabw_biographical_info'] ) ? wp_kses_post( $post['hmcabw_biographical_info'] ) : '',
            'hmcabw_biographical_info_font_size'    => isset( $post['hmcabw_biographical_info_font_size'] ) ? sanitize_file_name( $post['hmcabw_biographical_info_font_size'] ) : '12',
            'hmcabw_photograph'                     => isset( $post['hmcabw_photograph'] ) ? sanitize_file_name( $post['hmcabw_photograph'] ) : '',
            'hmcabw_author_image_selection'         => isset( $post['hmcabw_author_image_selection'] ) ? sanitize_text_field( $post['hmcabw_author_image_selection'] ) : '',
        );

        return update_option( 'hmcabw_general_settings', serialize( $hmcabwGeneralSettingsInfo ) );
    }

    protected function get_general_settings() {

		return stripslashes_deep( unserialize( get_option('hmcabw_general_settings') ) );
	}
}