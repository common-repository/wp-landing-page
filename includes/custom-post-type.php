<?php

/*
	Create Custom Post Type : Landing Page
	Create Metabox in edit / create landing page
*/

function wplp_create_post_type() {

  if(!get_option('permalink_structure')) $rewrite = false;
  else $rewrite = array('slug' => 'landing-page', 'with_front' => false);

  register_post_type( 'wplp_landingpage',
    array(
      'labels' => array(
        'name' => __( 'Landing Pages', 'wplandingpage' ),
        'singular_name' => __( 'Landing Page', 'wplandingpage' ),
		'menu_name'          => __( 'Landing Pages', 'wplandingpage' ),
		'name_admin_bar'     => __( 'Landing Page', 'wplandingpage' ),
		'add_new'            => __( 'Add New', 'wplandingpage' ),
		'add_new_item'       => __( 'Add New Landing Page', 'wplandingpage' ),
		'new_item'           => __( 'New Landing Page', 'wplandingpage' ),
		'edit_item'          => __( 'Edit Landing Page', 'wplandingpage' ),
		'view_item'          => __( 'View Landing Page', 'wplandingpage' ),
		'all_items'          => __( 'All Landing Pages', 'wplandingpage' ),
		'search_items'       => __( 'Search Landing Pages', 'wplandingpage' ),
		'parent_item_colon'  => __( 'Parent Landing Pages:', 'wplandingpage' ),
		'not_found'          => __( 'No Landing Pages found.', 'wplandingpage' ),
		'not_found_in_trash' => __( 'No Landing Pages found in Trash.', 'wplandingpage' )
      ),
      'public' => true,
      'supports' => array('title'),
      'menu_icon' => 'dashicons-align-left',
      'rewrite' => $rewrite,
      'capability_type' => 'post',
      'capabilities' => array(
        'edit_post' => 'wplp_edit_landing_page',
        'edit_posts' => 'wplp_edit_landing_page',
        'edit_others_posts' => 'wplp_edit_landing_page',
        'publish_posts' => 'wplp_edit_landing_page',
        'read_private_posts' => 'wplp_edit_landing_page',
        'delete_post' => 'wplp_edit_landing_page'
      )
    )
  );
}

add_action( 'init', 'wplp_create_post_type' );

function wplp_add_meta_box() {
	add_meta_box(
		'wplp_explain',
		__( 'Explanations', 'wplandingpage' ),
		'wplp_explanations_callback',
		'wplp_landingpage'
	);

	add_meta_box(
		'wplp_choosetemplate',
		__( 'Choose a template', 'wplandingpage' ),
		'wplp_choosetemplate_callback',
		'wplp_landingpage'
	);

	/*add_meta_box(
		'wplp_statistics',
		__( 'Statistics', 'wplandingpage' ),
		'wplp_statistics_callback',
		'wplp_landingpage'
	);*/
}
add_action( 'add_meta_boxes', 'wplp_add_meta_box' );

function wplp_explanations_callback($post) {

    $link = esc_url(apply_filters('preview_post_link', add_query_arg('preview', 'true', get_permalink($post->ID))));

	$out = '<div class="wplp_templates">';

	$out .= '<p>';
	if( $post->post_status === 'auto-draft' ){
		$out .= __( 'After you set up your landing page , you need <b>save</b> to edit the content.');
	} else {
		$out .= __( 'After you set up your landing page , you need to edit the content.');
		$out .= '<br>';
		$out .= sprintf(__('You can do so by following this link : <b><a target="_blank" href="%s">Edit your landing page</a></b>'), $link);
	}
	$out .= '</p>';
	$out .= '<input type="hidden" name="wp-preview" id="wp-preview" value="">';
	$out .= '<div class="clearfix"></div>';
	$out .= '</div>';

	print $out;
}

function wplp_choosetemplate_callback($post) {
	global $wplp_templates;

	$out = '<div class="wplp_templates">';
		$templateFirst = true;

		foreach ($wplp_templates as $template) {
			$out .= '<div class="wplp_template">';

				$checked = ( get_post_meta($post->ID, 'wplp_template', true) == $template['system_name'] ) ? 'checked' : '';

				if( $templateFirst and !get_post_meta($post->ID, 'wplp_template', true) ) :
					$checked = 'checked';
				endif;


				if(file_exists(WP_PLUGIN_DIR . $template['folder']. '/screenshot.jpg')) :
					$out .= '<img src="'.WP_PLUGIN_URL . $template['folder']. '/screenshot.jpg" class="screenshot" />';
				else :
					$out .= '<img src="'.plugins_url( '../images/default-screenshot.jpg', __FILE__ ).'" class="screenshot" />';
				endif;
				$out .= '<input type="radio" name="wplp_template" value="'. $template['system_name'] .'" '.$checked.' />';
				$out .= $template['name'];
			$out .= '</div>';

			$templateFirst = false;
		}
		$out .= '<div class="clearfix"></div>';
	$out .= '</div>';

	/*if ( !is_plugin_active( 'wp-landing-page-premium/wplandingpage-premium.php' ) ) :
		$out .= '<div class="more_templates">';
			$out .= '<a target="__blank" href="http://www.wp-inbound.com/wplandingpage/">More Templates Here +</a>';
		$out .= '</div>';
	endif;*/

	print $out;
}

function wplp_statistics_callback($post) {
	$visits = intval(get_post_meta($post->ID, 'wplp_counter_visits', true));
	$conv = intval(get_post_meta($post->ID, 'wplp_counter_conv', true));

	if($visits) $percent = round($conv * 100 / $visits);
	else $percent = 0;

	print "<div class='wplp_statistics'>";
		print "<div class='percent'>".$percent." %</div>";
		print "<div class='visits'>". $visits . " Visits</div>";
		print "<div class='conversions'>". $conv. " Conversions</div>";
		print "<div class='clearfix'></div>";
	print "</div>";
}

function wplp_save_meta_box($post_id) {
	if( isset($_POST['post_type']) && $_POST['post_type'] == 'wplp_landingpage' ) {
		update_post_meta( $post_id, 'wplp_template', $_POST['wplp_template'] );
	}
}
add_action('save_post', 'wplp_save_meta_box');
