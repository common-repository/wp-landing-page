<?php

/*
	Define a ajax api to frontend editing
*/

add_action( 'wp_ajax_wplp_update_image', 'wplp_api_update_image' );
add_action( 'wp_ajax_wplp_update_text', 'wplp_api_update_text' );
add_action( 'wp_ajax_wplp_get_text', 'wplp_api_get_text' );
add_action( 'wp_ajax_wplp_get_menu_list', 'wplp_api_get_menu_list' );
add_action( 'wp_ajax_wplp_edit_menu', 'wplp_api_edit_menu' );
add_action( 'wp_ajax_wplp_count_conv', 'wplp_api_count_conv' );

function wplp_api_update_text() {
	if ( current_user_can( 'wplp_edit_landing_page' ) ) :
		update_post_meta($_POST['postid'], $_POST['key'], stripslashes($_POST['text']));
		print do_shortcode(stripslashes($_POST['text']));
		die();
	endif;
}

function wplp_api_get_text() {
	if ( current_user_can( 'wplp_edit_landing_page' ) ) :
		header('Content-Type: text/html');
		$text = get_post_meta($_POST['postid'], $_POST['key'], true);
		print $text;
		die();
	endif;
}

function wplp_api_update_image() {
	if ( current_user_can( 'wplp_edit_landing_page' ) ) :

		//Upload to media library
		$upload = media_handle_upload( 'file', $_POST['postid'] );

		if( !$upload['error'] ) :
			update_post_meta($_POST['postid'], $_POST['key'], $upload);
			print wp_get_attachment_image($upload, 'full');
		endif;
		die();
	endif;
}

function wplp_api_get_menu_list() {
	if ( current_user_can( 'wplp_edit_landing_page' ) ) :
		
		$menus = get_registered_nav_menus();


		$out = '<form>';
			$out .= '<select name="wplp_menu">';
				$actualValue = get_post_meta($_POST['postid'], $_POST['key'], true);
				$selected = (!$actualValue) ? 'selected' : '';
				$out .= '<option value="0" '.$selected.'>'.__('None', 'wplandingpage').'</option>';
				foreach ($menus as $location => $description) :
					$selected = ($actualValue == $location) ? 'selected' : '';
					$out .= '<option value="'.$location.'" '.$selected.'>'.$description.'</option>';
				endforeach;
			$out .= '</select>';

			$out .= '<input type="submit" value="'.__('Ok', 'wplandingpage').'" class="submit_menu_form" />';
		$out .= '</form>';

		print $out;



		die();
	endif;
}


function wplp_api_edit_menu() {
	if ( current_user_can( 'wplp_edit_landing_page' ) ) :
		
		update_post_meta($_POST['postid'], $_POST['key'], $_POST['value']);

		print wp_nav_menu(array('theme_location' => $_POST['value']));

		die();
	endif;
}


function wplp_api_count_conv() {
	$nbConv = get_post_meta($_POST['postid'], 'wplp_counter_conv', true);
	update_post_meta($_POST['postid'], 'wplp_counter_conv', $nbConv+1);
}