(function( $ ) {
 
    // Add Color Picker to all inputs that have 'color-field' class
	var myOptions = {
    // you can declare a default color here,
    // or in the data-default-color attribute on the input
    defaultColor: "#ff5500",
    // a callback to fire whenever the color changes to a valid color
    change: function(event, ui){},
    // a callback to fire when the input is emptied or an invalid color
    clear: function() {},
    // hide the color picker controls on load
    hide: true,	
	// The default width of the color picker 
	width: 250,
    // show a group of common colors beneath the square
    // or, supply an array of colors to customize further
    palettes: ['#ff5500','#0066cc','#00aabb','#00cc11','#ff9900']
	};
    $(function() {
        $('#play_button_color').wpColorPicker(myOptions);
    });
     
})( jQuery );