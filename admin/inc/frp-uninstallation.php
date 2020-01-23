<?php
/**
 * Disabled Direct Access
 */
defined( 'ABSPATH') or die ( 'No Permision in this Pages!');

if(!function_exists('frp_uninstallation')){
    function frp_uninstallation() {
        /*
        *   On plugin uninstall, delete this options in the database.
        */
        if ( is_multisite() ) {
            //Basic settings
            delete_network_option(null, 'frp_images');
            delete_network_option(null, 'frp_audio');
            delete_network_option(null, 'frp_video');
            delete_network_option(null, 'frp_iframe');

		    }
        /**
        * Delete database entries
        *
        * @since		1.0
        */
        //Basic settings
        delete_option('frp_images');
        delete_option('frp_audio');
        delete_option('frp_video');
        delete_option('frp_iframe');

    }
}
