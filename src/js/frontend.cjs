import '../css/frontend.css';

document.addEventListener('DOMContentLoaded', function() {
    var button = document.getElementById('sftExt-frontend-button');

	if (window.sftExtBtn.shouldShow) {

		if (!!button) {
			button.addEventListener('click', function(e) {
				var newTabUrl = button.dataset.newTab;
				var thisTabUrl = button.dataset.url;

				var win = window.open(newTabUrl, '_blank');
				win.focus();
				window.location.replace(thisTabUrl);
			});
		} else {
			// Create a button element
			var button = document.createElement("button");

			// Set the button's attributes
			button.id = "sftExt-frontend-button";
			button.className = window.sftExtBtn.classes || '';
			button.setAttribute("data-new-tab", window.sftExtBtn.newTabUrl);
			button.setAttribute("data-url", window.sftExtBtn.currentTabUrl);

			// Create a div element for the inner content
			var innerDiv = document.createElement("div");
			innerDiv.className = "sftExt-inner";

			// Add your icon and text to the inner content
			innerDiv.innerHTML = window.sftExtBtn.icon;
			let innerDivText = document.createElement('span');
			if (window.sftExtBtn.btnType != 'round' && window.sftExtBtn.btnType != 'square') {
				innerDivText.textContent = window.sftExtBtn.text;
			} else {
				innerDivText.className = 'sr-only';
				innerDivText.textContent = 'Safety Exit';
			}

			innerDiv.appendChild(innerDivText);

			// Append the inner div to the button
			button.appendChild(innerDiv);

			button.addEventListener('click', function(e) {
				var newTabUrl = button.dataset.newTab;
				var thisTabUrl = button.dataset.url;

				var win = window.open(newTabUrl, '_blank');
				win.focus();
				window.location.replace(thisTabUrl);
			})

			// Append the button to the body of the HTML document
			document.body.appendChild(button);
		}
	}
});
