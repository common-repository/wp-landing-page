<?php
/* Manage editing access to WPLP for users wordpress */

add_action( 'admin_menu', 'wplp_menu' );

function wplp_menu() {
	add_submenu_page('edit.php?post_type=wplp_landingpage', 'access', 'Access', 'wplp_edit_landing_page', 'access', 'wplp_access');
}

function wplp_access() {
	if ( !current_user_can( 'wplp_edit_landing_page' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	$out = '<div class="wrap">';
	$out .= '<h2>'.__('Access', 'wplp_landingpage').'</h2>';
	$out .= '<p><b>'.__('Select users who can edit the landing pages', 'wplp_landingpage').'</b></p>';

	if($_SERVER['REQUEST_METHOD'] == 'POST') :
		if(!$_POST['users']) :
			$out .= '<div class="notice error"><p>'.__('One user must be selected', 'wplp_landingpage').'</p></div>';
		else :
			$users = get_users();

			//Delete pemission to unchecked user
			foreach ($users as $user) :
				if(!in_array($user->ID, $_POST['users'])) :
					if( user_can( $user, 'wplp_edit_landing_page' ) ) :
						$user->remove_cap('wplp_edit_landing_page');
					endif;
				endif;
			endforeach;

			//Add permission to checked user
			foreach ($_POST['users'] as $userid) :
				if( !user_can( $userid, 'wplp_edit_landing_page' ) ) :
					$user = get_user_by('id', $userid);
					$user->add_cap('wplp_edit_landing_page');
				endif;
			endforeach;

			$out .= '<div class="notice updated"><p>'.__('Access Updated', 'wplp_landingpage').'</p></div>';
		endif;
	endif;

	$users = get_users();

	$out .= '<form method="post">';
		foreach ($users as $user) :
			$out .= '<div>';

				$checked = ( user_can( $user, 'wplp_edit_landing_page' ) ) ? 'checked' : '';

				$out .= '<input type="checkbox" name="users[]" value="'.$user->ID.'" '.$checked.' id="user'.$user->ID.'">';
				$out .= '<label for="user'.$user->ID.'"><strong>'.$user->user_login.'</strong></label>';
			$out .= '</div>';
		endforeach;

		$out .= '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__('Save Changes', 'wplp_landingpage').'"></p>';
	$out .= '</form>';
	$out .= '</div>';

	print $out;
}