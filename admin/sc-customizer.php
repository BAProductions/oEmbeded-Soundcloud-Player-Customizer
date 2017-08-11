<div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title())?></h1>
  <?php settings_errors(); ?>
  <form method="post" action="options.php" id="souncloud_players_customizer_form">
    <table class="form-table">
      <?php 
        settings_fields( 'scec_settings_group' ); // This will output the nonce, action, and option_page fields for a settings page.
        do_settings_sections( 'sce_customizer' ); // This prints out the actual sections containing the settings fields for the page in parameter 
        ?>
      <?php submit_button(); ?>
    </table>
  </form>
  <h2>Live Pewview of Soundcloud embedded in wordpress</h2>
  <?php 
  	$visual				=	is_options_true(get_option( 'swap_player' ));    	// change deafult Soundcloud player on wordpress to the Soundcloud mini player dont touch
	$show_artwork		=	is_options_true(get_option( 'show_artwork' ));    	// change deafult Soundcloud player on wordpress to the Soundcloud mini player dont touch
	$play_button_color 	= 	$output = str_replace( '#', '', get_option( 'play_button_color' ));					// change play button color of the Soundcloud mini player change
	$auto_play			=	is_options_true(get_option( 'auto_play' )); 		// enable autoplay for the Soundcloud mini player dont touch vey anoying 
    $hide_related		=	is_options_true(get_option( 'hide_related' )); 		// hide related for the Soundcloud mini player dont touch
	$show_comments		=	is_options_true(get_option( 'show_comments' ));		// show comments for the Soundcloud mini player dont touch
	$show_user			=	is_options_true(get_option( 'show_user' ));			// show use of of the song for the Soundcloud mini player dont touch
	$show_reposts		=	is_options_true(get_option( 'show_reposts' ));		// show reposts button for the Soundcloud mini player dont touch
	$options 			= 	"&visual=".$visual."&show_artwork=".$show_artwork."&color=".$play_button_color."&auto_play=".$auto_play."&hide_related=".$hide_related."&show_comments=". $show_comments."&show_user=".$show_user."&show_reposts=".$show_reposts.""; 					// all the options for the Soundcloud mini player dont touch?>
  <table id="souncloud_players" width="50%">
    <tbody>
      <tr>
        <td align="left" scope="headder">Soundcloud player</td>
      </tr>
      <tr>
        <td scope="row"><iframe id="single_player" width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/294111720<?php echo $options ?>"></iframe></td>
      </tr>
      <tr>
        <td align="left" scope="headder">Soundcloud playlist player</td>
      </tr>
      <tr>
        <td scope="row"><iframe id="playlist_player" width="100%" height="300" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/106336464<?php echo $options ?>"></iframe></td>
      </tr>
    </tbody>
  </table>
</div>
