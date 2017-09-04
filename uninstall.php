<?php 
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
$options = array( 'swap_player', 'show_artwork', 'play_button_color', 'auto_play', 'hide_related', 'show_comments', 'show_user', 'show_reposts' );
foreach($options as $option_name){
	unregister_setting('', $option_name, '');
	delete_option($option_name);
}