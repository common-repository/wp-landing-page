<?php

/*
	This file create a custom base template just for landing pages
	at /templates/base/single-landingpage.php
*/

function wplp_single_template($single_template) 
{
     global $post;

     if ($post->post_type == 'wplp_landingpage') 
     {
        $single_template = plugin_dir_path( __FILE__ ) . '../templates/base/single-landingpage.php';
     }

     return $single_template;
}
add_filter( 'single_template', 'wplp_single_template' );