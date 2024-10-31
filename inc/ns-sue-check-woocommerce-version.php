<?php
/*Check if woocommerce is active and return true if woocommerce version is major 3.0*/
function ns_sue_woocommerce_version_check( $version = '3.0' ) {
    if ( class_exists( 'WooCommerce' ) ) {
      global $woocommerce;
      if( version_compare( $woocommerce->version, $version, ">=" ) ) {
        return true;
      }
    }
    return false;
  }


/*Display notice in wp admin top section*/
function ns_sue_error_wc_version_notice() {
    if(get_transient( 'ns-sue-admin-notice-example' )){
    ?>
        <div class="error notice">
            <p>NS Send Update Email plugin only support <b>Woocommerce 3.0</b> or later versions. Keep your woocommerce version up to date!</p>
        </div>
    <?php
    }
    //delete_transient( 'fx-admin-notice-example' );
}
add_action( 'admin_notices', 'ns_sue_error_wc_version_notice' );
?>