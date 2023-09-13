import '../css/frontend.css';

document.addEventListener('DOMContentLoaded', function() {
    var button = document.getElementById('sftExt-frontend-button');

	if (!!button) {
		button.addEventListener('click', function(e) {
			var newTabUrl = button.dataset.newTab;
			var thisTabUrl = button.dataset.url;

			var win = window.open(newTabUrl, '_blank');
			win.focus();
			window.location.replace(thisTabUrl);
		});
	}
});
