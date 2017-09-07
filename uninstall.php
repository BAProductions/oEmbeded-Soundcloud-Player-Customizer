<?php 
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
class oEmbedSoundcloudPlayerCustomizer_uninstaller
{
	public function __construct() {
			// don't call add_shortcode here
			// actually, I worked with wordpress last year and
			// i think this is a good place to call add_shortcode 
			// (and all other filters) now...
	}
	public function oEmbedSoundcloudPlayerCustomizer_uninstall(){
		$options = array( 'swap_player', 'show_artwork', 'play_button_color', 'auto_play', 'hide_related', 'show_comments', 'show_user', 'show_reposts' );
		foreach($options as $option_name){
			unregister_setting('', $option_name, '');
			delete_option($option_name);
		}
	}
}
if (class_exists('oEmbedSoundcloudPlayerCustomizer_uninstaller')){
	$oEmbedSoundcloudPlayerCustomizer_uninstaller = new oEmbedSoundcloudPlayerCustomizer_uninstaller();
	$oEmbedSoundcloudPlayerCustomizer_uninstaller->oEmbedSoundcloudPlayerCustomizer_uninstall();
}