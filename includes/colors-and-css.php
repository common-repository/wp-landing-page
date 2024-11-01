<?php

	/* This function print dymamic CSS file to display colors. */

	function wplp_css($postid) {
		global $wplp_templates;

		var_dump($wplp_templates);

		$template = $wplp_templates[get_post_meta($postid, 'wplp_template', true)];

		var_dump($wplp_templates);

		if(file_exists(WP_PLUGIN_DIR . $template['folder']. '/config.json')) :
			if( !$config = json_decode( file_get_contents(WP_PLUGIN_DIR . $template['folder']. '/config.json'), true ) ):
				_e('The config.json file isn\'t in correct format', 'wplandingpage');
				die;
			endif;
		else :
			_e('The config.json not exists', 'wplandingpage');
			die;
		endif;
		$urlTemplate = WP_PLUGIN_URL . $template['folder'] . '/';
		$rootTemplate = WP_PLUGIN_DIR . $template['folder']. '/';

		if(!$topline = get_post_meta($postid, 'wplp_colors_topline', true)) :
			$topline = '1976D2';
		endif;

		if(!$toplinetxt = get_post_meta($postid, 'wplp_colors_toplinetxt', true)) :
			$toplinetxt = 'fff';
		endif;

		if(!$header = get_post_meta($postid, 'wplp_colors_header', true)) :
			$header = '2196F3';
		endif;

		if(!$headertxt = get_post_meta($postid, 'wplp_colors_headertxt', true)) :
			$headertxt = '212121';
		endif;

		if(!$benefits = get_post_meta($postid, 'wplp_colors_benefits', true)) :
			$benefits = 'eee';
		endif;

		if(!$benefitstxt = get_post_meta($postid, 'wplp_colors_benefitstxt', true)) :
			$benefitstxt = '999';
		endif;

		if(!$cta = get_post_meta($postid, 'wplp_colors_cta', true)) :
			$cta = 'CDDC39';
		endif;

		if(!$ctatxt = get_post_meta($postid, 'wplp_colors_ctatxt', true)) :
			$ctatxt = '333';
		endif;

	    header('content-type: text/css');
	    header('Cache-Control: max-age=31536000, must-revalidate');

	    $color = file_get_contents(dirname(__FILE__) . '/../css/color.css', true);

	    $custom = str_replace(array('%%topline%%','%%toplinetxt%%','%%header%%','%%headertxt%%','%%benefits%%','%%benefitstxt%%','%%cta%%','%%ctatxt%%'),
	    						array('#'.$topline, '#'.$toplinetxt, '#'.$header, '#'.$headertxt, '#'.$benefits, '#'.$benefitstxt, '#'.$cta, '#'.$ctatxt), $color);

	    echo "body:before { display: none !important; }"; //HACK for Twenty Fifteen

		if($config['css']) :
			foreach ($config['css'] as $file) :
				if( file_exists($rootTemplate . $file) ):
					echo file_get_contents($rootTemplate . $file);
				endif;
			endforeach;
		endif;

	    echo $custom;
		die;
	}

	/* When url has param wplp_colors print dynamic css */

	function wplp_css_template() {
		if(isset($_GET['wplp_css']) && $_GET['wplp_css']) :
			wplp_css($_GET['wplp_css']);
		endif;
	}
	add_action('init', 'wplp_css_template');

	/* Add Metabox for colors pickers */
	function wplp_add_colors_meta_box() {
		add_meta_box('wplp_colors', 'Colors', 'wplp_meta_box_colors_callback', 'wplp_landingpage');
	}

	add_action( 'add_meta_boxes', 'wplp_add_colors_meta_box' );

	function wplp_meta_box_colors_callback( $post ) {
		if(!$topline = get_post_meta($post->ID, 'wplp_colors_topline', true)) :
			$topline = '1976D2';
		endif;


		if(!$toplinetxt = get_post_meta($post->ID, 'wplp_colors_toplinetxt', true)) :
			$toplinetxt = 'fff';
		endif;

		if(!$header = get_post_meta($post->ID, 'wplp_colors_header', true)) :
			$header = '2196F3';
		endif;

		if(!$headertxt = get_post_meta($post->ID, 'wplp_colors_headertxt', true)) :
			$headertxt = '212121';
		endif;

		if(!$benefits = get_post_meta($post->ID, 'wplp_colors_benefits', true)) :
			$benefits = 'eee';
		endif;

		if(!$benefitstxt = get_post_meta($post->ID, 'wplp_colors_benefitstxt', true)) :
			$benefitstxt = '999';
		endif;

		if(!$cta = get_post_meta($post->ID, 'wplp_colors_cta', true)) :
			$cta = 'CDDC39';
		endif;

		if(!$ctatxt = get_post_meta($post->ID, 'wplp_colors_ctatxt', true)) :
			$ctatxt = '333';
		endif;

		$out = '<div class="custom_meta_box">';
			$out .= '<div class="colorpick">';
				$out .= '<div><label>'.__('Top Line', 'wplandingpage').' : </label></div>';
				$out .= '<input class="color-field" type="text" name="wplp_colors_topline" value="#'.$topline.'"/>';
			$out .= '</div>';

			$out .= '<div class="colorpick">';
				$out .= '<div><label>'.__('Top Line Text', 'wplandingpage').' : </label></div>';
				$out .= '<input class="color-field" type="text" name="wplp_colors_toplinetxt" value="#'.$toplinetxt.'"/>';
			$out .= '</div>';

			$out .= '<div class="colorpick">';
				$out .= '<div><label>'.__('Header', 'wplandingpage').' : </label></div>';
				$out .= '<input class="color-field" type="text" name="wplp_colors_header" value="#'.$header.'"/>';
			$out .= '</div>';

			$out .= '<div class="colorpick">';
				$out .= '<div><label>'.__('Header Text', 'wplandingpage').' : </label></div>';
				$out .= '<input class="color-field" type="text" name="wplp_colors_headertxt" value="#'.$headertxt.'"/>';
			$out .= '</div>';

			$out .= '<div class="colorpick">';
				$out .= '<div><label>'.__('Benefits', 'wplandingpage').' : </label></div>';
				$out .= '<input class="color-field" type="text" name="wplp_colors_benefits" value="#'.$benefits.'"/>';
			$out .= '</div>';

			$out .= '<div class="colorpick">';
				$out .= '<div><label>'.__('Benefits Text', 'wplandingpage').' : </label></div>';
				$out .= '<input class="color-field" type="text" name="wplp_colors_benefitstxt" value="#'.$benefitstxt.'"/>';
			$out .= '</div>';

			$out .= '<div class="colorpick">';
				$out .= '<div><label>'.__('Call to Action', 'wplandingpage').' : </label></div>';
				$out .= '<input class="color-field" type="text" name="wplp_colors_cta" value="#'.$cta.'"/>';
			$out .= '</div>';

			$out .= '<div class="colorpick">';
				$out .= '<div><label>'.__('Call to Action Text', 'wplandingpage').' : </label></div>';
				$out .= '<input class="color-field" type="text" name="wplp_colors_ctatxt" value="#'.$ctatxt.'"/>';
			$out .= '</div>';
			$out .= "<div class='clearfix'></div>";
		$out .= '</div>';

		$out .= '<script>
			(function( $ ) {
				$(function() {
					$(".color-field").wpColorPicker();
				});
			})( jQuery );
			</script>';

		print $out;
	}

	function wplp_colorpicker(){
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');
	}
	add_action('admin_enqueue_scripts', 'wplp_colorpicker');

	/* Save color metabox */
	function wplp_colors_save_meta_box_data( $post_id ) {
		if( isset($_POST['post_type']) && $_POST['post_type'] == 'wplp_landingpage' ) :
			$topline = ( isset( $_POST['wplp_colors_topline'] ) ? sanitize_html_class( $_POST['wplp_colors_topline'] ) : '1976D2' );
			update_post_meta( $post_id, 'wplp_colors_topline', $topline );

			$toplinetxt = ( isset( $_POST['wplp_colors_toplinetxt'] ) ? sanitize_html_class( $_POST['wplp_colors_toplinetxt'] ) : 'fff' );
			update_post_meta( $post_id, 'wplp_colors_toplinetxt', $toplinetxt );

			$header = ( isset( $_POST['wplp_colors_header'] ) ? sanitize_html_class( $_POST['wplp_colors_header'] ) : '2196F3' );
			update_post_meta( $post_id, 'wplp_colors_header', $header );

			$headertxt = ( isset( $_POST['wplp_colors_headertxt'] ) ? sanitize_html_class( $_POST['wplp_colors_headertxt'] ) : '212121' );
			update_post_meta( $post_id, 'wplp_colors_headertxt', $headertxt );

			$benefits = ( isset( $_POST['wplp_colors_benefits'] ) ? sanitize_html_class( $_POST['wplp_colors_benefits'] ) : 'eee' );
			update_post_meta( $post_id, 'wplp_colors_benefits', $benefits );

			$benefitstxt = ( isset( $_POST['wplp_colors_benefitstxt'] ) ? sanitize_html_class( $_POST['wplp_colors_benefitstxt'] ) : '999' );
			update_post_meta( $post_id, 'wplp_colors_benefitstxt', $benefitstxt );

			$cta = ( isset( $_POST['wplp_colors_cta'] ) ? sanitize_html_class( $_POST['wplp_colors_cta'] ) : 'CDDC39' );
			update_post_meta( $post_id, 'wplp_colors_cta', $cta );

			$ctatxt = ( isset( $_POST['wplp_colors_ctatxt'] ) ? sanitize_html_class( $_POST['wplp_colors_ctatxt'] ) : '333' );
			update_post_meta( $post_id, 'wplp_colors_ctatxt', $ctatxt );
		endif;
	}
	add_action( 'save_post', 'wplp_colors_save_meta_box_data' );
