<?php
/*
Plugin Name: NS Sending Update Email
Description: This plugin is used to send a notification email about a updated product to all customers that have already completed an order including that product
Version: 1.2.4
Author: NsThemes
Author URI: https://www.nsthemes.com/
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/** 
 * @author        PluginEye
 * @copyright     Copyright (c) 2019, PluginEye.
 * @version         1.0.0
 * @license       https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 * PLUGINEYE SDK
*/

require_once('plugineye/plugineye-class.php');
$plugineye = array(
    'main_directory_name'       => 'ns-sending-update-email',
    'main_file_name'            => 'ns-plugin-home.php',
    'redirect_after_confirm'    => 'admin.php?page=ns-sending-update-email%2Fns-admin-options%2Fns_admin_option_dashboard.php',
    'plugin_id'                 => '209',
    'plugin_token'              => 'NWNmZTVjMmMzN2M5M2M4MTJmYTU1M2FmZTY5OTAzMzU1MWExOGJjZGI3NjA0NmZlZDA5NGFkYjhjNzcyNzhlNTA5OTE1YTQyZTUyODI=',
    'plugin_dir_url'            => plugin_dir_url(__FILE__),
    'plugin_dir_path'           => plugin_dir_path(__FILE__)
);

$plugineyeobj209 = new pluginEye($plugineye);
$plugineyeobj209->pluginEyeStart();      
        

if ( ! defined( 'SUE_NS_PLUGIN_DIR' ) )
    define( 'SUE_NS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'SUE_NS_PLUGIN_DIR_URL' ) )
    define( 'SUE_NS_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );


/*========================================================*/
/*						   REQUIRE FILES				  */
/*========================================================*/
require_once( SUE_NS_PLUGIN_DIR.'/ns-sending-update-email-options.php');

require_once( plugin_dir_path( __FILE__ ).'ns-admin-options/ns-admin-options-setup.php');

require_once( plugin_dir_path( __FILE__ ).'inc/ns-sue-retrieve-all-completed-orders.php');
require_once( plugin_dir_path( __FILE__ ).'inc/ns-sue-send-email-to-all-completed-orders-users.php');
require_once( plugin_dir_path( __FILE__ ).'inc/ns-sue-check-woocommerce-version.php');

/*=========================================================*/ 
/*=========================================================*/


/*========================================================*/
/*						   AJAX				 			  */
/*========================================================*/

//require_once( plugin_dir_path( __FILE__ ).'/ajax-services/ns-sue-update-status-ajax.php');

/*=========================================================*/
/*=========================================================*/


/**
 * Adds a meta box to the post editing screen
 */
function ns_sue_custom_meta() {
    add_meta_box( 'ns_sue_meta', __( 'Activate notification email', 'ns-sue-meta-textdomain' ), 'ns_sue_meta_callback', 'product' );
}
add_action( 'add_meta_boxes', 'ns_sue_custom_meta' );


function ns_sue_meta_callback($post){
    $edit_status = get_post_meta( $post->ID, 'ns_sue_status', true );
    $checked = '';
    if($edit_status == 'on'){
        $checked = 'checked';
    }
    echo '
        <div class="ns-sue-container">
            <div class="ns-sue-div-container">  
                <input type="checkbox"  id="ns-sue-activate-on-product"  name="ns-sue-activate-on-product">
                <label for="ns-sue-activate-on-product"></label> 
            </div>
            <p>Customers for this order: '. ns_get_all_completed_orders_email($post->ID, true).'</p>
            <small>Email will be sent to all customer that have purchased this product. The notification email will be sent on clicking on save/update button.</small>
            <input id="ns-sue-prod-id" name="ns-sue-prod-id" type="hidden" value="'.$post->ID.'">

        </div>';

}

/*RUN WHEN A PRODUCT IS SAVED. THIS FUNCTION CALLS ONE CUSTOM SENDING MAIL FUNCTION*/
add_action('save_post','ns_save_post_action');
function ns_save_post_action($post_id){
    /*Saving Checkbox Slider status*/
    if(isset($_POST['ns-sue-activate-on-product']) && isset($_POST['ns-sue-prod-id'])){
        
        //faccio l'update del post meta: se ON allora ciclo
        $id_prodotto =  $_POST['ns-sue-prod-id'] ;
        $sue_status =  $_POST['ns-sue-activate-on-product'] ;

       
        update_post_meta( $id_prodotto, 'ns_sue_status', $sue_status );

        $post = get_post( $post_id );
        if ($post->post_type == 'product'){
    
            $ns_sue_value = get_post_meta( $post_id, 'ns_sue_status', true );
            if(($ns_sue_value) && ($ns_sue_value == 'on')){
                $email_arr = ns_get_all_completed_orders_email($post->ID);
                
                //No completed order with this product, return.
                if(empty ($email_arr)){
                    return;
                }

                ns_sue_send_email_to_array($email_arr);
    
            }
            return;
        }
        
    }
    

}

/*HTML FORMATTED EMAIL*/
function ns_sue_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','ns_sue_set_content_type' );

/*ON PLUGIN ACTIVATION CHECK WOOCOMMERCE VERSION*/
function ns_sue_plugin_activate() {
    if(!ns_sue_woocommerce_version_check()){
        set_transient( 'ns-sue-admin-notice-example', true, 5  );
    }
}
register_activation_hook( __FILE__, 'ns_sue_plugin_activate' );


/* *** add link premium *** */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'nssendingupdateemail_add_action_links' );

function nssendingupdateemail_add_action_links ( $links ) {	
 $mylinks = array('<a id="nssumlinkpremium" href="https://www.nsthemes.com/?ref-ns=2&campaign=SMTU-linkpremium" target="_blank">'.__( 'Join NS Club', 'ns-sending-update-email' ).'</a>');
return array_merge( $links, $mylinks );
}
?>