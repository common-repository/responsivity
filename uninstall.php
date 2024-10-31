<?php

if( defined( 'ABSPATH') && defined('WP_UNINSTALL_PLUGIN') ) {

	$responsivity_option_name = "responsivity_public";

	// Remove the plugin's settings
	if ( get_option( $responsivity_option_name ) ) {
		delete_option( $responsivity_option_name );
		delete_site_option( $responsivity_option_name );
	}


}

?>