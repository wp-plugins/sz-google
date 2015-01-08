=== SZ - Google for WordPress ===
Contributors: massimodellarovere,iGenius
Requires at least: 3.5
Tested up to: 4.1
Stable tag: 1.8.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: http://goo.gl/LNgg9T
Tags: analytics, authenticator, badge, buttons, calendar, comments, comments system, custom url, drive, embed video, embed playlist, embedded posts, follow, google, google+, google analytics, google authenticator, google analytics universal, google author, google calendar, google drive, google maps, google publisher, google translate, google+ badge, google+ buttons, google+ comments, google+ community, google+ custom url, google+ embedded posts, google+ follow, google groups, google hangouts, google+ page, google plus, google+ profile, google+ share, groups, groups embed, hangouts, HOA, playlist, post sharing, post comments, widgets, widgets google+, widget translate, recommendations mobile, redirect, save to drive, sidebar, share, social network, shortcodes, translate, universal analytics, youtube, youtube embed, youtube playlist, video, video youtube

Plugin to integrate Google's products in WordPress with particular attention for the social network Google+. 

== Description ==
<a href="http://goo.gl/ePm7Tw">English</a> - 
<a href="http://goo.gl/czjnz">Italiano</a> - 
<a href="http://goo.gl/Jt0YN">Español</a> - 
<a href="http://goo.gl/jnxWm">Français</a> - 
<a href="http://goo.gl/eXk1j">Deutsch</a>

Plugin to integrate Google's products in WordPress with particular attention to the widgets provided by the social network Google+. The Google products are many and so this plugin will be a kind of development "step to step" which will be developed a little bit at a time depending on the availability of time that we can devote.

* <a href="http://goo.gl/vxNRF4">(IT) - Documentazione in Italiano</a>

= Modules available in plugin =
**<a href="http://goo.gl/6bzDMO"> </a>**

* `Module Google+`
* `Module Google Analytics`
* `Module Google Authenticator`
* `Module Google Calendar`
* `Module Google Drive`
* `Module Google Fonts`
* `Module Google Groups`
* `Module Google Hangouts`
* `Module Google Panoramio`
* `Module Google Translate`
* `Module Google Youtube`
* `Module Documentation`

= Google+ social network module =
**<a href="http://goo.gl/6bzDMO"> </a>**

**Google+ Badges:** With this plugin can be inserted in your blog most of the badges available to google for its social network, for example, we can use the badge for profiles, one for the pages or the one dedicated to the community. These components can be used as a widget for use in or as a sidebar and as shortcode to use in the articles. You can also use the php functions to customize your own theme directly with programming code.

**Google+ Buttons:** The plugin also provides many social buttons, such as +1 button, share button and follow. You can also use the input buttons as simple badge and  associated with a text or an image. as for the other components you can use these functions with the shortcodes that with widgets in the admin panel.

**Google+ Comments System:** The comment system must be explicitly enabled from the admin panel after installing the plugin. You can replace the current commenting system or integrate it with the existing getting a double system. You can choose the position of the new widget comments, wishing you can also insert into a sidebar using the widget.

**Google+ Custom URL:** It is already some time that Google has released the function of custom URLs for pages and profiles, however, the majority of profiles and pages can not yet take advantage of this possibility. So in the plugin-google sz we added this feature to be able to generate custom links such as domino.com/+ or dominio.com/plus.

**Google+ Embedded Posts:** With this function we can put in our post a simple widget that shows in full a post this on google plus, as well as the contents will be inserted also the buttons to perform social actions, all of this while remaining on its website, and without leaving the web page.Through its widget you can use to insert also a sidebar.

**Google+ HEAD section:** With this function you can insert in the HEAD section of your web page the code necessary for parameters rel=author and rel=publisher. The code about publisher is added automatically by the function of recommendation mobile.

