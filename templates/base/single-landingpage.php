<?php
	$template = $wplp_templates[get_post_meta($post->ID, 'wplp_template', true)];
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

	$nbVisites = get_post_meta($post->ID, 'wplp_counter_visits', true);
	update_post_meta($post->ID, 'wplp_counter_visits', $nbVisites+1);
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="?wplp_css=<?php print $post->ID; ?>" />
	<?php wp_head(); ?>

	<?php if ( current_user_can( 'wplp_edit_landing_page' ) ) : ?>
		<style type="text/css">
			body {
				margin-bottom: 50px;
			}
		</style>
	<?php endif; ?>
</head>
<body>
	<?php if ( current_user_can( 'wplp_edit_landing_page' ) ) : ?>
		<div id="wplp_infobox"></div>
		<div id='wplp_overlay'><div class="popup">
			<div class="popup-close"><?php _e('Close', 'wplandingpage') ?></div>
			<p>
				<?php _e('You can use the Shortcodes with', 'wplandingpage') ?> <a href="https://codex.wordpress.org/Shortcode_API" target="__blank"><?php _e('Codex', 'wplandingpage') ?></a>
			</p>
			<?php wp_editor( '', 'testeditor', array() ); ?>
			<button class="submit"><?php _e('Update this text', 'wplandingpage') ?></button>
		</div></div>
	<?php endif; ?>

	<?php require_once $rootTemplate . 'index.php'; ?>

	<?php if($config['js']) : ?>
		<?php foreach ($config['js'] as $file) : ?>
			<?php if( file_exists($rootTemplate . $file) ): ?>
				<script src="<?php print $urlTemplate . $file ?>" type="text/javascript"></script>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<?php if ( current_user_can( 'wplp_edit_landing_page' ) ) : ?>
		<script type="text/javascript">
			(function() {
				this.WPLP = {};
				WPLP.infoboxText = "<?php _e('Double Clic to edit this text', 'wplandingpage') ?>";
				WPLP.infoboxImage = "<?php _e('Clic to edit this image', 'wplandingpage') ?>";
				WPLP.infoboxMenu = "<?php _e('Double Clic to change this menu', 'wplandingpage') ?>";
			}).call(this);
		</script>
		<script type="text/javascript" src="<?php print plugins_url( '../../lib/plupload/js/plupload.full.min.js', __FILE__ ); ?>"></script>
		<script type="text/javascript" src="<?php print plugins_url( '../../js/main.js', __FILE__ ); ?>"></script>
	<?php endif; ?>
	<?php wp_footer(); ?>
</body>
</html>