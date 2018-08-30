jQuery(function($){
	$('#sftExt-frontend-button').on('click', function(e){
		var newTabUrl = $(this).data('new-tab');
		var thisTabUrl = $(this).data('url');

		var win = window.open(newTabUrl, '_blank');
		win.focus();
		window.location.replace(thisTabUrl);

	})
})