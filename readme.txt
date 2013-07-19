=== SZ - Google for WordPress ===
Contributors: massimodellarovere,iGenius
Requires at least: 3.5
Tested up to: 3.5
Stable tag: 0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F6K9EMHKWRFPL
Tags: analytics, badge, buttons, comments, comments system, custom url, follow, google, google+, google analytics, google+ badge, google+ buttons, google+ comments, google+ community, google+ custom url, google+ page, google plus, google+ profile, google+ share, google+ follow, post sharing, post comments, widgets, widgets google+, redirect, sidebar, share, social network, shortcodes

Plugin to integrate Google's products in WordPress with particular attention for the social network Google+. 

== Description ==
<a href="http://wordpress.org/extend/plugins/sz-google/">English</a> - <a href="http://goo.gl/czjnz">Italiano</a> - <a href="http://goo.gl/Jt0YN">Español</a> - <a href="http://goo.gl/jnxWm">Français</a> - <a href="http://goo.gl/eXk1j">Deutsch</a>

Plugin to integrate Google's products in WordPress with particular attention to the widgets provided by the social network Google+. The Google products are many and so this plugin will be a kind of development "step to step" which will be developed a little bit at a time depending on the availability of time that we can devote. In any case, we will always be willing to consider new requests for anyone who wants to ask for a new feature to be developed in the plugin. Write all your requests on our <a href="https://plus.google.com/communities/109254048492234113886">official page</a>.

To be informed about the features that gradually will be released you can follow this link page <a href="http://startbyzero.com/webmaster/wordpress-plugin/sz-google/">Plugin SZ-Google</a>, which will be a sort of official article where as I integrate the new features released, otherwise you can follow the community of <a href="https://plus.google.com/communities/109254048492234113886">WordPress Italy+</a> where surely will be included the latest news that will affect this plugin. The plugin sz-google contain several modules, we recommend you activate from the admin panel only the functions that you will use and do not use unnecessary memory resources.

= Modules available in plugin =
**<a href="http://wordpress.org/plugins/sz-google/"> </a>**

* `Module Google+`
* `Module Google Analytics`

= Google+ social network module =
**<a href="http://wordpress.org/plugins/sz-google/"> </a>**

**Google+ Badge:** With this plugin can be inserted in your blog most of the badges available to google for its social network, for example, we can use the badge for profiles, one for the pages or the one dedicated to the community. These components can be used as a widget for use in or as a sidebar and as shortcode to use in the articles. You can also use the php functions to customize your own theme directly with programming code.

**Google+ Custom URL:** It is already some time that Google has released the function of custom URLs for pages and profiles, however, the majority of profiles and pages can not yet take advantage of this possibility. So in the plugin-google sz we added this feature to be able to generate custom links such as domino.com/+ or dominio.com/plus.

**Google+ Comments System:** The comment system must be explicitly enabled from the admin panel after installing the plugin. You can replace the current commenting system or integrate it with the existing getting a double system. You can choose the position of the new widget comments, wishing you can also insert into a sidebar using the dedicated widget. At the commenting system has been added to the reference date for activation, for example, if someone has the need to maintain the old system to the old posts and activate it only for new ones can enter a date for when the new system is only activated if the date of the post and greater than or equal to this date.

