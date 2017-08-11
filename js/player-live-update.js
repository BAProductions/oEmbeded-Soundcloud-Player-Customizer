(function( $ ) {
 	$.fn.is_true = function() {
		var is_checked 	= '';
		var id  		= '#'+this.prop('id');
		//this.change(function(that){
			is_checked = ($(id).is(':checked') ? 'true' : 'false' );
		//});
		return is_checked;
	}
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
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
    });
     
})( jQuery );