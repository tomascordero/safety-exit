=== Safety Exit ===
Contributors: tcordero
Tags: quick exit, safety exit, stop abuse, no domestic violence, safe browsing, exit, fast exit, domestic violence, panic button
Donate link: https://tomascordero.com
Requires at least: 5.2.0
Tested up to: 6.1
Requires PHP: 5.2.4
Stable tag: 1.6.1
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A button to allow for a quick exit on websites dealing with sensitive content such as Domestic Violence.

== Description ==
This plugin will insert a safety exit button onto your site. A safety exit button is ideal for websites dealing with sensitive subjects such as domestic violence, rape, child abuse and others. When the user clicks the button they will instantly redirected to a URL of your choosing and a new tab / window will be opened to a URL of your choosing.

The button is customizable with options to change the color of the button and font, pick an icon from fontawesome's free icon library, update font size, change what the button says and more features coming in the future. You can see the roadmap here: [Roadmap](https://trello.com/b/Zp7oBfQz/safety-exit)


== Installation ==
1. Search for 'Safety Exit' in the plugin directory
2. Click install then Activate.
OR to install manually
1. Download the plugin
2. Upload `safety-exit.zip` to the `wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

Once installed and activated you will see a new menu item for "Safety Exit". That is where you can customize the button.

== Frequently Asked Questions ==

= Is there an option to delete the browser history? =
No. Due to security measures taken by browsers, websites can not delete browser history. If this ever changes or if browsers support a new function that will let websites control history you can expect it to be added to the plugin ASAP.

= Can I request features? =
Yes! I love feature ideas and requests to make this thing better. You can submit a feature request under the support tab. Check out the roadmap here: [Roadmap](https://trello.com/b/Zp7oBfQz/safety-exit)

= Can I customize the button more than the options you gave me? =
You can! If you know some CSS you can insert custom CSS and target \"#sftExt-frontend-button\". In the future there are plans to add support for custom HTML and CSS as well as more options to tweak the button more.

= Why cant I put the button in the menu or at the top of the page? =
Currently there are only two options for button placement. \"Bottom Left\" and \"Bottom Right\". There are plans to add support for other button placement options such as in the menu, as a widget, a banner at the top of the page, and more.


== Screenshots ==
1. Button floats in bottom corner of screen
2. Back end configuration of the button

== Changelog ==
1.6.1:
	- Tweak: Switched from injecting the button in the footer to injecting it to the wp_body_open. This fixes a bug with certain page builders that use a post / page to create the footer.
1.6.0:
	- Improved: Stopped font awesome from loading on frontend if icon is turned off
1.5.0:
	- New: Added the ability to hide the button on mobile.
1.4.5:
	- Maintenance: Ensured plugin worked with latest version of Wordpress
1.4.4:
	- Fixed: Merged PR#1 to add support for bedrock hosted Wordpress sites.
1.4.3:
	- Fixed: Added quick test to ensure required core files exist. If the test fails it wont initialize the plugin.
1.4.2:
	- Fixed: Updated CSS for round and square buttons to center icon.
	- Fixed: Removed random options file that was hanging up server cron jobs.
	- Improved: Added some needed security to protect agains attacks.
1.4.1:
	- Fixed: Hot fix for the page selection tool
1.4.0:
	- New: Added ability to show safety button on all pages or specific page.
1.2.2:
	- Tweak: Updated Read Me to include new tags and include a road map
1.2.1:
	- Fixed: removed debug bug
1.2.0:
	- New: Added option to change border radius on the rectangle.
	- New: Added option for square button
	- Tweak: Moved the settings link to the main menu and out from under the settings tab. This should make it easier to find.
	- Fixed: The round button had a bug where it wouldnt display the icon correctly. That is fixed and should display correctly
1.1.3:
	- Tweak: Made it so you arent forced to have all uppercase text. Now to control the font capitalization you just type the word with the capitalization you want to be displayed
1.0.3:
	- Fixed: 404s on frontend
1.0.2:
	- Removed: Menu option for now (not ready for prod)
1.0.0:
	- Fist release
