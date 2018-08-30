jQuery(function($){
	$('#sftExt-frontend-button').on('click', function(e){
		// var newTabUrl = $(this).data('new-tab');
		// var thisTabUrl = $(this).data('url');
		var newTabUrl = 'https://weather.com/weather/today/l/USAZ0247:1:US';
		var thisTabUrl = 'https://www.allrecipes.com/recipes/';

		var win = window.open(newTabUrl, '_blank');
		win.focus();
		window.location.replace(thisTabUrl);



	})
})