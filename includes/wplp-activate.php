<?php

/* When plugin is activated : One pass */

function wplp_activate() {
	$user = wp_get_current_user();
	$user->add_cap( 'wplp_edit_landing_page' );
}