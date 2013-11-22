<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_panoramio_menu() 
{
	if (function_exists('add_submenu_page')) {
		$pagehook = add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - '.ucwords(__('google panoramio','szgoogleadmin')),ucwords(__('google panoramio','szgoogleadmin')),'manage_options','sz-google-admin-panoramio.php','sz_google_admin_panoramio_callback'); 
		add_action('admin_print_scripts-'.$pagehook,'sz_google_admin_add_plugin');
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al plugin                               */
/* ************************************************************************** */

function sz_google_admin_panoramio_fields()
{
	register_setting('sz_google_options_panoramio','sz_google_options_panoramio','sz_google_admin_panoramio_validate');

	// Definizione sezione per configurazione GOOGLE PANORAMIO ACTIVATED

	add_settings_section('sz_google_panoramio_active','','sz_google_admin_panoramio_active','sz-google-admin-panoramio-enable.php');
	add_settings_field('panoramio_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),'sz_google_admin_panoramio_shortcode','sz-google-admin-panoramio-enable.php','sz_google_panoramio_active');
	add_settings_field('panoramio_widget',ucwords(__('enable widget','szgoogleadmin')),'sz_google_admin_panoramio_widget','sz-google-admin-panoramio-enable.php','sz_google_panoramio_active');

	// Definizione sezione per configurazione GOOGLE PANORAMIO SHORTCODE

	add_settings_section('sz_google_panoramio_s_options','','sz_google_admin_panoramio_s_options','sz-google-admin-panoramio-s-options.php');
	add_settings_field('panoramio_s_template',ucfirst(__('default template','szgoogleadmin')),'sz_google_admin_panoramio_s_template','sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
	add_settings_field('panoramio_s_width',ucfirst(__('default width','szgoogleadmin')),'sz_google_admin_panoramio_s_width','sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
	add_settings_field('panoramio_s_height',ucfirst(__('default height','szgoogleadmin')),'sz_google_admin_panoramio_s_height','sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
	add_settings_field('panoramio_s_orientation',ucfirst(__('default orientation','szgoogleadmin')),'sz_google_admin_panoramio_s_orientation','sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
	add_settings_field('panoramio_s_list_size',ucfirst(__('default list size','szgoogleadmin')),'sz_google_admin_panoramio_s_list_size','sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
	add_settings_field('panoramio_s_position',ucfirst(__('default position','szgoogleadmin')),'sz_google_admin_panoramio_s_position','sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
	add_settings_field('panoramio_s_paragraph',ucfirst(__('enable paragraph','szgoogleadmin')),'sz_google_admin_panoramio_s_paragraph','sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');

	// Definizione sezione per configurazione GOOGLE PANORAMIO WIDGET

	add_settings_section('sz_google_panoramio_w_options','','sz_google_admin_panoramio_w_options','sz-google-admin-panoramio-w-options.php');
	add_settings_field('panoramio_w_template',ucfirst(__('default template','szgoogleadmin')),'sz_google_admin_panoramio_w_template','sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
	add_settings_field('panoramio_w_width',ucfirst(__('default width','szgoogleadmin')),'sz_google_admin_panoramio_w_width','sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
	add_settings_field('panoramio_w_height',ucfirst(__('default height','szgoogleadmin')),'sz_google_admin_panoramio_w_height','sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
	add_settings_field('panoramio_w_orientation',ucfirst(__('default orientation','szgoogleadmin')),'sz_google_admin_panoramio_w_orientation','sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
	add_settings_field('panoramio_w_list_size',ucfirst(__('default list size','szgoogleadmin')),'sz_google_admin_panoramio_w_list_size','sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
	add_settings_field('panoramio_w_position',ucfirst(__('default position','szgoogleadmin')),'sz_google_admin_panoramio_w_position','sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_panoramio_menu');
add_action('admin_init','sz_google_admin_panoramio_fields');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google Panoramio                       */
/* ************************************************************************** */

function sz_google_admin_panoramio_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		'sz-google-admin-panoramio-enable.php'    => ucwords(__('activation components','szgoogleadmin')),
		'sz-google-admin-panoramio-s-options.php' => ucwords(__('default options for shortcode','szgoogleadmin')),
		'sz-google-admin-panoramio-w-options.php' => ucwords(__('default options for widget','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('google panoramio configuration','szgoogleadmin')),'sz_google_options_panoramio',$sections); 
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE PANORAMIO COMPONENTS            */
/* ************************************************************************** */

function sz_google_admin_panoramio_shortcode()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_panoramio','panoramio_shortcode');
	sz_google_common_form_description(__('if you enable this option you can use the shortcode [sz-panoramio] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
}

function sz_google_admin_panoramio_widget()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_panoramio','panoramio_widget');
	sz_google_common_form_description(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE PANORAMIO S-OPTIONS             */
/* ************************************************************************** */

function sz_google_admin_panoramio_s_template() 
{
	$values = array('photo'=>'photo','slideshow'=>'slideshow','list'=>'list','photo_list'=>'photo_list'); 
	sz_google_common_form_select('sz_google_options_panoramio','panoramio_s_template',$values,'medium','');
	sz_google_common_form_description(__('photo for a single-photo widget - slideshow for a single-photo widget with a play/pause button that automatically advances to the next photo - list for a photo-list widget - photo_list for a combination of a single-photo widget and a photo-list widget.','szgoogleadmin'));
}

function sz_google_admin_panoramio_s_width()
{
	sz_google_common_form_number_step_1('sz_google_options_panoramio','panoramio_s_width','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_S_WIDTH);
	sz_google_common_form_description(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
}

function sz_google_admin_panoramio_s_height()
{
	sz_google_common_form_number_step_1('sz_google_options_panoramio','panoramio_s_height','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_S_HEIGHT);
	sz_google_common_form_description(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 300 pixels.','szgoogleadmin'));
}

function sz_google_admin_panoramio_s_orientation() 
{
	$values = array('horizontal'=>'horizontal','vertical'=>'vertical'); 
	sz_google_common_form_select('sz_google_options_panoramio','panoramio_s_orientation',$values,'medium','');
	sz_google_common_form_description(__('the orientation of the list. Valid values are horizontal and vertical. This controls the position of the arrows, the scrolling direction, and how the photos are sorted. The shape of the list, grid is controlled by the rows and columns options.','szgoogleadmin'));
}

function sz_google_admin_panoramio_s_list_size()
{
	sz_google_common_form_number_step_1('sz_google_options_panoramio','panoramio_s_list_size','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_S_LIST_SIZE);
	sz_google_common_form_description(__('How many photos to show in the list. This option can only be specified with the template photo_list, for the other template, the option will be ignored. The list can be positioned in different ways, set the parameter "position" to the required value.','szgoogleadmin'));
}

function sz_google_admin_panoramio_s_position() 
{
	$values = array('bottom'=>__('position bottom','szgoogleadmin'),'top'=>__('position top','szgoogleadmin'),'left'=>__('position left','szgoogleadmin'),'right'=>__('position right','szgoogleadmin')); 
	sz_google_common_form_select('sz_google_options_panoramio','panoramio_s_position',$values,'medium','');
	sz_google_common_form_description(__('Position of the photo list relative to the single-photo widget. Valid values are left, top, right and bottom. This option is valid only with the template photo_list, for the other template, the option will be ignored. The default value if not specified is "bottom".','szgoogleadmin'));
}

function sz_google_admin_panoramio_s_paragraph() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_panoramio','panoramio_s_paragraph');
	sz_google_common_form_description(__('if you enable this option will add a paragraph at the end of the widget, this to be compatible with the theme and use the same features css defined for the block section. If you do not want spacing paragraph disable this option.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE PANORAMIO W-OPTIONS             */
/* ************************************************************************** */

function sz_google_admin_panoramio_w_template() 
{
	$values = array('photo'=>'photo','slideshow'=>'slideshow','list'=>'list','photo_list'=>'photo_list'); 
	sz_google_common_form_select('sz_google_options_panoramio','panoramio_w_template',$values,'medium','');
	sz_google_common_form_description(__('photo for a single-photo widget - slideshow for a single-photo widget with a play/pause button that automatically advances to the next photo - list for a photo-list widget - photo_list for a combination of a single-photo widget and a photo-list widget.','szgoogleadmin'));
}

function sz_google_admin_panoramio_w_width()
{
	sz_google_common_form_number_step_1('sz_google_options_panoramio','panoramio_w_width','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_W_WIDTH);
	sz_google_common_form_description(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the widget, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
}

function sz_google_admin_panoramio_w_height()
{
	sz_google_common_form_number_step_1('sz_google_options_panoramio','panoramio_w_height','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_W_HEIGHT);
	sz_google_common_form_description(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the widget, if you see a value equal "auto", the default size will be 300 pixels.','szgoogleadmin'));
}

function sz_google_admin_panoramio_w_orientation() 
{
	$values = array('horizontal'=>'horizontal','vertical'=>'vertical'); 
	sz_google_common_form_select('sz_google_options_panoramio','panoramio_w_orientation',$values,'medium','');
	sz_google_common_form_description(__('the orientation of the list. Valid values are horizontal and vertical. This controls the position of the arrows, the scrolling direction, and how the photos are sorted. The shape of the list, grid is controlled by the rows and columns options.','szgoogleadmin'));
}

function sz_google_admin_panoramio_w_list_size()
{
	sz_google_common_form_number_step_1('sz_google_options_panoramio','panoramio_w_list_size','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_W_LIST_SIZE);
	sz_google_common_form_description(__('How many photos to show in the list. This option can only be specified with the template photo_list, for the other template, the option will be ignored. The list can be positioned in different ways, set the parameter "position" to the required value.','szgoogleadmin'));
}

function sz_google_admin_panoramio_w_position() 
{
	$values = array('bottom'=>__('position bottom','szgoogleadmin'),'top'=>__('position top','szgoogleadmin'),'left'=>__('position left','szgoogleadmin'),'right'=>__('position right','szgoogleadmin')); 
	sz_google_common_form_select('sz_google_options_panoramio','panoramio_w_position',$values,'medium','');
	sz_google_common_form_description(__('Position of the photo list relative to the single-photo widget. Valid values are left, top, right and bottom. This option is valid only with the template photo_list, for the other template, the option will be ignored. The default value if not specified is "bottom".','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a modulo                      */
/* ************************************************************************** */

function sz_google_admin_panoramio_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_panoramio_active()    {}
function sz_google_admin_panoramio_s_options() {}
function sz_google_admin_panoramio_w_options() {}
