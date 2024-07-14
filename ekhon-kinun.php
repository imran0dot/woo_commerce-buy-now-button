<?php
/*
Plugin Name: এখনি কিনুন
Plugin URI: https://detectiveseo.com
Description: সরাসরি প্রডাক্ট পেইজ এ কিনুন বাটন এড করার জন্য এই প্লাগিন ব্যবহার করা হয়েছে..
Version: 1.0
Author: Imran0dot
Author URI: https://detectiveseo.com
License: GPL v2 or later
Text Domain: detectiveseo
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook to add the Buy Now button
add_action( 'woocommerce_after_add_to_cart_button', 'add_buy_now_button' );

function add_buy_now_button() {
    global $product;
    $buy_now_url = add_query_arg( 'buy_now', $product->get_id(), wc_get_checkout_url() );

    echo '<a href="' . esc_url( $buy_now_url ) . '" class="button buy-now-button">Buy Now</a>';
}

// Redirect to checkout if Buy Now button is clicked
add_action( 'template_redirect', 'redirect_to_checkout' );

function redirect_to_checkout() {
    if ( isset( $_GET['buy_now'] ) ) {
        $product_id = intval( $_GET['buy_now'] );

        if ( $product_id > 0 ) {
            WC()->cart->empty_cart();
            WC()->cart->add_to_cart( $product_id );
            wp_safe_redirect( wc_get_checkout_url() );
            exit;
        }
    }
}

// Enqueue the custom stylesheet for the plugin
// add_action( 'wp_enqueue_scripts', 'enqueue_buy_now_button_styles' );

// function enqueue_buy_now_button_styles() {
//     wp_enqueue_style( 'buy-now-button-styles', plugin_dir_url( __FILE__ ) . 'style.css' );
// }