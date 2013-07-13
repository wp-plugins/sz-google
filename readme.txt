=== SZ - Google for WordPress ===
Contributors: massimodellarovere,iGenius
Requires at least: 3.5
Tested up to: 3.5
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F6K9EMHKWRFPL
Tags: badge, buttons, comments, comments system, custom url, google, google+, google badge, google buttons, google comments, google community, google custom url, google page, google plus, google profile, google share, google follow, widgets, widgets google, rediretc, sidebar, social network, shortcodes

Plugin to integrate Google's products in WordPress with particular attention for the social network Google+. 

== Description ==
<a href="http://wordpress.org/extend/plugins/sz-google/">English</a> - <a href="http://goo.gl/czjnz">Italiano</a> - <a href="http://goo.gl/Jt0YN">Español</a>

Plugin to integrate Google's products in WordPress with particular attention to the widgets provided by the social network Google+. The Google products are many and so this plugin will be a kind of development "step to step" which will be developed a little bit at a time depending on the availability of time that we can devote. 

To be informed about the features that gradually will be released you can follow this link page <a href="http://startbyzero.com/webmaster/wordpress-plugin/sz-google/">Plugin SZ-Google</a>, which will be a sort of official article where As I integrate the new features released, otherwise you can follow the community of <a href="https://plus.google.com/communities/109254048492234113886">WordPress Italy+</a> where surely will be inserted after the latest that will affect this plugin.

= Widgets available in plugin =
* `Widget for google+ profile badge.`
* `Widget for google+ page badge.`
* `Widget for google+ community badget`
* `Widget for google+ comments system.`

= Shortcodes available in plugin =
* `[sz-gplus-profile]` - insert google+ badge for profile
* `[sz-gplus-page]` - insert google+ badge for business page
* `[sz-gplus-community]` - insert google+ badge for community
* `[sz-gplus-one]` - insert google+ button plus one
* `[sz-gplus-share]` - insert google+ button for sharing
* `[sz-gplus-follow]` - insert google+ button for follow

= Plugin module Google+ =

**Google+ Comments System:** The comment system must be explicitly enabled from the admin panel after installing the plugin. You can replace the current commenting system or integrate it with the existing getting a double system. You can choose the position of the new widget comments, wishing you can also insert into a sidebar using the dedicated widget. At the commenting system has been added to the reference date for activation, for example, if someone has the need to maintain the old system to the old posts and activate it only for new ones can enter a date for when the new system is only activated if the date of the post and greater than or equal to this date.

**Google+ Custom URL:** It is already some time that Google has released the function of custom URLs for pages and profiles, however, the majority of profiles and pages can not yet take advantage of this possibility. So in the plugin-google sz we added this feature to be able to generate custom links such as domino.com/+ or dominio.com/plus.

= Functions in the plugin to use in the themes  =
**<a href="http://wordpress.org/plugins/sz-google/"> </a>**

* `szgoogle_get_gplus_badge_profile()`
* `szgoogle_get_gplus_badge_page()`
* `szgoogle_get_gplus_badge_community()`
* `szgoogle_get_gplus_button_one()`
* `szgoogle_get_gplus_button_share()`
* `szgoogle_get_gplus_button_follow()`
* `szgoogle_get_gplus_comments()`

`<?php echo szgoogle_get_gplus_button_follow(); ?>`

= Plugin and general performance =
Given that in the plugin will be implemented different function that will not be used in most of the times all together, the plugin has been written with a technique of "separate modules" in such a way to load the code only if the administration panel is activated explicitly requested function. For this reason, activated only the functions you use.

== Installation ==

<a href="http://wordpress.org/plugins/sz-google/installation/">English</a> - <a href="http://goo.gl/dBkcS">Italiano</a> - <a href="http://goo.gl/BbxQa">Español</a>

= Automatic installation =
1. Administration Panel plugins and option `add new`.
2. Search text box `sz-google`.
3. Placed on the description of this plugin and select install.
4. Activate the plugin from the admin panel of WordPress.

= Manually installing from ZIP file =
1. Download the ZIP file from this screen.
2. Select option add plugin from the admin panel.
3. Select top option `upload` and select the file you downloaded.
4. Confirm installation and activation plugin from the admin panel.

= Manually installing from FTP =
1. Download the ZIP file from this screen and unzip.
2. Sign in to your FTP folder on the web server.
3. Copy the entire folder `sz-google` in directory `/wp-content/plugins/`
4. Activate the plugin from the admin panel of WordPress.

== Frequently Asked Questions ==

<a href="http://wordpress.org/plugins/sz-google/faq/">English</a> - <a href="http://goo.gl/2co5W">Italiano</a> - <a href="http://goo.gl/SJIhR">Español</a>

= You can see a demo before the installation? =
Yes, we have made available demonstration of the pages where the plugin installed to view the latest version of WordPress available at the moment. You can visit the page <a href="https://startbyzero.com/demos/wordpress/plugin-google/">SZ-Google Demo</a>.

== Screenshots ==

== Changelog ==

<a href="http://wordpress.org/plugins/sz-google/changelog/">English</a> - <a href="http://translate.google.com/translate?hl=it&sl=en&tl=it&u=http%3A%2F%2Fwordpress.org%2Fplugins%2Fsz-google%2Fchangelog%2F">Italiano</a> - <a href="http://translate.google.com/translate?hl=it&sl=en&tl=es&u=http%3A%2F%2Fwordpress.org%2Fplugins%2Fsz-google%2Fchangelog%2F">Español</a>

= Version 0.2 =
* Feature: Add Google+ shortcode button plus one.
* Feature: Add Google+ shortcode button share.
* Feature: Add Google+ shortcode button follow.
* Feature: Add Google+ custom URL redirect.
* Feature: Add Google+ select language widgets.

= Version 0.1 =
* Feature: First version of the plugin and initial functions.
* Feature: Add Google+ shortcode badges profile.
* Feature: Add Google+ shortcode badges page.
* Feature: Add Google+ shortcode badges community.
* Feature: Add Google+ widget badge profile.
* Feature: Add Google+ widget badge business page.
* Feature: Add Google+ widget badge community.
* Feature: Add Google+ comments system.

== Upgrade Notice ==

= 0.1 =
Release of the first version of the plugin sz-google intergrazione with the widgets that relate to the social network google plus to include on your wordpress sidebar.
