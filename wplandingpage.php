<?php
/*
Plugin Name: WP Landing Page
Plugin URI: http://www.b5prod.com
Description: Plugin For Create Landing Pages
Version: 0.9.3
Author: B5 Productions
Author URI: http://www.b5prod.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: wplandingpage

WP Landing Page is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WP Landing Page is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WP Landing Page. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once dirname(__FILE__) . '/includes/default-templates.php';

require_once dirname(__FILE__) . '/includes/custom-post-type.php';
require_once dirname(__FILE__) . '/includes/register-template.php';
require_once dirname(__FILE__) . '/includes/custom-template.php';
require_once dirname(__FILE__) . '/includes/wplp-editable-text.php';
require_once dirname(__FILE__) . '/includes/wplp-editable-image.php';
require_once dirname(__FILE__) . '/includes/wplp-editable-menu.php';
require_once dirname(__FILE__) . '/includes/wplp-api.php';
require_once dirname(__FILE__) . '/includes/styling.php';
require_once dirname(__FILE__) . '/includes/access.php';
require_once dirname(__FILE__) . '/includes/wplp-activate.php';
register_activation_hook( __FILE__, 'wplp_activate' );

require_once dirname(__FILE__) . '/includes/colors-and-css.php';


if ( !is_plugin_active( 'wp-landing-page-premium/wplandingpage-premium.php' ) ) {
	function wplp_admin_notice() {
		$screen = get_current_screen();
		$type = $screen->post_type;
		if($type === "wplp_landingpage"){
			print '<div class="error notice">';
			print '<p>'. __( 'Download Landing Page <strong>PREMIUM</strong> Template <a target="__blank" href="http://www.wp-inbound.com/wplandingpage/">Here</a> !', 'wplandingpage' ) .'</p>';
			print '</div>';
		}
	}
	add_action( 'admin_notices', 'wplp_admin_notice' );
}
