<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_youtube_menu() 
{
	if (function_exists('add_submenu_page')) {
		add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - '.ucwords(__('google youtube','szgoogleadmin')),ucwords(__('google youtube','szgoogleadmin')),'manage_options','sz-google-admin-youtube.php','sz_google_admin_youtube_callback'); 
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al plugin                               */
/* ************************************************************************** */

function sz_google_admin_youtube_fields()
{
	register_setting('sz_google_options_youtube','sz_google_options_youtube','sz_google_admin_youtube_validate');

	// Definizione sezione per configurazione GOOGLE YOUTUBE CONFIG
	add_settings_section('sz_google_youtube_config','','sz_google_admin_youtube_config','sz-google-admin-youtube-config.php');
	add_settings_field('youtube_channel',ucfirst(__('channel name or ID','szgoogleadmin')),'sz_google_admin_youtube_channel','sz-google-admin-youtube-config.php','sz_google_youtube_config');

	// Definizione sezione per configurazione GOOGLE YOUTUBE ACTIVATED

	add_settings_section('sz_google_youtube_active','','sz_google_admin_youtube_active','sz-google-admin-youtube-enable.php');
	add_settings_field('youtube_widget',ucwords(__('enable widget video','szgoogleadmin')),'sz_google_admin_youtube_widget','sz-google-admin-youtube-enable.php','sz_google_youtube_active');
	add_settings_field('youtube_widget_badge',ucwords(__('enable widget badge','szgoogleadmin')),'sz_google_admin_youtube_widget_badge','sz-google-admin-youtube-enable.php','sz_google_youtube_active');
	add_settings_field('youtube_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),'sz_google_admin_youtube_shortcode','sz-google-admin-youtube-enable.php','sz_google_youtube_active');
	add_settings_field('youtube_shortcode_badge',ucwords(__('enable shortcode badge','szgoogleadmin')),'sz_google_admin_youtube_shortcode_badge','sz-google-admin-youtube-enable.php','sz_google_youtube_active');
	add_settings_field('youtube_shortcode_button',ucwords(__('enable shortcode button','szgoogleadmin')),'sz_google_admin_youtube_shortcode_button','sz-google-admin-youtube-enable.php','sz_google_youtube_active');
	add_settings_field('youtube_shortcode_link',ucwords(__('enable shortcode link','szgoogleadmin')),'sz_google_admin_youtube_shortcode_link','sz-google-admin-youtube-enable.php','sz_google_youtube_active');

	// Definizione sezione per configurazione GOOGLE YOUTUBE DISPLAY

	add_settings_section('sz_google_youtube_display','','sz_google_admin_youtube_display','sz-google-admin-youtube-display.php');
	add_settings_field('youtube_responsive',ucfirst(__('responsive mode','szgoogleadmin')),'sz_google_admin_youtube_responsive','sz-google-admin-youtube-display.php','sz_google_youtube_display');
	add_settings_field('youtube_width',ucfirst(__('default width','szgoogleadmin')),'sz_google_admin_youtube_width','sz-google-admin-youtube-display.php','sz_google_youtube_display');
	add_settings_field('youtube_height',ucfirst(__('default height','szgoogleadmin')),'sz_google_admin_youtube_height','sz-google-admin-youtube-display.php','sz_google_youtube_display');
	add_settings_field('youtube_autoplay',ucfirst(__('video autoplay','szgoogleadmin')),'sz_google_admin_youtube_autoplay','sz-google-admin-youtube-display.php','sz_google_youtube_display');
	add_settings_field('youtube_loop',ucfirst(__('video loop','szgoogleadmin')),'sz_google_admin_youtube_loop','sz-google-admin-youtube-display.php','sz_google_youtube_display');
	add_settings_field('youtube_theme',ucfirst(__('theme','szgoogleadmin')),'sz_google_admin_youtube_theme','sz-google-admin-youtube-display.php','sz_google_youtube_display');
	add_settings_field('youtube_cover',ucfirst(__('cover','szgoogleadmin')),'sz_google_admin_youtube_cover','sz-google-admin-youtube-display.php','sz_google_youtube_display');
	add_settings_field('youtube_schemaorg',ucfirst(__('schema.org','szgoogleadmin')),'sz_google_admin_youtube_schemaorg','sz-google-admin-youtube-display.php','sz_google_youtube_display');

	// Definizione sezione per configurazione GOOGLE YOUTUBE MARGINS

	add_settings_section('sz_google_youtube_margins','','sz_google_admin_youtube_margins','sz-google-admin-youtube-margins.php');
	add_settings_field('youtube_margin_top',ucfirst(__('margin top','szgoogleadmin')),'sz_google_admin_youtube_margin_top','sz-google-admin-youtube-margins.php','sz_google_youtube_margins');
	add_settings_field('youtube_margin_right',ucfirst(__('margin right','szgoogleadmin')),'sz_google_admin_youtube_margin_right','sz-google-admin-youtube-margins.php','sz_google_youtube_margins');
	add_settings_field('youtube_margin_bottom',ucfirst(__('margin bottom','szgoogleadmin')),'sz_google_admin_youtube_margin_bottom','sz-google-admin-youtube-margins.php','sz_google_youtube_margins');
	add_settings_field('youtube_margin_left',ucfirst(__('margin left','szgoogleadmin')),'sz_google_admin_youtube_margin_left','sz-google-admin-youtube-margins.php','sz_google_youtube_margins');
	add_settings_field('youtube_margin_unit',ucfirst(__('margin unit','szgoogleadmin')),'sz_google_admin_youtube_margin_unit','sz-google-admin-youtube-margins.php','sz_google_youtube_margins');

	// Definizione sezione per configurazione GOOGLE YOUTUBE ADVANCED

	add_settings_section('sz_google_youtube_advanced','','sz_google_admin_youtube_advanced','sz-google-admin-youtube-advanced.php');
	add_settings_field('youtube_force_ssl',ucfirst(__('force SSL','szgoogleadmin')),'sz_google_admin_youtube_force_ssl','sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
	add_settings_field('youtube_fullscreen',ucfirst(__('enable fullscreen','szgoogleadmin')),'sz_google_admin_youtube_fullscreen','sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
	add_settings_field('youtube_disablekeyboard',ucfirst(__('disable keyboard','szgoogleadmin')),'sz_google_admin_youtube_disablekeyboard','sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
	add_settings_field('youtube_disableiframe',ucfirst(__('disable IFRAME and use API','szgoogleadmin')),'sz_google_admin_youtube_disableiframe','sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
	add_settings_field('youtube_analytics',ucwords(__('google analytics','szgoogleadmin')),'sz_google_admin_youtube_analytics','sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
	add_settings_field('youtube_delayed',ucwords(__('delayed loading','szgoogleadmin')),'sz_google_admin_youtube_delayed','sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
	add_settings_field('youtube_disablerelated',ucwords(__('disable related','szgoogleadmin')),'sz_google_admin_youtube_disablerelated','sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_youtube_menu');
add_action('admin_init','sz_google_admin_youtube_fields');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google Youtube                         */
/* ************************************************************************** */

function sz_google_admin_youtube_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		'sz-google-admin-youtube-config.php'   => ucwords(__('general setting','szgoogleadmin')),
		'sz-google-admin-youtube-enable.php'   => ucwords(__('activation components','szgoogleadmin')),
		'sz-google-admin-youtube-display.php'  => ucwords(__('video display setting','szgoogleadmin')),
		'sz-google-admin-youtube-margins.php'  => ucwords(__('video setting default margins','szgoogleadmin')),
		'sz-google-admin-youtube-advanced.php' => ucwords(__('video advanced setting','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('google youtube configuration','szgoogleadmin')),'sz_google_options_youtube',$sections); 
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE YOUTUBE GENERAL                 */
/* ************************************************************************** */

function sz_google_admin_youtube_channel()
{
	sz_google_common_form_text('sz_google_options_youtube','youtube_channel','large',__('insert your channel name or ID','szgoogleadmin'));
	sz_google_common_form_description(__('enter in this field the default name of your youtube channel. You can change the channel name using the shortcode or functions. if you do not specify anything the default channel will be "startbyzero". The channel\'s name is located in the your string URL.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE YOUTUBE COMPONENT               */
/* ************************************************************************** */

function sz_google_admin_youtube_widget()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_widget');
	sz_google_common_form_description(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
}

function sz_google_admin_youtube_widget_badge()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_widget_badge');
	sz_google_common_form_description(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
}

function sz_google_admin_youtube_shortcode() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_shortcode');
	sz_google_common_form_description(__('if you enable this option you can use the shortcode <code>[sz-ytvideo]</code> and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
}

function sz_google_admin_youtube_shortcode_badge() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_shortcode_badge');
	sz_google_common_form_description(__('if you enable this option you can use the shortcode <code>[sz-ytbadge]</code> and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
}

function sz_google_admin_youtube_shortcode_button() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_shortcode_button');
	sz_google_common_form_description(__('if you enable this option you can use the shortcode <code>[sz-ytbutton]</code> and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
}

function sz_google_admin_youtube_shortcode_link() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_shortcode_link');
	sz_google_common_form_description(__('if you enable this option you can use the shortcode <code>[sz-ytlink]</code> and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE YOUTUBE DISPLAY                 */
/* ************************************************************************** */

function sz_google_admin_youtube_responsive()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_responsive');
	sz_google_common_form_description(__('activating this value, the size of the video will be managed with the technique of responsive design, so the size is automatically adjusted to the size of the window, for more information and a more detailed explanation please see the documentation on <a href="http://en.wikipedia.org/wiki/Responsive_web_design">Wikipedia Responsive Web Design</a>.','szgoogleadmin'));
}

function sz_google_admin_youtube_width()
{
	sz_google_common_form_number_step_1('sz_google_options_youtube','youtube_width','medium',SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH);
	sz_google_common_form_description(__('enter the default size of the video, if you do not specify a value in this field, the default size will be 600px. If you specified a value of "0" or is activated the responsive mode will be used the special value 100% which will occupy the entire space of the container.','szgoogleadmin'));
}

function sz_google_admin_youtube_height()
{
	sz_google_common_form_number_step_1('sz_google_options_youtube','youtube_height','medium',SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT);
	sz_google_common_form_description(__('Enter the default size of the video, if you do not specify a value in this field, the default size will be 400px. In the responsive version this value will be ignored, in fact the height will change automatically according to the width of the parent container.','szgoogleadmin'));
}

function sz_google_admin_youtube_autoplay()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_autoplay');
	sz_google_common_form_description(__('enabling this option, the video will start automatically inserted when viewing the page without waiting for the user to press the play button. This behavior you can manage it even with the option of shortcode called <code>autoplay</code>. Do not put two videos in the same page with autoplay enabled.','szgoogleadmin'));
}

function sz_google_admin_youtube_loop()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_loop');
	sz_google_common_form_description(__('this option allows you to reinitiate the video after it was finished. The same function, you can obtain it using the special value <code>loop</code> in the shortcode without changing the default behavior. See official documentation <a target="_blank" href="https://developers.google.com/youtube/player_parameters#loop">Developer Youtube</a>.','szgoogleadmin'));
}

function sz_google_admin_youtube_theme()
{
	$values = array(
		'dark'  => __('dark','szgoogleadmin'),
		'light' => __('light','szgoogleadmin'),
	); 

	sz_google_common_form_select('sz_google_options_youtube','youtube_theme',$values,'medium','');
	sz_google_common_form_description(__('in this field specify the default theme to apply the player. At this time you can choose between "light" and "dark". To see if they added some additional theme controls the official documentation <a target="_blank" href="https://developers.google.com/youtube/player_parameters#theme">Developer Youtube</a>. Also this parameter can be specified directly in the shortcode.','szgoogleadmin'));
}

function sz_google_admin_youtube_cover()
{
	$values = array(
		'local'   => __('local','szgoogleadmin'),
		'youtube' => __('youtube','szgoogleadmin'),
	); 

	sz_google_common_form_select('sz_google_options_youtube','youtube_cover',$values,'medium','');
	sz_google_common_form_description(__('in this field you must specify the type of cover for your video clip when you do not specify a custom value. If you specify "local" will be used to cover stored in the plugin, if you use the value "youtube" will be used to cover defaults on youtube.','szgoogleadmin'));
}

function sz_google_admin_youtube_schemaorg()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_schemaorg');
	sz_google_common_form_description(__('enabling this option will be enabled <code>meta</code> commands relating to the resources of schema.org video. The values ​​of "meta" must be specified on shortcode or PHP function. For more information read the <a target="_blank" href="http://schema.org/VideoObject">official documentation</a> or the help page of google <a target="_blank" href="https://support.google.com/webmasters/answer/2413309?hl=en">Markup schema.org</a>.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE YOUTUBE MARGINS                 */
/* ************************************************************************** */

function sz_google_admin_youtube_margin_top()
{
	sz_google_common_form_number_step_1('sz_google_options_youtube','youtube_margin_top','medium',0);
	sz_google_common_form_description(__('enter the value of the margin to be applied to the container that will contain the iframe youtube video to display. If you do not specify any value will be used the value 0. This parameter indicates the top margin from the previous text and it will be applied to <code>class="sz-youtube-main"</code>.','szgoogleadmin'));
}

function sz_google_admin_youtube_margin_right()
{
	sz_google_common_form_number_step_1('sz_google_options_youtube','youtube_margin_right','medium',SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO);
	sz_google_common_form_description(__('enter the value of the margin to be applied to the container that will contain the iframe youtube video to display. If you do not specify any value for this field will be used the special value "auto". If you\'ve enabled the responsive mode, this value will be ignored and will be used as margin the value "auto".','szgoogleadmin'));
}

function sz_google_admin_youtube_margin_bottom()
{
	sz_google_common_form_number_step_1('sz_google_options_youtube','youtube_margin_bottom','medium',0);
	sz_google_common_form_description(__('enter the value of the margin to be applied to the container that will contain the iframe youtube video to display. If you do not specify any value will be used the value 0. This parameter indicates the bottom margin from the text and it will be applied to <code>class="sz-youtube-main"</code>.','szgoogleadmin'));
}

function sz_google_admin_youtube_margin_left()
{
	sz_google_common_form_number_step_1('sz_google_options_youtube','youtube_margin_left','medium',SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO);
	sz_google_common_form_description(__('enter the value of the margin to be applied to the container that will contain the iframe youtube video to display. If you do not specify any value for this field will be used the special value "auto". If you\'ve enabled the responsive mode, this value will be ignored and will be used as margin the value "auto".','szgoogleadmin'));
}

function sz_google_admin_youtube_margin_unit()
{
	$values = array(
		'em' => __('em','szgoogleadmin'),
		'px' => __('px','szgoogleadmin'),
	); 

	sz_google_common_form_select('sz_google_options_youtube','youtube_margin_unit',$values,'medium','');
	sz_google_common_form_description(__('this field is used to specify the unit of measure that must be applied to numeric values ​​that relate to the margins of the video container, the values ​​that can be specified are em = relative size or px = pixel size. With these values ​​will create the CSS code for HTML containers.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE YOUTUBE ADVANCED                */
/* ************************************************************************** */

function sz_google_admin_youtube_force_ssl()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_force_ssl');
	sz_google_common_form_description(__('if this function is enabled the embed code to generate the video link is forced with the SSL protocol even if the URL string is specified otherwise. Enabling recommended if the web pages of the site are set by default with SSL.','szgoogleadmin'));
}

function sz_google_admin_youtube_fullscreen()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_fullscreen');
	sz_google_common_form_description(__('enable this option to enter in the control bar of the video player icon that allows you to view fullscreen. More information can be found in the official documentation <a target="_blank" href="https://developers.google.com/youtube/player_parameters#fs">Developer Youtube</a>. This behavior you can manage it even with the option of shortcode called <code>fullscreen</code>.','szgoogleadmin'));
}

function sz_google_admin_youtube_disablekeyboard()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_disablekeyboard');
	sz_google_common_form_description(__('will disable the player keyboard controls. Keyboard controls are as follows: Spacebar: Play/Pause - Arrow Left: Jump back 10% in the current video - Arrow Right: Jump ahead 10% in the current video - Arrow Up: Volume up - Arrow Down: Volume Down.','szgoogleadmin'));
}

function sz_google_admin_youtube_disableiframe()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_disableiframe');
	sz_google_common_form_description(__('normally to insert a youtube video on a webpage uses the iframe technique, use this parameter to change this way and use the JavaScript API provided by google. If you activate the option of google analytics for youtube this value will be ignored, in fact, will always be used API.','szgoogleadmin'));
}

function sz_google_admin_youtube_analytics() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_analytics');
	sz_google_common_form_description(__('track translation traffic using google analytics. If you enable this option, you can check the requirements and the translation statistics directly to your google analytics account. If you enable this option, you can check the requirements and the translation statistics directly to your google analytics account. Remember that to run this option you must specify the code assigned to your profile analytics.','szgoogleadmin'));
}

function sz_google_admin_youtube_delayed() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_delayed');
	sz_google_common_form_description(__('by default the iframe code associated with the video to be displayed is loaded immediately, there may be cases where this can be poorly performing, or even when we want to customize the cover image, it would be better to load the code after the user executes the play button.','szgoogleadmin'));
}

function sz_google_admin_youtube_disablerelated() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_youtube','youtube_disablerelated');
	sz_google_common_form_description(__('enabling this option disables the related videos that are presented to the player at the end of the video. activating this option in the final video should be made the cover of the video. Read the official documentation to <a target="_blank" href="https://developers.google.com/youtube/player_parameters#rel">Developer Guide</a>.','szgoogleadmin'));
}
/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a modulo                      */
/* ************************************************************************** */

function sz_google_admin_youtube_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_youtube_config()   {}
function sz_google_admin_youtube_active()   {}
function sz_google_admin_youtube_display()  {}
function sz_google_admin_youtube_margins()  {}
function sz_google_admin_youtube_advanced() {}