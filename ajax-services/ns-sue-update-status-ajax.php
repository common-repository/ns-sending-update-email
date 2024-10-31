<?php
/*Service for ajax call to add a custom category*/
add_action( 'wp_ajax_nopriv_ns_sue_update_status', 'ns_sue_update_status' );
add_action( 'wp_ajax_ns_sue_update_status', 'ns_sue_update_status' );
function ns_sue_update_status(){
	if(isset($_POST['ns-sue-status']) && isset($_POST['ns-sue-id-prodotto'])){
        //faccio l'update del post meta: se ON allora ciclo
        $id_prodotto = sanitize_text_field( $_POST['ns-sue-id-prodotto'] );
        $sue_status = sanitize_text_field( $_POST['ns-sue-status'] );

        if(($sue_status == 'on') || ($sue_status == 'off')){
            update_post_meta( $id_prodotto, 'ns_sue_status', $sue_status );
            echo $sue_status;
        }
    }
	
	die();
}

?>