(function( $ ) {
    // Update the player prview live
    $(function() {
		// list of varable
		var souncloud_players   = $("#souncloud_players");
        var single_player 		= $('#single_player');
		var playlist_player 	= $('#playlist_player');
		var swap_player			= $('#swap_player');
		var show_artwork		= $('#show_artwork');
		var play_button_color	= $('#play_button_color');
		var auto_play			= $('#auto_play');
		var hide_related		= $('#hide_related');
		var show_comments		= $('#show_comments');
		var show_user			= $('#show_user');
		var show_reposts		= $('#show_reposts');
		// Swap Player
		if (swap_player.checked){
			var url = single_player.attr('src').replace( 'visual=true', 'visual=false');
			var url2 = playlist_player.attr('src').replace( 'visual=true', 'visual=false');
			single_player.attr('src',url);
			playlist_player.attr('src',url2);
		}else{
			var url = single_player.attr('src').replace( 'visual=false', 'visual=true');
			var url2 = playlist_player.attr('src').replace( 'visual=false', 'visual=true');
			single_player.attr('src',url);
			playlist_player.attr('src',url2);
		}
		swap_player.click(function(){
			if (this.checked){
				var url = single_player.attr('src').replace( 'visual=true', 'visual=false');
				var url2 = playlist_player.attr('src').replace( 'visual=true', 'visual=false');
				single_player.attr('src',url);
				playlist_player.attr('src',url2);
			}else{
				var url = single_player.attr('src').replace( 'visual=false', 'visual=true');
				var url2 = playlist_player.attr('src').replace( 'visual=false', 'visual=true');
				single_player.attr('src',url);
				playlist_player.attr('src',url2);
			}
		})
		// Toggle Artwork
		show_artwork.click(function(){
			if (!this.checked){
				var url = single_player.attr('src').replace( 'show_artwork=true', 'show_artwork=false');
				var url2 = playlist_player.attr('src').replace( 'show_artwork=true', 'show_artwork=false');
				single_player.attr('src',url);
				playlist_player.attr('src',url2);
			}else{
				var url = single_player.attr('src').replace( 'show_artwork=false', 'show_artwork=true');
				var url2 = playlist_player.attr('src').replace( 'show_artwork=false', 'show_artwork=true');
				single_player.attr('src',url);
				playlist_player.attr('src',url2);
			}
		})
		// Toggle Username
		show_user.click(function(){
			if (!this.checked){
				var url = single_player.attr('src').replace( 'show_user=true', 'show_user=false');
				var url2 = playlist_player.attr('src').replace( 'show_user=true', 'show_user=false');
				single_player.attr('src',url);
				playlist_player.attr('src',url2);
			}else{
				var url = single_player.attr('src').replace( 'show_user=false', 'show_comments=true');
				var url2 = playlist_player.attr('src').replace( 'show_user=false', 'show_user=true');
				single_player.attr('src',url);
				playlist_player.attr('src',url2);
			}
		})
		// Toggle Comments
		show_comments.click(function(){
			if (!this.checked){
				var url = single_player.attr('src').replace( 'show_comments=true', 'show_artwork=false');
				var url2 = playlist_player.attr('src').replace( 'show_comments=true', 'show_comments=false');
				single_player.attr('src',url);
				playlist_player.attr('src',url2);
			}else{
				var url = single_player.attr('src').replace( 'show_comments=false', 'show_comments=true');
				var url2 = playlist_player.attr('src').replace( 'show_comments=false', 'show_comments=true');
				single_player.attr('src',url);
				playlist_player.attr('src',url2);
			}
		})
    });
     
})( jQuery );