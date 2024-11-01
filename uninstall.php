<?php

// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
$posts = get_posts( array(
	'numberposts' => -1,
	'post_type' =>'wplp_landingpage'
) );


if (is_array($posts)) {
   foreach ($posts as $post) {
       wp_delete_post( $post->ID, true);
   }
}