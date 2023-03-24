<?php
/*
Plugin Name: MandoCompra a Sistema
Plugin URI: http://useful-media.org
Description: Un plugin personalizado para enviar datos de compra a una URL externa después de que se complete una transacción en WooCommerce.
Version: 1.0
Author: Useful-media
Author URI: http://useful-media.org
License: GPL2
*/

//add_action('woocommerce_order_status_processing', 'mandocompra', 10, 1);
add_action( 'woocommerce_checkout_order_processed', 'mandocompra', 20, 2);

function my_custom_function( $order_id ) {
error_log( 'Mi función personalizada se ejecutó.' );
   $order = wc_get_order( $order_id );
   $items = $order->get_items();
   $product_ids = array();

   foreach ( $items as $item ) {
      $product_ids[] = $item->get_product_id();
   }

   $data = array(
      'order_number' => $order->get_order_number(),
      'customer_name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
      'customer_email' => $order->get_billing_email(),
      'product_ids' => implode( ',', $product_ids ),
      // Agregar cualquier otro dato que desee enviar a la URL externa
   );

error_log( 'Mi función personalizada llego a la URL.' );
   // Crear la URL a la que se va a redirigir
   $url = esc_url( add_query_arg( $data, 'https://expocafe.com.uy/datos.php' ) );

   // Abrir la URL en una nueva pestaña del navegador
   wp_redirect( $url, 302 );
   exit;
}

?>