**Google+ Widgets:** In this plugin are available to google+ widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget google+ profile badge`
* `Widget google+ page badge`
* `Widget google+ community badget`
* `Widget google+ comments system`

**Google+ Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google+ in a post or on a page in wordpress. Each has shortocode of customization parameters that can be specified in the code itself, to know all the parameters available to read the <a href="http://startbyzero.com/webmaster/plugin-sz-google-per-wordpress-e-modulo-google/">official documentation</a>.

* `[sz-gplus-profile] ..: g+ badge for profile`
* `[sz-gplus-page] .....: g+ badge for business page`
* `[sz-gplus-community] : g+ badge for community`
* `[sz-gplus-one] ......: g+ button plus one`
* `[sz-gplus-share] ....: g+ button for sharing`
* `[sz-gplus-follow] ...: g+ button for follow`

**Google+ Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not eguono a predefined standard.

* `szgoogle_get_gplus_badge_profile()`
* `szgoogle_get_gplus_badge_page()`
* `szgoogle_get_gplus_badge_community()`
* `szgoogle_get_gplus_button_one()`
* `szgoogle_get_gplus_button_share()`
* `szgoogle_get_gplus_button_follow()`
* `szgoogle_get_gplus_comments()`

`<?php echo szgoogle_get_gplus_button_follow(); ?>`

= Plugin and general performance =
**<a href="http://wordpress.org/plugins/sz-google/"> </a>**

Given that in the plugin will be implemented different function that will not be used in most of the times all together, the plugin has been written with a technique of "separate modules" in such a way to load the code only if the administration panel is activated explicitly requested function. For this reason, activated only the functions you use.

== Installation ==

<a href="http://wordpress.org/plugins/sz-google/installation/">English</a> - <a href="http://goo.gl/dBkcS">Italiano</a> - <a href="http://goo.gl/BbxQa">Español</a> - <a href="http://goo.gl/K6yRB">Français</a> - <a href="http://goo.gl/uSoJ1">Deutsch</a>

= Automatic installation =
**<a href="http://wordpress.org/plugins/sz-google/"> </a>**

1. Administration Panel plugins and option `add new`.
2. Search text box `sz-google`.
3. Placed on the description of this plugin and select install.
4. Activate the plugin from the admin panel of WordPress.

= Manually installing from ZIP file =
**<a href="http://wordpress.org/plugins/sz-google/"> </a>**

1. Download the ZIP file from this screen.
2. Select option add plugin from the admin panel.
3. Select top option `upload` and select the file you downloaded.
4. Confirm installation and activation plugin from the admin panel.

= Manually installing from FTP =
**<a href="http://wordpress.org/plugins/sz-google/"> </a>**

1. Download the ZIP file from this screen and unzip.
2. Sign in to your FTP folder on the web server.
3. Copy the entire folder `sz-google` in directory `/wp-content/plugins/`
4. Activate the plugin from the admin panel of WordPress.

= Troubleshoot problems during installation =
**<a href="http://wordpress.org/plugins/sz-google/"> </a>**

If you have problems during the installation of this plugin please contact us directly in the support forum on wordpress or post your problem on our community <a href="https://plus.google.com/communities/109254048492234113886">WordPress Italy+</a>. Remember to specify exactly the problem, the version of the plugin that use for installing or updating, the version of wordpress and uses the operating system that manages the site hosting. If you have problems of conflict with other plugins give as much information as possible so you can run a debug trace and find the problem.

== Frequently Asked Questions ==

<a href="http://wordpress.org/plugins/sz-google/faq/">English</a> - <a href="http://goo.gl/2co5W">Italiano</a> - <a href="http://goo.gl/SJIhR">Español</a> - <a href="http://goo.gl/hDYgZ">Français</a> - <a href="http://goo.gl/wz6ZV">Deutsch</a>

= You can see a demo before the installation? =
Yes, we have made available demonstration of the pages where the plugin installed to view the latest version of WordPress available at the moment. You can visit the specific web page <a href="https://startbyzero.com/demos/wordpress/plugin-google/">SZ-Google Demo</a> to display many components in live demo.

= You can use the functions of the plugin with PHP? =
Yes, many operations of the plugin are also accessible via the specific functions to be called in your PHP program, so you can customize a wordpress theme using only the code. To know the list of functions provided by the plugin read the official documentation.

== Screenshots ==.

1. Plugin SZ-Google and administration panel
2. Google+ social network module

== Changelog ==

<a href="http://wordpress.org/plugins/sz-google/changelog/">English</a> - <a href="http://goo.gl/jMOcQ">Italiano</a> - <a href="http://goo.gl/6G8dH">Español</a> - <a href="http://goo.gl/WwtPs">Français</a> - <a href="http://goo.gl/VHbwt">Deutsch</a>

= Version 0.4 =
* Fix: Function sortables for admin panel and plugin options.
* Feature: Add option for remove google analytics if administrator.
* Feature: Add option for remove google analytics if user logged.

= Version 0.3 =
* Feature: Add Google+ switch for loading javascript code.
* Feature: Add stylesheet for personalized admin panel.
* Feature: Add module for Google Analytics.
* Feature: Add sidebar in admin panel for link about plugin.
* Feature: Remove code Analytics for admin area.

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

= 0.4 =
This release has been issued for the fixes small bugs and adding new parameters regarding google analytics. Have been improved on some aspects the badges for google plus.

= 0.3 =
Some changes to the first release, added a stylesheet for the admin panel and the ability to disable javascript to google+ so as to avoid conflicts with other social plugins.

= 0.2 =
Have been added new features that relate to the social buttons and operations redirects as custom URL google+. We have also released some PHP functions that can be used in the development of the themes.

= 0.1 =
Release of the first version of the plugin sz-google intergrazione with the widgets that relate to the social network google plus to include on your wordpress sidebar.
