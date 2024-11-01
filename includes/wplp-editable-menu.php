<?php

/*
	fonction to call in templates for editing menus in frontend.
*/

function wplp_editable_menu($key) {
	global $post;

	$value = get_post_meta($post->ID, $key, true);

	if(!$value) :
		$navMenu = '';
	else :
		$navMenu = wp_nav_menu(array('theme_location' => $value, 'echo' => false));
	endif;

	print '<div class="wplp_editable_menu" data-postid="'.$post->ID.'" data-key="'.$key.'">' . $navMenu . '</div>';
}