**Google+ Widgets:** In this plugin are available to google+ widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget google+ author`
* `Widget google+ comments system`
* `Widget google+ community`
* `Widget google+ follow`
* `Widget google+ followers`
* `Widget google+ page`
* `Widget google+ embedded posts`
* `Widget google+ profile`
* `Widget google+ plus one`
* `Widget google+ share`

**Google+ Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google+ in a post or on a page in wordpress. Each has shortcode of customization parameters that can be specified in the code itself.

* `[sz-gplus-author] . .: g+ author`
* `[sz-gplus-comments] .: g+ comments system`
* `[sz-gplus-community] : g+ community`
* `[sz-gplus-follow] ...: g+ follow`
* `[sz-gplus-followers] : g+ followers`
* `[sz-gplus-page] .....: g+ page`
* `[sz-gplus-post]......: g+ embedded posts`
* `[sz-gplus-profile] ..: g+ profile`
* `[sz-gplus-one] ......: g+ plus one`
* `[sz-gplus-share] ....: g+ share`

**Google+ Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_gplus_get_badge_author()`
* `szgoogle_gplus_get_badge_profile()`
* `szgoogle_gplus_get_badge_page()`
* `szgoogle_gplus_get_badge_community()`
* `szgoogle_gplus_get_badge_followers()`
* `szgoogle_gplus_get_button_one()`
* `szgoogle_gplus_get_button_share()`
* `szgoogle_gplus_get_button_follow()`
* `szgoogle_gplus_get_comments()`
* `szgoogle_gplus_get_contact_page()`
* `szgoogle_gplus_get_contact_community()`
* `szgoogle_gplus_get_contact_bestpost()`
* `szgoogle_gplus_get_post()`

= Google Analytics module =
**<a href="http://goo.gl/6bzDMO"> </a>**

**Generate code:** Once activated the module from the admin panel and entered your code UA, plugin will insert on your web page code needed to google analytics to generate statistics access your website. You can choose to hide the code when using the administration panel, or when a user is connected.

* `Google analytics classic and universal.`
* `Google analytics enable frontend.`
* `Google analytics enable admin panel.`
* `Google analytics enable administrator.`
* `Google analytics enable user logged.`
* `Google analytics enable tracking subdomains.`
* `Google analytics enable multiple top domains.`
* `Google analytics enable advertiser.`

**Position code:** To insert the code you can choose the header of the web page (the recommended one) or footer, but if you want to customize the position used manual entry and enter the function `szgoogle_analytics_get_code()` in your theme manually.

**Google Analytics Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard. Code is disabled by default for users connected.

* `szgoogle_analytics_get_ID()`
* `szgoogle_analytics_get_code()`

= Google Authenticator module =
**<a href="http://goo.gl/6bzDMO"> </a>**

**Google Authenticator:** The plugin provides the authorization process in two phases designed by google authenticator, it is possible to 
strengthen the security of our login screen asking for a code-time in addition to the normal credentials. This is made ​​possible by 
the Google Authenticator that you can install on our smartphones whether it's an iphone, android or blackberry. As we will see below 
the configuration and synchronization of the key will be performed quickly and easily using a code QR Code to display on your device.

**Google Authenticator Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_authenticator_check_emergency()`
* `szgoogle_authenticator_create_secret()`
* `szgoogle_authenticator_create_secret_backup()`
* `szgoogle_authenticator_get_secret()`
* `szgoogle_authenticator_get_login_field()`
* `szgoogle_authenticator_verify_code()`

= Google Calendar =
**<a href="http://goo.gl/6bzDMO"> </a>**

**Google Calendar Widgets:** In this plugin are available google calendar widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget google calendar`

**Google Calendar Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google groups in a post or on a page in wordpress. Each has shortcode of customization parameters that can be specified in the code itself.

* `[sz-calendar].....: googe calendar embed`

**Google Calendar Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_calendar_get_widget()`

= Google Drive module =
**<a href="http://goo.gl/6bzDMO"> </a>**

**Google Drive Widgets:** In this plugin are available google groups widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget google drive embed`
* `Widget google drive viewer`
* `Widget google drive for button save`

**Google Drive Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google groups in a post or on a page in wordpress. Each has shortcode of customization parameters that can be specified in the code itself.

