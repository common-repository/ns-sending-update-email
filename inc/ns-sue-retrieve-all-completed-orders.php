<?php
/**/
function ns_get_all_completed_orders_email($sue_prod_id, $is_counter=false){
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        
        'post_type'   => 'shop_order',
        'post_status' => 'wc-completed',
    ) );
    
    $email_array_to_return = array();
    foreach( $customer_orders as $customer_order){
        $order = wc_get_order( $customer_order->ID );
        $items = $order->get_items();
        $email = $order->get_billing_email();
        foreach ( $items as $item ) {
            if($item->get_product_id() == $sue_prod_id){
                
                $product_name = $item->get_name();
                array_push($email_array_to_return, $email);
            }
        }
        
    }
    if($is_counter){
        return count($email_array_to_return);
    }

    return $email_array_to_return;
}
?>