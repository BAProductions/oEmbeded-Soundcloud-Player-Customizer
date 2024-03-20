<?php
if (!defined('ABSPATH')) {
    die;
}
?>

<?php
class WP_Soundcloud_Player_Customizer_Settings_Manager {
    public function __construct() {
    }
    
    public function wp_soundcloud_player_customizer_settings_manager_init() {
        register_deactivation_hook(__FILE__, array($this, 'wp_soundcloud_player_customizer_settings_manager_register_uninstall'));
    }

    public function wp_soundcloud_player_customizer_settings_manager_register_uninstall() {
        register_uninstall_hook(__FILE__, array($this, 'wp_soundcloud_player_customizer_aettings_manager_uninstall'));
    }

    public function wp_soundcloud_player_customizer_aettings_manager_uninstall(){
        $options = array( 'wpscpc_swap_player', 'wpscpc_show_artwork', 'wpscpc_play_button_color', 'wpscpc_auto_play', 'wpscpc_hide_related', 'wpscpc_show_comments', 'wpscpc_show_user', 'wpscpc_show_reposts' );
        foreach($options as $option_name){
            delete_option($option_name);
        }
    }
}
if (class_exists('WP_Soundcloud_Player_Customizer_Settings_Manager')){
    $wp_soundcloud_player_customizer_settings_manager = new WP_Soundcloud_Player_Customizer_Settings_Manager();
    $wp_soundcloud_player_customizer_settings_manager->wp_soundcloud_player_customizer_settings_manager_init();
}
?>
