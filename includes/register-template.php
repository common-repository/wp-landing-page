<?php

/*
	this function allow possibility of register a new template in WPLP system.
	help you README.md to create your own template.
*/

$wplp_templates = array();

function wplp_register_template($system_name, $name, $folder) {

	global $wplp_templates;
		if(!isset($wplp_templates[$system_name])) {
			$wplp_templates[$system_name] = array(
				'system_name' => $system_name,
				'name' => $name,
				'folder' => $folder
			);
		}
		else {
			do_action( 'admin_notices_template_already_register', $system_name );
		}

}

function admin_notice_template_already_register($system_name) {
    ?>
    <div class="error">
        <p><?php _e( 'The template '. $system_name .' is already register', 'wplandingpage' ); ?></p>
    </div>
    <?php
}
add_action('admin_notices_template_already_register', 'admin_notice_template_already_register', 10, 1);
