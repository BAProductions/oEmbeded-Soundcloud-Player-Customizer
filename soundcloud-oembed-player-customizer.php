<?php
/*
Plugin Name: Soundcloud oEmbed Player Customizer
Plugin URI:  https://github.com/BAProductions
Description: Customize Embed Soundcloud Player in WrodPress
Version:     0.1
Author:      PressThemes/BAProductions/DJANHipHop
Author URI:  https://github.com/BAProductions
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: scoepc
Domain Path: /languages
*/
/*{Soundcloud oEmbed Player Customizer} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Soundcloud oEmbed Player Customizer} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/
?>
<?php 
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

defined( 'ABSPATH' ) or die("Hay, you cant access this file you, silly person!");

if ( !function_exists("add_action") ) {
	echo "Hay, you cant access this file you, silly person!";
	die;
}
?>
<?php
class scepc
{
	public function __construct() {
			// don't call add_shortcode here
			// actually, I worked with wordpress last year and
			// i think this is a good place to call add_shortcode 
			// (and all other filters) now...
			add_action( 'admin_menu', array($this, 'scepc_options_page'));
			add_action( 'admin_enqueue_scripts', array($this, 'scepc_add_color_picker'));
			add_action( 'admin_init', array($this, 'scepc_custom_settings'));
			add_action( 'embed_oembed_html', array($this, 'soundcloud_embed'), 10, 3);
			register_activation_hook( __FILE__, array($this, 'scepc_activate') );
			register_deactivation_hook( __FILE__, array($this, 'scepc_deactivate') );
	}
	public function scepc_activate() {
		// Activation code here
		$this->scepc_options_page();
		$this->scepc_add_color_picker();
		$this->scepc_custom_settings();
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
	public function scepc_deactivate() {
		// Deactivation code here
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
	public function scepc_add_color_picker( $hook ) {
		if( is_admin() ) { 
			if( 'toplevel_page_sc-customizer' == $hook ){ 
				// Add the color picker css file       
				wp_enqueue_style( 'wp-color-picker' ); 
				// Include our custom jQuery file with WordPress Color Picker dependency
				wp_enqueue_script( 'custom-script-handle', plugins_url( 'js/player-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), '1.0.0', true );
				// Include our custom jQuery file with to handle the live update of both player
				wp_enqueue_script( 'scepc_admin_js', plugins_url( 'js/player-live-update.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
				// Include css to style the Soundcloud embedded player customizer admin page
				wp_enqueue_style( 'scepc_admin_style', plugins_url( '/css/scec.admin.css', __FILE__ ), array(), '1.0.0', 'all' );
			}else{
				return $hook; 
			}
		}
	}
	public function scepc_options_page() {
		//Genrate Soundcloud embedded player customizer admin page
		add_menu_page(
			'Soundcloud Embeded player Customizer',
			__('SC Customizer'),
			'manage_options',
			'sc-customizer',
			array($this, 'scepc_options_page_html'),
			plugin_dir_url(__FILE__)  . 'images/icon_scec.png',
			plugin_dir_url(__FILE__)  . 'images/icon_scec.png',
			110
		);
	}
	public function scepc_custom_settings() {
		register_setting( 'scepc_settings_group', 'swap_player' );
		register_setting( 'scepc_settings_group', 'show_artwork' );
		register_setting( 'scepc_settings_group', 'play_button_color', array(&$this, 'scepc_sanitize_color_handler') );
		register_setting( 'scepc_settings_group', 'auto_play' );
		register_setting( 'scepc_settings_group', 'hide_related' );
		register_setting( 'scepc_settings_group', 'show_comments' );
		register_setting( 'scepc_settings_group', 'show_user' );
		register_setting( 'scepc_settings_group', 'show_reposts' );
		add_settings_section( 'soundcloud_embeded_player_options', 'Player Setting', array($this, 'soundcloud_embeded_player_options'), 'scep_customizer');
		add_settings_field( 'swap_player', 'Enable Mini Player', array($this, 'scepc_swap_player'), 'scep_customizer', 'soundcloud_embeded_player_options');
		add_settings_field( 'show_artwork', 'Show Arework', array($this, 'scepc_show_artwork'), 'scep_customizer', 'soundcloud_embeded_player_options');
		add_settings_field( 'play_button_color', 'Play Button Color', array($this, 'scepc_play_button_color'), 'scep_customizer', 'soundcloud_embeded_player_options');
		add_settings_field( 'auto_play', 'Enable Auto Play', array($this, 'scepc_auto_play'), 'scep_customizer', 'soundcloud_embeded_player_options');
		add_settings_field( 'hide_related', 'Hide Related', array($this, 'scepc_hide_related'), 'scep_customizer', 'soundcloud_embeded_player_options');
		add_settings_field( 'show_user', 'Show User', array($this, 'scepc_show_user'), 'scep_customizer', 'soundcloud_embeded_player_options');
		add_settings_field( 'show_comments', 'Show Comments', array($this, 'scepc_show_comments'), 'scep_customizer', 'soundcloud_embeded_player_options');
		add_settings_field( 'show_reposts', 'Show Reposts', array($this, 'scepc_show_reposts'), 'scep_customizer', 'soundcloud_embeded_player_options');
	}
	public function soundcloud_embeded_player_options() {
		echo 'Customize Soundcloud player embed for Wrodpress';
	}
	private function is_checked($field, $value) {
		return checked( $field, $value, false );
	}
	private function default_Value($options, $default_value){
		return ( $options || $options == '1' || $options == '0' ? $options : $default_value);
	}
	public function scepc_swap_player() {
		$swap_player = esc_attr( get_option( 'swap_player' ) );
		echo '<input type="checkbox" name="swap_player" value="1" id="swap_player" placeholder="Enable Mini Player" '.$this->is_checked( $swap_player, 1 ).'/>';
	}
	public function scepc_show_artwork() {
		$show_artwork = $this->default_Value(esc_attr( get_option( 'show_artwork' ), '0' ));
		echo '<input type="checkbox" name="show_artwork" value="1" id="show_artwork" placeholder="Show Arework" '.$this->is_checked( $show_artwork, 1 ).'/>';
	}
	public function scepc_play_button_color() {
		$play_button_color = $this->default_Value(esc_attr( get_option( 'play_button_color' ) ), 'FF5500');
		echo '<input type="text" name="play_button_color" value="'.$play_button_color.'" id="play_button_color" placeholder="Play Button Color" class="player_color"/>';
	}
	public function scepc_auto_play() {
		$auto_play = esc_attr( get_option( 'auto_play' ) );
		echo '<input type="checkbox" name="auto_play" value="1" id="auto_play" placeholder="Enable Auto Play" '.$this->is_checked( $auto_play, 1 ).'/>';
	}
	public function scepc_hide_related() {
		$hide_related = $this->default_Value(esc_attr( get_option( 'hide_related' ), '0' ));
		echo '<input type="checkbox" name="hide_related" value="0" id="hide_related" placeholder="Hide Related" '.$this->is_checked( $hide_related, 0 ).'/>';
	}
	public function scepc_show_user() {
		$show_user = $this->default_Value(esc_attr( get_option( 'show_user' ), '1' ));
		echo '<input type="checkbox" name="show_user" value="1" id="show_user" placeholder="Show User" '.$this->is_checked( $show_user, 1 ).'/>';
	}
	public function scepc_show_comments() {
		$show_comments = $this->default_Value(esc_attr( get_option( 'show_comments' ), '1' ));
		echo '<input type="checkbox" name="show_comments" value="1" id="show_comments" placeholder="Show Comments" '.$this->is_checked( $show_comments, 1 ).'/>';
	}
	public function scepc_show_reposts() {
		$show_reposts = $this->default_Value(esc_attr( get_option( 'show_reposts' ), '1' ));
		echo '<input type="checkbox" name="show_reposts" value="1" id="show_reposts" placeholder="Show Repost" '.$this->is_checked( $show_reposts, 1 ).'/>';
	}
	private function aristath_sanitize_hex( $color = '#FF5500', $hash = true ) {
		// Remove any spaces and special characters before and after the string
		$color = trim( $color );
		// Remove any trailing '#' symbols from the color value
		$color = str_replace( '#', '', $color );
		// If the string is 6 characters long then use it in pairs.
		if ( 3 == strlen( $color ) ) {
			$color = substr( $color, 0, 1 ) . substr( $color, 0, 1 ) . substr( $color, 1, 1 ) . substr( $color, 1, 1 ) . substr( $color, 2, 1 ) . substr( $color, 2, 1 );
		}
		$substr = array();
		for ( $i = 0; $i <= 5; $i++ ) {
			$default    = ( 0 == $i ) ? 'F' : ( $substr[$i-1] );
			$substr[$i] = substr( $color, $i, 1 );
			$substr[$i] = ( false === $substr[$i] || ! ctype_xdigit( $substr[$i] ) ) ? $default : $substr[$i];
		}
		$hex = implode( '', $substr );
		return ( ! $hash ) ? $hex : '#' . $hex;
	}
	public function scepc_sanitize_color_handler( $input ){
		$output = sanitize_text_field( $input );
		$output = $this->aristath_sanitize_hex( $output );
		return $output;
	}
	/*public function scepc_sanitize_height_handler( $input ){
		$output = sanitize_text_field( $input );
		$output = str_replace('px', '', $output);
		return $output;
	}*/
	public function scepc_options_page_html() {
		//echo  plugin_dir_path(__FILE__) . 'admin/sc-customizer.php';
		require_once( plugin_dir_path(__FILE__) . 'admin/sc-customizer.php' );
	}
	private function is_options_true($options) {
		return ( $options ==1 ? 'true' : 'false' );
	}
	private function is_options_false($options) {
		return ( $options ==1 ? 'false' : 'true' );
	}
	public function soundcloud_embed($html, $url) {
	  // Only use this filter on Soundcloud embeds
	  if(preg_match("/soundcloud.com/", $url)) {
		$visual				=	$this->is_options_false(get_option( 'swap_player' ));    	// change deafult Soundcloud player on wordpress to the Soundcloud mini player dont touch
		$show_artwork		=	$this->is_options_true(get_option( 'show_artwork' ));    	// change deafult Soundcloud player on wordpress to the Soundcloud mini player dont touch
		$play_button_color 	= 	str_replace( '#', '', $this->default_Value( get_option( 'play_button_color' ), 'FF5500' ) );					// change play button color of the Soundcloud mini player change
		$auto_play			=	$this->is_options_true(get_option( 'auto_play' )); 		// enable autoplay for the Soundcloud mini player dont touch vey anoying 
		$hide_related		=	$this->is_options_true(get_option( 'hide_related' )); 		// hide related for the Soundcloud mini player dont touch
		$show_comments		=	$this->is_options_true(get_option( 'show_comments' ));		// show comments for the Soundcloud mini player dont touch
		$show_user			=	$this->is_options_true(get_option( 'show_user' ));			// show use of of the song for the Soundcloud mini player dont touch
		$show_reposts		=	$this->is_options_true(get_option( 'show_reposts' ));		// show reposts button for the Soundcloud mini player dont touch
		$options 			= 	"&color=".$play_button_color."&auto_play=".$auto_play."&hide_related=".$hide_related."&show_comments=".$show_comments."&show_user=".$show_user."&show_reposts=".$show_reposts.""; 					// all the options for the Soundcloud mini player dont touch
		if($visual == "false"){
			if(preg_match("/playlists/", $html)) {
				// height for playlists mode
				$height = "450";
			}else{
				// height for single mode
				$height = "166";
			}
		}else{
			$height = "450";
		}
		// array of patterns to find in the oembed iframe html
		$patterns = array();
		  $patterns[0] = "/visual=true/"; // true means a big image background
		  $patterns[1] = "/show_artwork=true/"; // true means show the track artwork
		  $patterns[2] = "/ height=\"\d+?\"/"; // height of standard embed is in the 400-pixel range. Just look for any height integer
		  $patterns[3] = "/ width=\"\d+?\"/"; // width of standard embed in Wordpress seems to be a fixed pixel width. Look for any integer
		
		// array of replacements to make for these patterns
		$replacements = array();
		  $replacements[0] = "visual=".$visual.""; // turn off big image background
		  $replacements[1] = "show_artwork=".$show_artwork.$options ; // turn off track artwork
		  $replacements[2] = " height=\"".$height."\""; // set iframe height to 166 pixels, the embed standard for the Soundcloud mini player
		  $replacements[3] = " width=\"100%\""; // set iframe to full width instead of fixed pixel dimension
		
		// prophylactic ksort to make sure that all patterns and replacments will line up regardless of what order they're input
		ksort($patterns);
		ksort($replacements);
		
		// one public function to do all the find and replace
		$html = preg_replace($patterns, $replacements, $html);
		// return the html string and save to database or output
		return $html;
	  }
	  return $html;
	}
// hook into the Wordpress oembed filter
}
if (class_exists('scepc')){
	$scepc = new scepc();
	//add_action( 'admin_menu', array($this, 'scepc_options_page'));
	//add_action( 'admin_enqueue_scripts', array($this, 'wptuts_add_color_picker'));
	//add_action( 'admin_init', array($this, 'scepc_custom_settings'));
	//add_action( 'embed_oembed_html', array($this, 'soundCloud_embed'), 10, 3);
}
