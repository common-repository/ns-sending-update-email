<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ns_sending_update_email_options()
{
	//add_option('ns-code-add-prod-regular-price', '');
	 
}

register_activation_hook( __FILE__, 'ns_sending_update_email_options');

function ns_sending_update_email_register_options_group(){
	/*Field options*/
	//register_setting('ns_add_prod_options_group', 'ns-code-add-prod-gallery'); 
	
	
}

add_action ('admin_init', 'ns_sending_update_email_register_options_group');

?>