<?php
if (!defined('ABSPATH')){
   return;
}

class WP_Soundcloud_Player_Customizer_Settings{
    public function wp_soundcloud_player_customizer_settings_init(){
        add_action( 'customize_register', array( $this, 'wp_soundcloud_player_settings_customizer_settings_panel' ) );
    }

    public function wp_soundcloud_player_settings_customizer_settings_panel($wp_customize){
        // Add a section for Soundcloud player customizer settings
        $wp_customize->add_section('wp_soundcloud_player_customizer', array(
            'title' => __('WP Soundcloud Settings', 'wpscpc'),
            'priority' => 121,
        ));

        // Default values based on SoundCloud's defaults or your preferences
        $default_play_button_color = '#FF9900'; // Use your preferred default color
        $default_swap_player = '1'; // Use '1' for enabling the mini player by default
        $default_show_artwork = '1'; // Use '1' to show artwork by default
        $default_auto_play = '0'; // Use '0' to disable auto play by default
        $default_hide_related = '0'; // Use '0' to show related tracks by default
        $default_show_comments = '0'; // Use '0' to hide comments by default
        $default_show_user = '0'; // Use '0' to hide user information by default
        $default_show_reposts = '0'; // Use '0' to hide reposts by default

        // Add option for play button color
        $wp_customize->add_setting('oesc_play_button_color', array(
            'default' => $default_play_button_color,
            'type' => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'oesc_play_button_color', array(
            'section' => 'wp_soundcloud_player_customizer',
            'label' => __('Play Button Color', 'wpscpc'),
        )));

        // Add option for swap player
        $wp_customize->add_setting('oesc_swap_player', array(
            'default' => $default_swap_player,
            'type' => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
        ));
        $wp_customize->add_control('oesc_swap_player', array(
            'type' => 'checkbox',
            'section' => 'wp_soundcloud_player_customizer',
            'label' => __('Enable Mini Player', 'wpscpc'),
        ));

        // Add option for show artwork
        $wp_customize->add_setting('oesc_show_artwork', array(
            'default' => $default_show_artwork,
            'type' => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
        ));
        $wp_customize->add_control('oesc_show_artwork', array(
            'type' => 'checkbox',
            'section' => 'wp_soundcloud_player_customizer',
            'label' => __('Show Artwork', 'wpscpc'),
        ));

        // Add option for auto play
        $wp_customize->add_setting('oesc_auto_play', array(
            'default' => $default_auto_play,
            'type' => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
        ));
        $wp_customize->add_control('oesc_auto_play', array(
            'type' => 'checkbox',
            'label' => __('Enable Auto Play', 'wpscpc'),
            'section' => 'wp_soundcloud_player_customizer',
        ));

        // Add option for hide related
        $wp_customize->add_setting('oesc_hide_related', array(
            'default' => $default_hide_related,
            'type' => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
        ));
        $wp_customize->add_control('oesc_hide_related', array(
            'type' => 'checkbox',
            'label' => __('Hide Related', 'wpscpc'),
            'section' => 'wp_soundcloud_player_customizer',
        ));

        // Add option for show comments
        $wp_customize->add_setting('oesc_show_comments', array(
            'default' => $default_show_comments,
            'type' => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
        ));
        $wp_customize->add_control('oesc_show_comments', array(
            'type' => 'checkbox',
            'section' => 'wp_soundcloud_player_customizer',
            'label' => __('Show Comments', 'wpscpc'),
        ));

        // Add option for show user
        $wp_customize->add_setting('oesc_show_user', array(
            'default' => $default_show_user,
            'type' => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
        ));
        $wp_customize->add_control('oesc_show_user', array(
            'type' => 'checkbox',
            'section' => 'wp_soundcloud_player_customizer',
            'label' => __('Show User', 'wpscpc'),
        ));

        // Add option for show reposts
        $wp_customize->add_setting('oesc_show_reposts', array(
            'default' => $default_show_reposts,
            'type' => 'option',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_checkbox',
        ));
        $wp_customize->add_control('oesc_show_reposts', array(
            'type' => 'checkbox',
            'section' => 'wp_soundcloud_player_customizer',
            'label' => __('Show Reposts', 'wpscpc'),

        ));

        function sanitize_checkbox($checked){
            return $checked == 1 ? 1 : '';
        }
    }
}

if (class_exists('WP_Soundcloud_Player_Customizer_Settings')){
    $wp_soundcloud_player_customizer_settings = new WP_Soundcloud_Player_Customizer_Settings();
    $wp_soundcloud_player_customizer_settings->wp_soundcloud_player_customizer_settings_init();
}
