<?php

/*
	fonction to call in templates for editing text in frontend.
*/

function wplp_editable_text($key, $default) {
	global $post;

	$value = '';

	if( $text = get_post_meta($post->ID, $key, true) ) :
		$value = $text;
	else:
		$value = $default;
	endif;

	print '<div class="wplp_editable_text" data-postid="'.$post->ID.'" data-key="'.$key.'">' . do_shortcode($value) . '</div>';
}