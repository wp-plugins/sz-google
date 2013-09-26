<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_plus_menu() 
{
	if (function_exists('add_submenu_page')) {
		add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - Google+','Google+','manage_options','sz-google-admin-gplus.php','sz_google_admin_plus_callback'); 
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al Plugin                               */
/* ************************************************************************** */

function sz_google_admin_plus_fields()
{
	register_setting('sz_google_options_plus','sz_google_options_plus','sz_google_admin_plus_validate');

	// Definizione sezione per configurazione GOOGLE+

	add_settings_section('sz_google_plus_section','','sz_google_admin_plus_section','sz-google-admin-plus.php');
	add_settings_field('plus_profile',ucwords(__('google+ Profile','szgoogleadmin')),'sz_google_admin_plus_profile','sz-google-admin-plus.php','sz_google_plus_section');
	add_settings_field('plus_page',ucwords(__('google+ Page','szgoogleadmin')),'sz_google_admin_plus_page','sz-google-admin-plus.php','sz_google_plus_section');
	add_settings_field('plus_community',ucwords(__('google+ Community','szgoogledmin')),'sz_google_admin_plus_community','sz-google-admin-plus.php','sz_google_plus_section');

	// Definizione sezione per configurazione GOOGLE+ LANGUAGE

	add_settings_section('sz_google_plus_language','','sz_google_admin_plus_section','sz-google-admin-plus-language.php');
	add_settings_field('plus_language',ucfirst(__('select language','szgoogleadmin')),'sz_google_admin_plus_language','sz-google-admin-plus-language.php','sz_google_plus_language');

	// Definizione sezione per configurazione GOOGLE+ BADGE WIDGETS

	add_settings_section('sz_google_plus_widgets','','sz_google_admin_plus_section','sz-google-admin-plus-widgets.php');
	add_settings_field('plus_widget_pr_enable',ucwords(__('widget G+ profile','szgoogleadmin')),'sz_google_admin_plus_widget_profile','sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_pa_enable',ucwords(__('widget G+ page','szgoogleadmin')),'sz_google_admin_plus_widget_page','sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_co_enable',ucwords(__('widget G+ community','szgoogleadmin')),'sz_google_admin_plus_widget_community','sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_fl_enable',ucwords(__('widget G+ followers','szgoogleadmin')),'sz_google_admin_plus_widget_followers','sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_size_portrait',ucwords(__('widget width portrait','szgoogleadmin')),'sz_google_admin_plus_widget_size_portrait','sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_size_landscape',ucwords(__('widget width landscape','szgoogleadmin')),'sz_google_admin_plus_widget_size_landscape','sz-google-admin-plus-widgets.php','sz_google_plus_widgets');

	// Definizione sezione per configurazione GOOGLE+ BADGE SHORTCODE

	add_settings_section('sz_google_plus_shortcodes','','sz_google_admin_plus_section','sz-google-admin-plus-shortcodes.php');
	add_settings_field('plus_shortcode_pr_enable',ucwords(__('shortcode G+ profile','szgoogleadmin')),'sz_google_admin_plus_shortcode_profile','sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_pa_enable',ucwords(__('shortcode G+ page','szgoogleadmin')),'sz_google_admin_plus_shortcode_page','sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_co_enable',ucwords(__('shortcode G+ community','szgoogleadmin')),'sz_google_admin_plus_shortcode_community','sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_fl_enable',ucwords(__('shortcode G+ followers','szgoogleadmin')),'sz_google_admin_plus_shortcode_followers','sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_size_portrait',ucwords(__('shortcode width portrait','szgoogleadmin')),'sz_google_admin_plus_shortcode_size_portrait','sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_size_landscape',ucwords(__('shortcode width landscape','szgoogleadmin')),'sz_google_admin_plus_shortcode_size_landscape','sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');

	// Definizione sezione per configurazione GOOGLE+ BUTTON WIDGETS

	add_settings_section('sz_google_plus_widgets_buttons','','sz_google_admin_plus_section','sz-google-admin-plus-widgets-buttons.php');
	add_settings_field('plus_button_enable_widget_plusone',ucwords(__('widget g+ plusone','szgoogleadmin')),'sz_google_admin_plus_widget_button_plusone','sz-google-admin-plus-widgets-buttons.php','sz_google_plus_widgets_buttons');
	add_settings_field('plus_button_enable_widget_sharing',ucwords(__('widget g+ sharing','szgoogleadmin')),'sz_google_admin_plus_widget_button_sharing','sz-google-admin-plus-widgets-buttons.php','sz_google_plus_widgets_buttons');
	add_settings_field('plus_button_enable_widget_follow' ,ucwords(__('widget g+ follow' ,'szgoogleadmin')),'sz_google_admin_plus_widget_button_follow' ,'sz-google-admin-plus-widgets-buttons.php','sz_google_plus_widgets_buttons');

	// Definizione sezione per configurazione GOOGLE+ BUTTON SHORTCODE

	add_settings_section('sz_google_plus_buttons','','sz_google_admin_plus_section','sz-google-admin-plus-buttons.php');
	add_settings_field('plus_button_enable_plusone',ucwords(__('shortcode g+ plusone','szgoogleadmin')),'sz_google_admin_plus_button_plusone','sz-google-admin-plus-buttons.php','sz_google_plus_buttons');
	add_settings_field('plus_button_enable_sharing',ucwords(__('shortcode g+ sharing','szgoogleadmin')),'sz_google_admin_plus_button_sharing','sz-google-admin-plus-buttons.php','sz_google_plus_buttons');
	add_settings_field('plus_button_enable_follow' ,ucwords(__('shortcode g+ follow' ,'szgoogleadmin')),'sz_google_admin_plus_button_follow' ,'sz-google-admin-plus-buttons.php','sz_google_plus_buttons');

	// Definizione sezione per configurazione GOOGLE+ COMMENTS

	add_settings_section('sz_google_plus_comments','','sz_google_admin_plus_section','sz-google-admin-plus-comments.php');
	add_settings_field('plus_comments_gp_enable',  ucwords(__('enable G+ comments','szgoogleadmin')),      'sz_google_admin_plus_comments_gp',         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_wp_enable',  ucwords(__('enable WP comments','szgoogleadmin')),      'sz_google_admin_plus_comments_wp',         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_ac_enable',  ucwords(__('comments after content','szgoogleadmin')),  'sz_google_admin_plus_comments_ac',         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_aw_enable',  ucwords(__('comments after WP system','szgoogleadmin')),'sz_google_admin_plus_comments_aw',         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_wd_enable',  ucwords(__('comments widget','szgoogleadmin')),         'sz_google_admin_plus_comments_wd',         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_sh_enable',  ucwords(__('comments shortcode','szgoogleadmin')),      'sz_google_admin_plus_comments_sh',         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_dt_enable',  ucwords(__('comments date switch','szgoogleadmin')),    'sz_google_admin_plus_comments_dt',         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_fixed_size', ucwords(__('comments fixed size','szgoogleadmin')),     'sz_google_admin_plus_comments_fixed_size', 'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_title',      ucwords(__('comments title','szgoogleadmin')),          'sz_google_admin_plus_comments_title',      'sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_css_class_1',ucwords(__('comments CSS class 1','szgoogleadmin')),    'sz_google_admin_plus_comments_css_class_1','sz-google-admin-plus-comments.php','sz_google_plus_comments');
	add_settings_field('plus_comments_css_class_2',ucwords(__('comments CSS class 2','szgoogleadmin')),    'sz_google_admin_plus_comments_css_class_2','sz-google-admin-plus-comments.php','sz_google_plus_comments');

	// Definizione sezione per configurazione GOOGLE+ EMBEDDED POST

	add_settings_section('sz_google_plus_post','','sz_google_admin_plus_section','sz-google-admin-plus-post.php');
	add_settings_field('plus_post_enable_widget',ucwords(__('g+ embedded post widget','szgoogleadmin')),'sz_google_admin_plus_post_widget','sz-google-admin-plus-post.php','sz_google_plus_post');
	add_settings_field('plus_post_enable_shortcode',ucwords(__('g+ embedded post shortcode','szgoogleadmin')),'sz_google_admin_plus_post_shortcode','sz-google-admin-plus-post.php','sz_google_plus_post');

	// Definizione sezione per configurazione GOOGLE+ REDIRECT

	add_settings_section('sz_google_plus_redirect','','sz_google_admin_plus_section','sz-google-admin-plus-redirect.php');
	add_settings_field('plus_redirect_sign',ucwords(__('enable redirect /+','szgoogleadmin')),'sz_google_admin_plus_redirect_sign','sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
	add_settings_field('plus_redirect_sign_url',ucwords(__('enable redirect /+ URL','szgoogleadmin')),'sz_google_admin_plus_redirect_sign_url','sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
	add_settings_field('plus_redirect_plus',ucwords(__('enable redirect /plus','szgoogleadmin')),'sz_google_admin_plus_redirect_plus','sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
	add_settings_field('plus_redirect_plus_url',ucwords(__('enable redirect /plus URL','szgoogleadmin')),'sz_google_admin_plus_redirect_plus_url','sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
	add_settings_field('plus_redirect_curl',ucwords(__('enable redirect URL','szgoogleadmin')),'sz_google_admin_plus_redirect_curl','sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
	add_settings_field('plus_redirect_curl_source',ucwords(__('enable redirect URL source','szgoogleadmin')),'sz_google_admin_plus_redirect_curl_source','sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
	add_settings_field('plus_redirect_curl_target',ucwords(__('enable redirect URL target','szgoogleadmin')),'sz_google_admin_plus_redirect_curl_target','sz-google-admin-plus-redirect.php','sz_google_plus_redirect');

	// Definizione sezione per configurazione GOOGLE+ SYSTEM

	add_settings_section('sz_google_plus_system','','sz_google_admin_plus_section','sz-google-admin-plus-system.php');
	add_settings_field('plus_system_javascript',ucwords(__('disable file javascript','szgoogleadmin')),'sz_google_admin_plus_system_javascript','sz-google-admin-plus-system.php','sz_google_plus_system');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_plus_menu');
add_action('admin_init','sz_google_admin_plus_fields');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google+                                */
/* ************************************************************************** */

function sz_google_admin_plus_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		'sz-google-admin-plus.php'                 => ucwords(__('google+ ID','szgoogleadmin')),
		'sz-google-admin-plus-language.php'        => ucwords(__('google+ language','szgoogleadmin')),
		'sz-google-admin-plus-widgets.php'         => ucwords(__('google+ badge widget','szgoogleadmin')),
		'sz-google-admin-plus-shortcodes.php'      => ucwords(__('google+ badge shortcodes','szgoogleadmin')),
		'sz-google-admin-plus-widgets-buttons.php' => ucwords(__('google+ button widgets','szgoogleadmin')), 
		'sz-google-admin-plus-buttons.php'         => ucwords(__('google+ button shortcodes','szgoogleadmin')), 
		'sz-google-admin-plus-comments.php'        => ucwords(__('google+ comment system','szgoogleadmin')), 
		'sz-google-admin-plus-post.php'            => ucwords(__('google+ embedded post','szgoogleadmin')), 
		'sz-google-admin-plus-redirect.php'        => ucwords(__('google+ custom URL','szgoogleadmin')),
		'sz-google-admin-plus-system.php'          => ucwords(__('google+ system','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('google+ configuration','szgoogleadmin')),'sz_google_options_plus',$sections); 
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google+ ID                             */
/* ************************************************************************** */

function sz_google_admin_plus_profile() 
{
	sz_google_common_form_text('sz_google_options_plus','plus_profile','medium',__('insert ID your profile','szgoogleadmin'));
	sz_google_common_form_description(__('enter the code that identifies the profile on google+, get to know the code of a profile just look at the profile link and copy the 21 digit number located on the URL string. For example if the link is <a target="_blank" href="https://plus.google.com/106567288702045182616/posts">https://plus.google.com/106567288702045182616/posts</a> the profile ID is 106567288702045182616.','szgoogleadmin'));
}

function sz_google_admin_plus_page() 
{
	sz_google_common_form_text('sz_google_options_plus','plus_page','medium',__('insert ID your page','szgoogleadmin'));
	sz_google_common_form_description(__('enter the code that identifies the page on google+, get to know the code of a profile just look at the page link and copy the 21 digit number located on the URL string. For example if the link is <a target="_blank" href="https://plus.google.com/117259631219963935481">https://plus.google.com/117259631219963935481</a> the page ID is 117259631219963935481.','szgoogleadmin'));
}

function sz_google_admin_plus_community() 
{
	sz_google_common_form_text('sz_google_options_plus','plus_community','medium',__('insert ID your community','szgoogleadmin'));
	sz_google_common_form_description(__('enter the code that identifies the community, get to know the code of a community just look at the link and copy the 21 digit number located on the URL string. For example if the link is <a target="_blank" href="https://plus.google.com/communities/109254048492234113886">https://plus.google.com/communities/109254048492234113886</a> the community ID is 109254048492234113886.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google+ LANGUAGE                       */
/* ************************************************************************** */

function sz_google_admin_plus_language() 
{
	$values = sz_google_get_languages(); 

	sz_google_common_form_select('sz_google_options_plus','plus_language',$values,'medium','');
	sz_google_common_form_description(__('specify the language code associated with your website, if you do not specify any value will be called the get_bloginfo(\'language\') and set the same language related to the theme of wordpress. Supported languages ​​can be found on <a target="_blank" href="https://developers.google.com/+/web/api/supported-languages">Supported languages for the Google+ plugins</a>.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google+ WIDGETS                        */
/* ************************************************************************** */

function sz_google_admin_plus_widget_profile() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_widget_pr_enable');
	sz_google_common_form_description(__('enabling this option will be included in the admin panel a new widget that will allow the insertion of a badge for the user profiles present on google+. If you want to see the graphic result of badges provided by google read the <a target="_blank" href="https://developers.google.com/+/web/badge/">official documentation</a> of developers.','szgoogleadmin'));
}

function sz_google_admin_plus_widget_page() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_widget_pa_enable');
	sz_google_common_form_description(__('enabling this option will be included in the admin panel a new widget that will allow the insertion of a badge for the pages present on google+. If you want to see the graphic result of badges provided by google read the <a target="_blank" href="https://developers.google.com/+/web/badge/">official documentation</a> of developers.','szgoogleadmin'));
}

function sz_google_admin_plus_widget_community() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_widget_co_enable');
	sz_google_common_form_description(__('enabling this option will be included in the admin panel a new widget that will allow the insertion of a badge for the community present on google+. If you want to see the graphic result of badges provided by google read the <a target="_blank" href="https://developers.google.com/+/web/badge/">official documentation</a> of developers.','szgoogleadmin'));
}

function sz_google_admin_plus_widget_followers() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_widget_fl_enable');
	sz_google_common_form_description(__('enabling this option will be included in the admin panel a new widget that will allow the insertion of a badge for the followers present on google+. If you want to see the graphic result of badges provided by google read the <a target="_blank" href="https://developers.google.com/+/web/badge/">official documentation</a> of developers.','szgoogleadmin'));
}

function sz_google_admin_plus_widget_size_portrait()
{
	sz_google_common_form_number_step_1('sz_google_options_plus','plus_widget_size_portrait','medium',SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT);
	sz_google_common_form_description(__('this option is used to set a default width for use in widget when no size is set manually and is selected as the display mode portrait. If you do not specify a value for this field will be used the standard width of 180px and height will be calculated automatically.','szgoogleadmin'));
}

function sz_google_admin_plus_widget_size_landscape() 
{
	sz_google_common_form_number_step_1('sz_google_options_plus','plus_widget_size_landscape','medium',SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE);
	sz_google_common_form_description(__('this option is used to set a default width for use in widget when no size is set manually and is selected as the display mode landscape. If you do not specify a value for this field will be used the standard width of 275px and height will be calculated automatically.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ SHORTCODES               */
/* ************************************************************************** */

function sz_google_admin_plus_shortcode_profile() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_shortcode_pr_enable');
	sz_google_common_form_description(__('enabling this option will be included in the admin panel a new shortcode that will allow the insertion of a badge for the user profiles present on google+. If you want to see the graphic result of badges provided by google read the <a target="_blank" href="https://developers.google.com/+/web/badge/">official documentation</a> of developers.','szgoogleadmin'));
}

function sz_google_admin_plus_shortcode_page() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_shortcode_pa_enable');
	sz_google_common_form_description(__('enabling this option will be included in the admin panel a new shortcode that will allow the insertion of a badge for the pages present on google+. If you want to see the graphic result of badges provided by google read the <a target="_blank" href="https://developers.google.com/+/web/badge/">official documentation</a> of developers.','szgoogleadmin'));
}

function sz_google_admin_plus_shortcode_community() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_shortcode_co_enable');
	sz_google_common_form_description(__('enabling this option will be included in the admin panel a new shortcode that will allow the insertion of a badge for the community present on google+. If you want to see the graphic result of badges provided by google read the <a target="_blank" href="https://developers.google.com/+/web/badge/">official documentation</a> of developers.','szgoogleadmin'));
}

function sz_google_admin_plus_shortcode_followers() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_shortcode_fl_enable');
	sz_google_common_form_description(__('enabling this option will be included in the admin panel a new shortcode that will allow the insertion of a badge for the followers present on google+. If you want to see the graphic result of badges provided by google read the <a target="_blank" href="https://developers.google.com/+/web/badge/">official documentation</a> of developers.','szgoogleadmin'));
}

function sz_google_admin_plus_shortcode_size_portrait() 
{
	sz_google_common_form_number_step_1('sz_google_options_plus','plus_shortcode_size_portrait','medium',SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT);
	sz_google_common_form_description(__('this option is used to set a default width for use in widget when no size is set manually and is selected as the display mode portrait. If you do not specify a value for this field will be used the standard width of 350px and height will be calculated automatically.','szgoogleadmin'));
}

function sz_google_admin_plus_shortcode_size_landscape() 
{
	sz_google_common_form_number_step_1('sz_google_options_plus','plus_shortcode_size_landscape','medium',SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE);
	sz_google_common_form_description(__('this option is used to set a default width for use in widget when no size is set manually and is selected as the display mode landscape. If you do not specify a value for this field will be used the standard width of 350px and height will be calculated automatically.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ BUTTONS WIDGETS          */
/* ************************************************************************** */

function sz_google_admin_plus_widget_button_plusone() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_button_enable_widget_plusone');
	sz_google_common_form_description(__('with this option is activated widget that allows the insertion of a +1 button in our article or web page. The +1 button has the same function as the button like this on facebook. If you want to customize the position in the theme use the function <code>szgoogle_get_gplus_button_one()</code>.','szgoogleadmin'));
}

function sz_google_admin_plus_widget_button_sharing() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_button_enable_widget_sharing');
	sz_google_common_form_description(__('this option allows the activation of widget for sharing a link on social network google+. Using this function you can insert the button in an article or a page wordpress. If you want to customize the position in the theme use the function <code>szgoogle_get_gplus_button_share()</code>.','szgoogleadmin'));
}

function sz_google_admin_plus_widget_button_follow() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_button_enable_widget_follow');
	sz_google_common_form_description(__('this option allows the activation of widget for follow on social network google+. Using this function you can insert the button in an article or a page wordpress. If you want to customize the position in the theme use the function <code>szgoogle_get_gplus_button_follow()</code>.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ BUTTONS                  */
/* ************************************************************************** */

function sz_google_admin_plus_button_plusone() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_button_enable_plusone');
	sz_google_common_form_description(__('with this option is activated shortcode that allows the insertion of a +1 button in our article or web page. The +1 button has the same function as the button like this on facebook. If you want to customize the position in the theme use the function <code>szgoogle_get_gplus_button_one()</code>.','szgoogleadmin'));
}

function sz_google_admin_plus_button_sharing() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_button_enable_sharing');
	sz_google_common_form_description(__('this option allows the activation of shortcode for sharing a link on social network google+. Using this function you can insert the button in an article or a page wordpress. If you want to customize the position in the theme use the function <code>szgoogle_get_gplus_button_share()</code>.','szgoogleadmin'));
}

function sz_google_admin_plus_button_follow() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_button_enable_follow');
	sz_google_common_form_description(__('this option allows the activation of shortcode for follow on social network google+. Using this function you can insert the button in an article or a page wordpress. If you want to customize the position in the theme use the function <code>szgoogle_get_gplus_button_follow()</code>.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ COMMENTS                 */
/* ************************************************************************** */

function sz_google_admin_plus_comments_gp() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_comments_gp_enable');
	sz_google_common_form_description(__('if you enable this feature will be added to the new commenting system made ​​available on the social network google+. The widget will be placed in the standard location for comments to wordpress. For customizations use the function <code>szgoogle_get_gplus_comments()</code>.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_wp() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_comments_wp_enable');
	sz_google_common_form_description(__('activating this option you can activate the system\'s comments Wodpress same time as those of google+. To decide the position of the comments you have to set the fields to follow. You can choose whether to place comments after the content or last.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_ac() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_comments_ac_enable');
	sz_google_common_form_description(__('enabling this option, the comment system is generated immediately after the post content or web page, otherwise it is inserted at the point that the standard function is called of the comments of wordpress in the file of the active theme. See also <code>szgoogle_get_gplus_comments()</code>.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_aw() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_comments_aw_enable');
	sz_google_common_form_description(__('enabling this option, the comment system is generated immediately after standard comments, otherwise it is inserted at the point that the standard function is called of the comments of wordpress in the file of the active theme. See also <code>szgoogle_get_gplus_comments()</code>.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_wd() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_comments_wd_enable');
	sz_google_common_form_description(__('if you need to insert the component for comments to google+ in a sidebar you can activate this option and use the new widget that you will find in your admin panel, you specify the size or the way you use responsive design for automatic resize.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_sh() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_comments_sh_enable');
	sz_google_common_form_description(__('enabling this option will allow you to use the shortcode <code>[sz-gplus-comments/]</code> that will allow you to insert a box for comments to google plus in any part of your post or page standard wordpress. For greater customization uses <code>szgoogle_get_gplus_comments()</code>.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_fixed_size()
{
	sz_google_common_form_number_step_1('sz_google_options_plus','plus_comments_fixed_size','medium',__('responsive design','szgoogleadmin'));
	sz_google_common_form_description(__('if you do not specify a value for this option, the size of the container of the comments will be performed in responsive mode, otherwise it is applied to a fixed size specified in this field. Use this option on wordpress themes with fixed size.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_title()
{
	sz_google_common_form_text('sz_google_options_plus','plus_comments_title','large',__('string HTML for comments title','szgoogleadmin'));
	sz_google_common_form_description(__('Set this field to a string that identifies the creation of a first title of the widget for comments to google+. You can use html code and insert the variable with the name of {title}. If not given the title value for this field will be ignored and not printed.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_css_class_1()
{
	sz_google_common_form_text('sz_google_options_plus','plus_comments_css_class_1','large',__('name for CSS class (1)','szgoogleadmin'));
	sz_google_common_form_description(__('the widget comments has two wraps, each of these we can define the CSS style class that allow us to adapt the graphics of the comments to that of wordpress theme installed. Leave blank to not add any classes to the container of the comments.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_css_class_2()
{
	sz_google_common_form_text('sz_google_options_plus','plus_comments_css_class_2','large',__('name for CSS class (2)','szgoogleadmin'));
	sz_google_common_form_description(__('the widget comments has two wraps, each of these we can define the CSS style class that allow us to adapt the graphics of the comments to that of wordpress theme installed. Leave blank to not add any classes to the container of the comments.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ COMMENTS DATE            */
/* ************************************************************************** */

function sz_google_admin_plus_comments_dt() 
{
	sz_google_common_form_checkbox_yesno(
		'sz_google_options_plus','plus_comments_dt_enable'
	);

	// Creazione delle select per l'indicazione della data
	
	$date_format = __('MDA','szgoogleadmin');

	// Creazione delle select per l'indicazione della data

	if ($date_format == 'MDA') {
		sz_google_admin_plus_comments_dt_month(); 
		sz_google_admin_plus_comments_dt_day(); 
		sz_google_admin_plus_comments_dt_year(); 
		echo '<span class="fieldtext">'.__('(month / day / year)','szgoogleadmin').'</span>';
	}

	if ($date_format == 'DMA') {
		sz_google_admin_plus_comments_dt_day(); 
		sz_google_admin_plus_comments_dt_month(); 
		sz_google_admin_plus_comments_dt_year(); 
		echo '<span class="fieldtext">'.__('(day / month / year)','szgoogleadmin').'</span>';
	}

	if ($date_format == 'AMD') {
		sz_google_admin_plus_comments_dt_year(); 
		sz_google_admin_plus_comments_dt_month(); 
		sz_google_admin_plus_comments_dt_day(); 
		echo '<span class="fieldtext">'.__('(year / month / day)','szgoogleadmin').'</span>';
	}

	sz_google_common_form_description(__('enabling this option you can activate the commenting system only posts that are inserted after a certain date. This function is useful for managing two different systems of comments in reference to a period of time and using only the new commenting system for new posts.','szgoogleadmin'));
}

function sz_google_admin_plus_comments_dt_day() 
{
	$options = get_option('sz_google_options_plus');

	if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
	if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
	if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

	// Creazione campo per giorno di selezione
	
	echo '<select name="sz_google_options_plus[plus_comments_dt_day]">';

	foreach (range(1,31) as $key) {
		$selected = ($options['plus_comments_dt_day'] == sprintf('%02d',$key)) ? ' selected = "selected"' : '';
		echo '<option value="'.sprintf('%02d',$key).'"'.$selected.'>'.sprintf('%02d',$key).'</option>';
	}

	echo '</select>';
}

function sz_google_admin_plus_comments_dt_month() 
{
	$options = get_option('sz_google_options_plus');

	if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
	if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
	if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

	// Creazione campo per mese di selezione

	echo '<select name="sz_google_options_plus[plus_comments_dt_month]">';

	foreach (range(1,12) as $key) {
		$selected = ($options['plus_comments_dt_month'] == sprintf('%02d',$key)) ? ' selected = "selected"' : '';
		echo '<option value="'.sprintf('%02d',$key).'"'.$selected.'>'.sprintf('%02d',$key).'</option>';
	}

	echo '</select>';
}

function sz_google_admin_plus_comments_dt_year() 
{
	$options = get_option('sz_google_options_plus');

	if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
	if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
	if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

	// Creazione campo per anno di selezione
	
	echo '<select name="sz_google_options_plus[plus_comments_dt_year]">';

	foreach (array_reverse(range(2000,date('Y')+1)) as $key) {
		$selected = ($options['plus_comments_dt_year'] == sprintf('%04d',$key)) ? ' selected = "selected"' : '';
		echo '<option value="'.sprintf('%04d',$key).'"'.$selected.'>'.sprintf('%04d',$key).'</option>';
	}

	echo '</select>';
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ EMBEDDED POST            */
/* ************************************************************************** */

function sz_google_admin_plus_post_widget() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_post_enable_widget');
	sz_google_common_form_description(__('if you need to insert the component for embedded post to google+ in a sidebar you can activate this option and use the new widget that you will find in your admin panel, you specify the size or the way you use responsive design for automatic resize.','szgoogleadmin'));
}

function sz_google_admin_plus_post_shortcode() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_post_enable_shortcode');
	sz_google_common_form_description(__('enabling this option will allow you to use the shortcode <code>[sz-gplus-post/]</code> that will allow you to insert a box for embedded post to google plus in any part of your post or page standard wordpress. For greater customization uses <code>szgoogle_get_gplus_post()</code>.','szgoogleadmin'));
}


/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ REDIRECT                 */
/* ************************************************************************** */

function sz_google_admin_plus_redirect_sign() {
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_redirect_sign');
	sz_google_common_form_description(__('with this option you can enable a rewrite rules that allows you to get a web address personalized pointing to the corresponding page on google plus such as <code>mydomain.com/+</code>. Activate this option and enter the complete link of the destination page of google plus.','szgoogleadmin'));
} 

function sz_google_admin_plus_redirect_sign_url() 
{
	sz_google_common_form_text('sz_google_options_plus','plus_redirect_sign_url','large',__('destination URL','szgoogleadmin'));
	sz_google_common_form_description(__('in this field you must enter the full URL for the landing page that describes the connection on google plus. In fact you can enter any URL even if the rewrite is designed for integration with google plus. Please make use of the most useful for your needs.','szgoogleadmin'));
} 

function sz_google_admin_plus_redirect_plus() {
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_redirect_plus');
	sz_google_common_form_description(__('with this option you can enable a rewrite rules that allows you to get a web address personalized pointing to the corresponding page on google plus such as <code>mydomain.com/plus</code>. Activate this option and enter the complete link of the destination page of google plus.','szgoogleadmin'));
} 

function sz_google_admin_plus_redirect_plus_url() 
{
	sz_google_common_form_text('sz_google_options_plus','plus_redirect_plus_url','large',__('destination URL','szgoogleadmin'));
	sz_google_common_form_description(__('in this field you must enter the full URL for the landing page that describes the connection on google plus. In fact you can enter any URL even if the rewrite is designed for integration with google plus. Please make use of the most useful for your needs.','szgoogleadmin'));
} 

function sz_google_admin_plus_redirect_curl() {
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_redirect_curl');
	sz_google_common_form_description(__('with this option you can enable a rewrite rules that allows you to get a web address personalized pointing to the corresponding page on google plus such as <code>mydomain.com/origin</code>. Activate this option and enter the complete link of the source and destination page of google plus.','szgoogleadmin'));
} 

function sz_google_admin_plus_redirect_curl_source() 
{
	sz_google_common_form_text('sz_google_options_plus','plus_redirect_curl_dir','large',__('source path URL for redirect','szgoogleadmin'));
	sz_google_common_form_description(__('in this field you must enter the source partial URL of your domain on which to perform the rewrite rule. For example you can use as a value source URL string <code>community/+</code> and associate the destination on a community present on google+.','szgoogleadmin'));
}

function sz_google_admin_plus_redirect_curl_target() 
{
	sz_google_common_form_text('sz_google_options_plus','plus_redirect_curl_url','large',__('destination URL','szgoogleadmin'));
	sz_google_common_form_description(__('in this field you must enter the full URL for the landing page that describes the connection on google plus. In fact you can enter any URL even if the rewrite is designed for integration with google plus. Please make use of the most useful for your needs.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ SYSTEM                   */
/* ************************************************************************** */

function sz_google_admin_plus_system_javascript() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_plus','plus_system_javascript');
	sz_google_common_form_description(__('if you use some plugin that performs functions similar to <a target="_blank" href="http://wordpress.org/plugins/sz-google/">sz-google for wordpress</a> is possible that we might create a conflict retrieving files javascript google, enabling this option will be disabled loadings code javascript from our plugin. In this way is not guaranteed to function properly.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati al modulo                     */
/* ************************************************************************** */

function sz_google_admin_plus_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_plus_section() {}