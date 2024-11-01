<?php

/*
	these lines register defaults templates of WPLP
*/

function wplp_default_templates() {
	wplp_register_template('free1', 'Landing Page Free', '/' . plugin_basename( dirname(__FILE__) ) . '/../templates/free1');
}

add_action('init', 'wplp_default_templates');