<?php
/*
Plugin Name: WP Soundcloud Player Customizer
Plugin URI:  https://github.com/BAProductions/oEmbeded-Soundcloud-Player-Customizer
Description: Customize Embed Soundcloud Player in WordPress
Version:     0.1
Author:      PressThemes/BAProductions/DJANHipHop
Author URI:  https://github.com/BAProductions
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpscpc
Domain Path: /languages
*/
/*{oEmbed Soundcloud Player Customizer} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{oEmbed Soundcloud Player Customizer} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {oEmbed Soundcloud Player Customizer}. If not, see {License URI}.
*/
?>

<?php
if ( ! defined( 'ABSPATH' ) ) {
   return;
}
?>

<?php
class WP_Soundcloud_Player_Customizer {
    public function __construct() {
        define('WPSCPC_PLUGIN_DIR', plugin_dir_path(__FILE__));
    }

    public function wp_soundcloud_player_customizer_init(){
//        require_once(WPSCPC_PLUGIN_DIR . '/wp-soundcloud-player-customizer-unstall-settings_manager.php');
        require_once(WPSCPC_PLUGIN_DIR . '/customizer/wp-soundcloud-player-customizer-settings.php');
        add_action('oembed_result', array($this, 'wp_soundcloud_player_customizer_embed'), 10, 999999);
    }

    public function wp_soundcloud_player_customizer_embed($html, $url) {
        // Only use this filter on Soundcloud embeds
        if (strpos($url, 'soundcloud.com') !== false) {
            // Retrieve options with default values
            $visual = (int) get_option('oesc_swap_player', true) ? false : true; // Default value is 1
            $show_artwork = (int) get_option('oesc_show_artwork', true) ? true : false; // Default value is 1
            $play_button_color = str_replace('#', '', get_option('oesc_play_button_color', '#FF9900')); // Default value is '#FF9900'
            $auto_play = (int) get_option('oesc_auto_play', false) ? true : false; // Default value is 1
            $hide_related = (int) get_option('oesc_hide_related', false) ? true : false; // Default value is 1
            $show_comments = (int) get_option('oesc_show_comments', false) ? true : false; // Default value is 1
            $show_user = (int) get_option('oesc_show_user', false) ? true : false; // Default value is 1
            $show_reposts = (int) get_option('oesc_show_reposts', false) ? true : false; // Default value is 1
            
            // Construct options string
            $options = "&color=" . $play_button_color . "&auto_play=" . $auto_play . "&hide_related=" . $hide_related . "&show_comments=" . $show_comments . "&show_user=" . $show_user . "&show_reposts=" . $show_reposts;

            // Set the height of the player
            if ($visual == 0) {
                $height = preg_match("/playlists/", $html) ? "450" : "166"; // height for playlists mode or single mode
            } else {
                $height = "450"; // default height
            }

            // Array of patterns to find in the oembed iframe html
            $patterns = array();
            $patterns[0] = "/visual=true/"; // true means a big image background
            $patterns[1] = "/show_artwork=true/"; // true means show the track artwork
            $patterns[2] = "/ height=\"\d+?\"/"; // height of standard embed is in the 400-pixel range. Just look for any height integer
            $patterns[3] = "/ width=\"\d+?\"/"; // width of standard embed in WordPress seems to be a fixed pixel width. Look for any integer
            
            // Array of replacements to make for these patterns
            $replacements = array();
            $replacements[0] = "visual=" . $visual . ""; // turn off big image background
            $replacements[1] = "show_artwork=" . $show_artwork . $options; // turn off track artwork
            $replacements[2] = " height=\"" . $height . "\""; // set iframe height to 166 pixels, the embed standard for the Soundcloud mini player
            $replacements[3] = " width=\"100%\""; // set iframe to full width instead of fixed pixel dimension
            
            // Prophylactic ksort to make sure that all patterns and replacements will line up regardless of what order they're input
            ksort($patterns);
            ksort($replacements);
            
            // One public function to do all the find and replace
            $html = preg_replace($patterns, $replacements, $html);
            
            // Return the html string
            return $html;
        }
        return $html;
    }
}

if (class_exists('WP_Soundcloud_Player_Customizer')){
    $wp_soundcloud_player_customizer = new WP_Soundcloud_Player_Customizer();
    $wp_soundcloud_player_customizer->wp_soundcloud_player_customizer_init();
}

?>