* `[sz-drive-embed].....: googe drive embed`
* `[sz-drive-viewer]....: googe drive viewer`
* `[sz-drive-save]......: googe drive save button`

**Google Drive Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_drive_get_embed()`
* `szgoogle_drive_get_viewer()`
* `szgoogle_drive_get_savebutton()`

= Google Groups module =
**<a href="http://goo.gl/6bzDMO"> </a>**

**Google Groups Widgets:** In this plugin are available google groups widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget google groups embed`

**Google Groups Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google groups in a post or on a page in wordpress. Each has shortcode of customization parameters that can be specified in the code itself.

* `[sz-ggroups] ........: google translate widget`

**Google Groups Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_groups_get_code()`

= Google Hangouts module =
**<a href="http://goo.gl/6bzDMO"> </a>**

**Google Hangouts:** In this plugin are available google hangouts widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget hangouts with starter button`

**Google Hangouts Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google hangouts in a post or on a page in wordpress. Each has shortcode of customization parameters that can be specified in the code itself.

* `[sz-hangouts-start] .: google hangouts starter button`

**Google Hangouts Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_hangouts_get_code_start()`

= Google Panoramio module =
**<a href="http://goo.gl/6bzDMO"> </a>**

With this module you can insert widgets with photo galleries present on panoramio. You can select photos by user, group or tag. You can choose between different display layouts as photo, slideshow, list and photo_list with navigation menu.

**Google Panoramio Widgets:** In this plugin are available to google panoramio widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget google panoramio`

**Google Panoramio Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google translate in a post or on a page in wordpress. Each has shortcode of customization parameters that can be specified in the code itself.

* `[sz-panoramio] ......: google panoramio photo widget`

**Google Panoramio Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_panoramio_get_code()`

= Google Translate module =
**<a href="http://goo.gl/6bzDMO"> </a>**

**Google Translate Widgets:** In this plugin are available to google translate widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget google translate tools`

**Google Translate Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google translate in a post or on a page in wordpress. Each has shortcode of customization parameters that can be specified in the code itself.

* `[sz-gtranslate] .....: google translate widget`

