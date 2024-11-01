<?php

/*
	fonction to call in templates for editing image in frontend.
*/

function wplp_editable_image($key, $default, $defaultClass = null) {
	global $post;

	$value = '';

	if( $image = get_post_meta($post->ID, $key, true) ) :
		$value = wp_get_attachment_image($image, 'full');
	else:
		$value = '<img src="'.$default.'" />';
	endif;

	print '<div data-postid="'.$post->ID.'" data-key="'.$key.'" class="wplp_editable_image '.$defaultClass.'">'.$value.'</div>';

}