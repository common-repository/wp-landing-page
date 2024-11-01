<?php

/*
	these function add css in frontend / backend
*/

function wplp_admin_style() {
    wp_register_style( 'wplp_admin_style', plugins_url( '../css/admin-style.css', __FILE__ ) );
    wp_enqueue_style( 'wplp_admin_style' );
}
add_action( 'admin_enqueue_scripts', 'wplp_admin_style' );

function wplp_style() {
    wp_register_style( 'wplp_style', plugins_url( '../css/style.css', __FILE__ ) );
    wp_enqueue_style( 'wplp_style' );
}
add_action( 'wp_enqueue_scripts', 'wplp_style' );