**Google Translate Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_translate_get_code()`
* `szgoogle_translate_get_meta()`
* `szgoogle_translate_get_meta_ID()`

= Google Youtube module =
**<a href="http://goo.gl/6bzDMO"> </a>**

With this module you can insert into a wordpress page a video on youtube. you can customize many parameters and integrating different modes of insertion, you can choose the theme, set parameters such as autoplay, loop and fullscreen, you can attivae the beneficiaries of google Analytis for the actions that are performed on the video embed.

**Google Youtube Shortcodes:** The shortcode made ​​available to allow the insertion of the components of google translate in a post or on a page in wordpress. Each has shortcode of customization parameters that can be specified in the code itself.

* `[sz-ytvideo] ........: embed youtube video`
* `[sz-ytplaylist] .....: embed youtube playlist`
* `[sz-ytbadge] ........: embed youtube badge`
* `[sz-ytlink] .........: embed youtube link`
* `[sz-ytbutton] .......: embed youtube button`

**Google Youtube Widgets:** In this plugin are available to google youtube widgets that can be directly inserted on the sidebar of your website. All the configuration parameters can be found on the widget itself after you dragged to the sidebar that interests you.

* `Widget embed youtube video`
* `Widget embed youtube playlist`
* `Widget embed youtube badge`
* `Widget embed youtube link`
* `Widget embed youtube button`

**Google Youtube Functions:** The functions unlike the other components can be used for programming in PHP and allow customization of themes and decide the placements details that do not perform a predefined standard.

* `szgoogle_youtube_get_code_video()`
* `szgoogle_youtube_get_code_playlist()`
* `szgoogle_youtube_get_code_badge()`
* `szgoogle_youtube_get_code_link()`
* `szgoogle_youtube_get_code_button()`

= Plugin and general performance =
**<a href="http://goo.gl/6bzDMO"> </a>**

Given that in the plugin will be implemented different function that will not be used in most of the times all together, the plugin has been written with a technique of "separate modules" in such a way to load the code only if the administration panel is activated explicitly requested function. For this reason, activated only the functions you use.

== Installation ==

<a href="http://goo.gl/epQDRe">English</a> - 
<a href="http://goo.gl/dBkcS">Italiano</a> - 
<a href="http://goo.gl/BbxQa">Español</a> - 
<a href="http://goo.gl/K6yRB">Français</a> - 
<a href="http://goo.gl/uSoJ1">Deutsch</a>

= Automatic installation =
**<a href="http://goo.gl/6bzDMO"> </a>**

1. Administration Panel plugins and option `add new`.
2. Search text box `sz-google`.
3. Placed on the description of this plugin and select install.
4. Activate the plugin from the admin panel of WordPress.

= Manually installing from ZIP file =
**<a href="http://goo.gl/6bzDMO"> </a>**

1. Download the ZIP file from this screen.
2. Select option add plugin from the admin panel.
3. Select top option `upload` and select the file you downloaded.
4. Confirm installation and activation plugin from the admin panel.

= Manually installing from FTP =
**<a href="http://goo.gl/6bzDMO"> </a>**

1. Download the ZIP file from this screen and unzip.
2. Sign in to your FTP folder on the web server.
3. Copy the entire folder `sz-google` in directory `/wp-content/plugins/`
4. Activate the plugin from the admin panel of WordPress.

= Troubleshoot problems during installation =
**<a href="http://goo.gl/6bzDMO"> </a>**

If you have problems during the installation of this plugin please contact us directly in the support forum on wordpress or post your problem on our community <a href="https://plus.google.com/communities/109254048492234113886">WordPress Italy+</a>. Remember to specify exactly the problem, the version of the plugin that use for installing or updating, the version of wordpress and uses the operating system that manages the site hosting. If you have problems of conflict with other plugins give as much information as possible so you can run a trace and find the problem.

== Frequently Asked Questions ==

<a href="http://goo.gl/9Ttqly">English</a> - 
<a href="http://goo.gl/2co5W">Italiano</a> - 
<a href="http://goo.gl/SJIhR">Español</a> - 
<a href="http://goo.gl/hDYgZ">Français</a> - 
<a href="http://goo.gl/wz6ZV">Deutsch</a>

= You can see a demo before the installation? =
Yes, we have made available demonstration of the pages where the plugin installed to view the latest version of WordPress available at the moment. You can visit the specific web page <a href="http://goo.gl/oRoahu">SZ-Google Demo</a> to display many components in live demo.

= All these functions in a single plugin affect performance? =
The plugin was written in separate modules that are activated only on request. This allows saving both memory of CPU, obviously if all functions are activated the plugin needs resources, however senpre less than installing a high number of different plugins.

= Can I ask for the implementation of a new product google? =
We take into consideration qualsiaqsi request is made by the community, of course, if a product is requested several times by diffrenti people will do anything to aqggiungerlo to our plugins. Write request in the forum or in the <a href="https://plus.google.com/communities/109254048492234113886">community</a>.

= You can use the functions of the plugin with PHP? =
Yes, many operations of the plugin are also accessible via the specific functions to be called in your PHP program, so you can customize a wordpress theme using only the code. To know the list of functions provided by the plugin read the <a href="http://goo.gl/oRoahu">official documentation</a>.

= How to find the code meta google translate? =
Before you use the google translate module must register the site that you want to manage on their google account using the following official link <a href="https://translate.google.com/manager/website/">Google Translate Tools</a>. Once inserit your site to perform the action "get code", display meta code and insert this in the field.

== Screenshots ==

1. SZ-Google and administration panel
2. SZ-Google and module Google+
3. SZ-Google and module Google+ example
4. SZ-Google and module Youtube
5. SZ-Google and documentation
6. SZ-Google and module Google Drive
7. SZ-Google and module Panoramio

== Changelog ==

<a href="http://goo.gl/WA4g2v">English</a> - 
<a href="http://goo.gl/jMOcQ">Italiano</a> - 
<a href="http://goo.gl/6G8dH">Español</a> - 
<a href="http://goo.gl/WwtPs">Français</a> - 
<a href="http://goo.gl/VHbwt">Deutsch</a>

= Version 1.8.5 =
* Feature: Google Author Badge.
* Feature: Translate comments PHP code.
* Feature: Add profile G+ Badge Photo.
* Feature: Add profile G+ Badge Cover.
* Feature: Add documentation Google Maps.
* Fix: Field for input Meta ID translate.

= Version 1.8.4 =
* Feature: Google Maps module.
* Feature: Google Maps shortcode.
* Feature: Google Maps widget.
* Feature: Translate source comments.

= Version 1.8.3 =
* Feature: Add options start hangout "guest".
* Feature: Add options start hangout "logged".
* Feature: Add options start hangout "profile".
* Feature: Add options start hangout "email".
* Feature: Add options wrap PRE viewer docs.
* Feature: Add documentation for new options.

= Version 1.8.2 =
* Fix: Playlist bug with embed javascript.
* Fix: Change links in README file.
* Fix: Debug Code in footer for playlist.
* Fix: Add file .pot for translate.

= Version 1.8.1 =
* Feature: Translate plugin in espanol.
* Feature: Use mb_strtoupper() per uppercase.
* Feature: BETA test for use Google API.
* Fix: Change some function for performance.
* Fix: Google analytics add features.

= Version 1.8.0 =
* Feature: Add POPUP G+ Badge Page.
* Feature: Add POPUP G+ Badge Profile.
* Feature: Add POPUP Youtube Link.
* Feature: Add POPUP Youtube Button.
* Feature: Add Documentation Youtube Badge.
* Feature: Add Widget Youtube Link.
* Feature: Add Widget Youtube Button.
* Feature: Add Groups Domain APPs.

= Version 1.7.9 =
* Feature: Add POPUP shortcode Google+.
* Feature: Add POPUP shortcode Calendar.
* Feature: Add POPUP shortcode Drive.
* Feature: Add POPUP shortcode Groups.
* Feature: Add POPUP shortcode Hangouts.
* Feature: Add POPUP shortcode Panoramio.
* Feature: Add POPUP shortcode Translate.
* Feature: Add POPUP shortcode Youtube.
* Feature: Add external resource help italiano.
* Feature: Add TinyMCE fonts family and size.

= Version 1.7.8 =
* Fix: List of reviews.
* Fix: Some translation strings.
* Fix: File README for new link and contents.
* Feature: Add emergency code authenticator.

= Version 1.7.7 =
* Fix: Reduce size of plugin.
* Fix: Reduce size of screenshot.
* Fix: Google Calendar shortcode bug.
* Fix: Google Calendar widget bug.
* Fix: Remove images for documentation.
* Feature: Add icons for wordpress 4.0.
* Feature: Google Analytics display features.

= Version 1.7.6 =
* Fix: Widget Youtube playlist with autoplay.
* Fix: File README for new link and contents.
* Fix: Enable google api (beta version).
* Fix: Documentazione bug and incorrect words.
* Fix: Youtube option start/end seconds.

= Version 1.7.5 =
* Fix: Documentation drive embed.
* Fix: Documentation drive viewer.
* Fix: Margin configuration youtube playlist.
* Feature: Youtube playlist add responsive.
* Feature: Youtube playlist add more options.
* Feature: Youtube playlist object oriented.
* Feature: Youtube badge with sidebar widget.

= Version 1.7.4 =
* Fix: Widget Live for Wordpress 3.9 release.
* Fix: Active any option after disable plugin.
* Feature: Google+ automatic author badge.
* Feature: New model developer for objects.
* Feature: New model developer for widgets.

= Version 1.7.3 =
* Feature: Google Drive embed forms.
* Feature: Google Drive widget embed.
* Feature: Google Authenticator emergency file.
* Feature: Configuration page with tab.
* Feature: Add profile field google+ page.
* Feature: Add profile field google+ community.
* Feature: Add profile field google+ best post.
* Fix: Bug in admin area for performance.
* Fix: Bug in admin area for widget follow.
* Fix: Bug in admin area for widget calendar.

= Version 1.7.2 =
* Feature: Google Drive widget embed.
* Feature: Google Drive widget viewer.
* Feature: Google Drive shortcode embed.
* Feature: Google Drive shortcode viewer.
* Feature: completed the English translation.
* Feature: Translate plugin description.
* Fix: Calendar title if used in widget.

= Version 1.7.1 =
* Feature: Google Authenticator two step login.
* Feature: Google Authenticator enable to profile.
* Feature: Google Authenticator direct scan QR Code.
* Feature: Google Authenticator documentation.
* Feature: Multilangue for main plugin description.
* Fix: Badge not modification by other filters.

= Version 1.7.0 =
* Feature: New documentation online (english).
* Feature: New documentation online (italian).
* Fix: Google analytics remove repeat monitor code.
* Fix: Remove double instance object in core.

= Version 1.6.9 =
* Fix: Google groups not embed with firefox.
* Fix: Widget image problem with browser firefox.
* Fix: Google Analytics code when access with admin.
* Fix: Change method for autoloading class.

= Version 1.6.8 =
* Feature: Add google calendar shortcode.
* Feature: Add google calendar widgets.
* Feature: Change core for create widgets.
* Fix: Bug widget google plus follow botton.

= Version 1.6.7 =
* Feature: Add Google Fonts support.
* Feature: Add Admin support for WP 3.8 version.
* Feature: Add hangout start button shortcode.
* Feature: Add hangout start button widgets.
* Feature: Google hangouts documentation.

= Version 1.6.6 =
* Fix: Remove get_called_class() not run on PHP 5.2.
* Fix: Change and add fix to modules google plus.
* Fix: Change and add fix to modules google panoramio.
* Fix: Change and add fix to modules youtube.
* Fix: Change and add fix to modules google groups.

= Version 1.6.5 =
* Feature: Add Google+ link HEAD section for author.
* Feature: Add Google+ link HEAD section for publisher.
* Feature: Add Google+ recommendations for mobile.
* Feature: Add Google+ option float for button +1.
* Feature: Add Google+ option float for button share.
* Feature: Add Google+ option float for button follow.

= Version 1.6.4 =
* Feature: Admin layout right for MP6.
* Feature: Engeene execution engine more powerful.
* Fix: Title widget for youtube video.
* Fix: Title widget for youtube playlist.
* Fix: Shortcode g+ profile without ID.
* Fix: Shortcode g+ badge without ID.
* Fix: Shortcode g+ community without ID.

= Version 1.6.2 =
* Feature: Google analytics classic and universal.
* Feature: Google analytics documentation.
* Feature: Google analytics enable tracking subdomains.
* Feature: Google analytics enable multiple top domains.
* Feature: Google analytics enable advertiser.

= Version 1.6.1 =
* Feature: Add youtube playlist widget.
* Feature: Add youtube playlist shortcode.
* Fix: Options for sidebar widget google panoramio.
* Fix: Translate some string for italian language.
* Fix: Widget Youtube not display in admin sidebar.
* Fix: Function postbox conflit with insert new post.

= Version 1.6.0 =
* Feature: Add google panoramio widget.
* Feature: Add google panoramio shortcode.
* Feature: Add google panoramio function php.
* Feature: Add google panoramio documentation.

= Version 1.5.1 =
* Fix: Create separate translate file for admin/frontend.
* Fix: Create widgets for google groups in admin panel.
* Fix: Complete translate for italian language.
* Fix: Add new option in the documentation plugin.

= Version 1.5.0 =
* Fix: Change protocol for youtube badge with ssl.
* Fix: Change google+ comments and add dynamic CSS class.
* Fix: Change google+ comments and add dynamic title.
* Fix: Change google+ comments bug remove standard system.
* Fix: Add generic wrap and class CSS for google+ badge.
* Feature: Add badge google profile with pop-up.
* Feature: Add badge google page with pop-up.

= Version 1.4.0 =
* Feature: Add new module for google drive.
* Feature: Add google drive save button widget.
* Feature: Add google drive save button shortcode.
* Feature: Add google+ widget button plus one.
* Feature: Add google+ widget button sharing.
* Feature: Add google+ widget button follow.
* Feature: Add new CSS classes for all widgets. 

= Version 1.3.0 =
* Feature: Add google+ badge for followers widget.
* Feature: Add google+ badge for followers shortcode.
* Feature: Add options width="auto" for any badges.
* Feature: Add widget for new component buttons.

= Version 1.2.0 =
* Feature: Add documentation section for modules google+.
* Feature: Add any options for google+ buttons.
* Feature: Add options align for google+ badges.
* Fix: Correct options widget for google+ comment system.
* Fix: Problem events widget with jquery and WP 3.6.

= Version 1.1.0 =
* Feature: Add option fixed size google+ comments.
* Feature: Add widgets for google+ buttons.
* Feature: Add widgets for google+ embedded post.
* Feature: Add widgets for google+ comments.
* Fix: Correct bug for widget google+ embedded post.

= Version 1.0.0 =
* Feature: Add google+ embedded posts.
* Feature: Add css class for all components.
* Feature: Add options design for buttons google+.
* Feature: Add options design for badges google+.

= Version 0.9.0 =
* Feature: Add shortcode youtube for badge.
* Feature: Add shortcode youtube for button.
* Feature: Add shortcode youtube for link.
* Feature: Add widgets for module google youtube.
* Feature: Add default fixed size for g+ comments.

= Version 0.8.0 =
* Feature: Add module for modules documentation.
* Feature: Add options youtube loading delayed code.
* Feature: Add options youtube customer cove image.
* Feature: Add options youtube and schema.org.
* Fix: Change string for translate plugin italy.
* Fix: Parameters for shortcode google translate.

= Version 0.7.0 =
* Feature: Add module for google youtube.
* Feature: Add shortcode youtube [sz-ytvideo].
* Feature: Add options youtube in admin panel for personalize.
* Feature: Add options youtube disable IFRAME and use API.
* Feature: Add options youtube for google analytics.
* Fix: Change scripts for better performance.

= Version 0.6.0 =
* Fix: Translate more string for language italiano.
* Feature: Add module for google groups embed.
* Feature: Add widget for google groups embed.
* Feature: Add shortcode for google groups embed.
* Feature: Add administration panel for google groups embed.
* Feature: Add help description for field in admin panel.

= Version 0.5.0 =
* Fix: Translate more string for language italiano.
* Feature: Add module for google translate widget.
* Feature: Add option for google translate mode.
* Feature: Add option for google translate widget.
* Feature: Add option for google translate shortcode.

= Version 0.4.0 =
* Fix: Function sortables for admin panel and plugin options.
* Feature: Add option for remove google analytics if administrator.
* Feature: Add option for remove google analytics if user logged.
* Feature: Add option for remove google analytics if frontend.
* Feature: Add function for analytics szgoogle_analytics_get_ID().
* Feature: Add function for analytics szgoogle_analytics_get_code().

= Version 0.3.0 =
* Feature: Add Google+ switch for loading javascript code.
* Feature: Add stylesheet for personalized admin panel.
* Feature: Add module for Google Analytics.
* Feature: Add sidebar in admin panel for link about plugin.
* Feature: Remove code Analytics for admin area.

= Version 0.2.0 =
* Feature: Add Google+ shortcode button plus one.
* Feature: Add Google+ shortcode button share.
* Feature: Add Google+ shortcode button follow.
* Feature: Add Google+ custom URL redirect.
* Feature: Add Google+ select language widgets.

= Version 0.1.0 =
* Feature: First version of the plugin and initial functions.
* Feature: Add Google+ shortcode badges profile.
* Feature: Add Google+ shortcode badges page.
* Feature: Add Google+ shortcode badges community.
* Feature: Add Google+ widget badge profile.
* Feature: Add Google+ widget badge business page.
* Feature: Add Google+ widget badge community.
* Feature: Add Google+ comments system.

== Upgrade Notice ==
