<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_documentation_menu() 
{
	if (function_exists('add_submenu_page')) {
		$pagehook = add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - '.ucwords(__('documentation','szgoogleadmin')),ucwords(__('documentation','szgoogleadmin')),'manage_options','sz-google-admin-documentation.php','sz_google_admin_documentation_callback'); 
		add_action('admin_print_scripts-'.$pagehook,'sz_google_admin_add_plugin');
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al plugin                               */
/* ************************************************************************** */

function sz_google_admin_documentation_fields()
{
	register_setting('sz_google_options_documentation','sz_google_options_documentation','sz_google_admin_documentation_validate');

	// Definizione sezione per configurazione documentazione GOOGLE YOUTUBE 

	add_settings_section('sz_google_documentation_gplus','','sz_google_admin_documentation_gplus','sz-google-admin-documentation-gplus.php');
	add_settings_section('sz_google_documentation_analytics','','sz_google_admin_documentation_analytics','sz-google-admin-documentation-analytics.php');
	add_settings_section('sz_google_documentation_drive','','sz_google_admin_documentation_drive','sz-google-admin-documentation-drive.php');
	add_settings_section('sz_google_documentation_groups','','sz_google_admin_documentation_groups','sz-google-admin-documentation-groups.php');
	add_settings_section('sz_google_documentation_hangouts','','sz_google_admin_documentation_hangouts','sz-google-admin-documentation-hangouts.php');
	add_settings_section('sz_google_documentation_panoramio','','sz_google_admin_documentation_panoramio','sz-google-admin-documentation-panoramio.php');
	add_settings_section('sz_google_documentation_translate','','sz_google_admin_documentation_translate','sz-google-admin-documentation-translate.php');
	add_settings_section('sz_google_documentation_youtube','','sz_google_admin_documentation_youtube','sz-google-admin-documentation-youtube.php');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_documentation_menu');
add_action('admin_init','sz_google_admin_documentation_fields');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google Documentation                   */
/* ************************************************************************** */

function sz_google_admin_documentation_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		'sz-google-admin-documentation-gplus.php'     => ucwords(__('google+','szgoogleadmin')),
		'sz-google-admin-documentation-analytics.php' => ucwords(__('google analytics','szgoogleadmin')),
		'sz-google-admin-documentation-drive.php'     => ucwords(__('google drive','szgoogleadmin')),
		'sz-google-admin-documentation-groups.php'    => ucwords(__('google groups','szgoogleadmin')),
		'sz-google-admin-documentation-hangouts.php'  => ucwords(__('google hangouts','szgoogleadmin')),
		'sz-google-admin-documentation-panoramio.php' => ucwords(__('google panoramio','szgoogleadmin')),
		'sz-google-admin-documentation-translate.php' => ucwords(__('google translate','szgoogleadmin')),
		'sz-google-admin-documentation-youtube.php'   => ucwords(__('youtube','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('quick plugin documentation','szgoogleadmin')),'sz_google_options_documentation',$sections,true); 
}

/* ************************************************************************** */
/* MODULE GOOGLE+ function for create documentation                           */
/* ************************************************************************** */

function sz_google_admin_documentation_gplus()
{
	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$shortcode = array(
		'01' => '[sz-gplus-profile]',
		'02' => '[sz-gplus-page]',
		'03' => '[sz-gplus-community]',
		'04' => '[sz-gplus-followers]',
		'05' => '[sz-gplus-one]',
		'06' => '[sz-gplus-share]',
		'07' => '[sz-gplus-follow]',
		'08' => '[sz-gplus-comments]',
		'09' => '[sz-gplus-post]',
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_gplus_badge_profile()',
		'02' => 'szgoogle_get_gplus_badge_page()',
		'03' => 'szgoogle_get_gplus_badge_community()',
		'04' => 'szgoogle_get_gplus_badge_followers()',
		'05' => 'szgoogle_get_gplus_button_one()',
		'06' => 'szgoogle_get_gplus_button_share()',
		'07' => 'szgoogle_get_gplus_button_follow()',
		'08' => 'szgoogle_get_gplus_comments()',
		'09' => 'szgoogle_get_gplus_post()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('google+ badge for profile','szgoogleadmin'),
		'02' => __('google+ badge for page','szgoogleadmin'),
		'03' => __('google+ badge for community','szgoogleadmin'),
		'04' => __('google+ badge for followers','szgoogleadmin'),
		'05' => __('google+ button for +1','szgoogleadmin'),
		'06' => __('google+ button for sharing','szgoogleadmin'),
		'07' => __('google+ button for follow','szgoogleadmin'),
		'08' => __('google+ comment system','szgoogleadmin'),
		'09' => __('google+ embedded post','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(

		'01' => array(
			'id'           => array(__('profile'             ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'type'         => array(__('type mode'           ,'szgoogleadmin'),'standard, popup','standard'),
			'width'        => array(__('width'               ,'szgoogleadmin'),'integer, auto',__('configuration','szgoogleadmin')),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
			'layout'       => array(__('layout'              ,'szgoogleadmin'),'portrait, landscape','portrait'),
			'theme'        => array(__('theme'               ,'szgoogleadmin'),'light, dark','light'),
			'cover'        => array(__('cover'               ,'szgoogleadmin'),'true, false','true' ),
			'tagline'      => array(__('tagline'             ,'szgoogleadmin'),'true, false','true' ),
			'author'       => array(__('rel=author'          ,'szgoogleadmin'),'true, false','false'),
			'text'         => array(__('pop-up text'         ,'szgoogleadmin'),'string','null'),
			'image'        => array(__('pop-up image URL'    ,'szgoogleadmin'),'string','null'),
		),

		'02' => array(
			'id'           => array(__('page'                ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'type'         => array(__('type mode'           ,'szgoogleadmin'),'standard, popup','standard'),
			'width'        => array(__('width'               ,'szgoogleadmin'),'value, auto',__('configuration','szgoogleadmin')),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
			'layout'       => array(__('layout'              ,'szgoogleadmin'),'portrait, landscape','portrait'),
			'theme'        => array(__('theme'               ,'szgoogleadmin'),'light, dark','light'),
			'cover'        => array(__('cover'               ,'szgoogleadmin'),'true, false','true' ),
			'tagline'      => array(__('tagline'             ,'szgoogleadmin'),'true, false','true' ),
			'publisher'    => array(__('rel=publisher'       ,'szgoogleadmin'),'true, false','false'),
			'text'         => array(__('pop-up text'         ,'szgoogleadmin'),'string','null'),
			'image'        => array(__('pop-up image URL'    ,'szgoogleadmin'),'string','null'),
		),

		'03' => array(
			'id'           => array(__('community'           ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'width'        => array(__('width'               ,'szgoogleadmin'),'value, auto',__('configuration','szgoogleadmin')),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
			'layout'       => array(__('layout'              ,'szgoogleadmin'),'portrait, landscape','portrait'),
			'theme'        => array(__('theme'               ,'szgoogleadmin'),'light, dark','light'),
			'photo'        => array(__('photo'               ,'szgoogleadmin'),'true, false','true' ),
			'owner'        => array(__('owners'              ,'szgoogleadmin'),'true, false','false'),
		),

		'04' => array(
			'id'           => array(__('page or profile'     ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
			'width'        => array(__('width'               ,'szgoogleadmin'),'value, auto',__('configuration','szgoogleadmin')),
			'height'       => array(__('height'              ,'szgoogleadmin'),'value, auto',__('configuration','szgoogleadmin')),
		),

		'05' => array(
			'url'          => array(__('complete URL address','szgoogleadmin'),'string',__('current post','szgoogleadmin')),
			'size'         => array(__('size'                ,'szgoogleadmin'),'small, medium, standard, tail','standard'),
			'width'        => array(__('width'               ,'szgoogleadmin'),'value','null'),
			'annotation'   => array(__('annotation'          ,'szgoogleadmin'),'inline, bubble, none','none'),
			'float'        => array(__('float'               ,'szgoogleadmin'),'left, right, none','none'),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
			'text'         => array(__('text'                ,'szgoogleadmin'),'string','null'),
			'img'          => array(__('image'               ,'szgoogleadmin'),'string','null'),
			'position'     => array(__('position'            ,'szgoogleadmin'),'top, center, bottom, outside','outside'),
			'margintop'    => array(__('margin top'          ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_TOP),
			'marginrigh'   => array(__('margin right'        ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_RIGHT),
			'marginbottom' => array(__('margin bottom'       ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_BOTTOM),
			'marginleft'   => array(__('margin left'         ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_LEFT),
			'marginunit'   => array(__('margin unit'         ,'szgoogleadmin'),'em, pt, px' ,SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_UNITS),
		),

		'06' => array(
			'url'          => array(__('complete URL address','szgoogleadmin'),'string',__('current post','szgoogleadmin')),
			'size'         => array(__('size'                ,'szgoogleadmin'),'small, medium, large','medium'),
			'width'        => array(__('width'               ,'szgoogleadmin'),'value','null'),
			'annotation'   => array(__('annotation'          ,'szgoogleadmin'),'inline, bubble, none','none'),
			'float'        => array(__('float'               ,'szgoogleadmin'),'left, right, none','none'),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
			'text'         => array(__('text'                ,'szgoogleadmin'),'string','null'),
			'img'          => array(__('image'               ,'szgoogleadmin'),'string','null'),
			'position'     => array(__('position'            ,'szgoogleadmin'),'top, center, bottom, outside','outside'),
			'margintop'    => array(__('margin top'          ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_TOP),
			'marginrigh'   => array(__('margin right'        ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_RIGHT),
			'marginbottom' => array(__('margin bottom'       ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_BOTTOM),
			'marginleft'   => array(__('margin left'         ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_LEFT),
			'marginunit'   => array(__('margin unit'         ,'szgoogleadmin'),'em, pt, px' ,SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_UNITS),
		),

		'07' => array(
			'url'          => array(__('URL page or profile' ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'size'         => array(__('size'                ,'szgoogleadmin'),'small, medium, large','medium'),
			'width'        => array(__('width'               ,'szgoogleadmin'),'value','null'),
			'annotation'   => array(__('annotation'          ,'szgoogleadmin'),'inline, bubble, none','none'),
			'float'        => array(__('float'               ,'szgoogleadmin'),'left, right, none','none'),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
			'rel'          => array(__('relation'            ,'szgoogleadmin'),'author, publisher, none','none'),
			'text'         => array(__('text'                ,'szgoogleadmin'),'string','null'),
			'img'          => array(__('image'               ,'szgoogleadmin'),'string','null'),
			'position'     => array(__('position'            ,'szgoogleadmin'),'top, center, bottom, outside','outside'),
			'margintop'    => array(__('margin top'          ,'szgoogleadmin'),'integer, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_TOP),
			'marginrigh'   => array(__('margin right'        ,'szgoogleadmin'),'integer, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_RIGHT),
			'marginbottom' => array(__('margin bottom'       ,'szgoogleadmin'),'integer, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_BOTTOM),
			'marginleft'   => array(__('margin left'         ,'szgoogleadmin'),'integer, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_LEFT),
			'marginunit'   => array(__('margin unit'         ,'szgoogleadmin'),'em, pt, px',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_UNITS),
		),

		'08' => array(
			'url'          => array(__('complete URL address','szgoogleadmin'),'string',__('current post','szgoogleadmin')),
			'width'        => array(__('fixed width'         ,'szgoogleadmin'),'value, auto','auto'),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
		),

		'09' => array(
			'url'          => array(__('complete URL address','szgoogleadmin'),'string',__('current post','szgoogleadmin')),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
		),
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sullo shortcode 

	$shortcode_example = array(
		'01' => '[sz-gplus-profile id="106567288702045182616"/]',
		'02' => '[sz-gplus-page id="117259631219963935481"/]',
		'03' => '[sz-gplus-community id="109254048492234113886"/]',
		'04' => '[sz-gplus-followers id="106567288702045182616"/]',
		'05' => '[sz-gplus-one size="medium" annotation="bubble"/]',
		'06' => '[sz-gplus-share size="small" annotation="bubble"/]',
		'07' => '[sz-gplus-follow size="medium"/]',
		'08' => '[sz-gplus-comments url="https://startbyzero.com/webmaster" width="600"/]',
		'09' => '[sz-gplus-post url="URL_GOOGLE_PLUS_POST" align="center"/]',
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => 'szgoogle_get_gplus_badge_profile(array("id"=>"106567288702045182616"));',
		'02' => 'szgoogle_get_gplus_badge_page(array("id"=>"117259631219963935481"));',
		'03' => 'szgoogle_get_gplus_badge_community(array("id"=>"109254048492234113886"));',
		'04' => 'szgoogle_get_gplus_badge_followers(array("id"=>"106567288702045182616"));',
		'05' => 'szgoogle_get_gplus_button_one(array("size"=>"medium"));',
		'06' => 'szgoogle_get_gplus_button_share(array("size"=>"small"));',
		'07' => 'szgoogle_get_gplus_button_follow(array("size"=>"medium"));',
		'08' => 'szgoogle_get_gplus_comments(array("width"=>"600"));',
		'09' => 'szgoogle_get_gplus_post(array("align"=>"center"));',
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for shortcodes - badges','szgoogleadmin'),array(
		array($shortcode['01'],$description['01'],$options['01'],$shortcode_example['01']),
		array($shortcode['02'],$description['02'],$options['02'],$shortcode_example['02']),
		array($shortcode['03'],$description['03'],$options['03'],$shortcode_example['03']),
		array($shortcode['04'],$description['04'],$options['04'],$shortcode_example['04']),
	));

	echo sz_google_admin_documentation_table(__('documentation for shortcodes - buttons','szgoogleadmin'),array(
		array($shortcode['05'],$description['05'],$options['05'],$shortcode_example['05']),
		array($shortcode['06'],$description['06'],$options['06'],$shortcode_example['06']),
		array($shortcode['07'],$description['07'],$options['07'],$shortcode_example['07']),
	));

	echo sz_google_admin_documentation_table(__('documentation for shortcodes - widgets','szgoogleadmin'),array(
		array($shortcode['08'],$description['08'],$options['08'],$shortcode_example['08']),
		array($shortcode['09'],$description['09'],$options['09'],$shortcode_example['09']),
	));

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for PHP functions - badges','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
		array($functions['02'],$description['02'],$options['02'],$function_example['02']),
		array($functions['03'],$description['03'],$options['03'],$function_example['03']),
		array($functions['04'],$description['04'],$options['04'],$function_example['04']),
	));

	echo sz_google_admin_documentation_table(__('documentation for PHP functions - buttons','szgoogleadmin'),array(
		array($functions['05'],$description['05'],$options['05'],$function_example['05']),
		array($functions['06'],$description['06'],$options['06'],$function_example['06']),
		array($functions['07'],$description['07'],$options['07'],$function_example['07']),
	));

	echo sz_google_admin_documentation_table(__('documentation for PHP functions - widgets','szgoogleadmin'),array(
		array($functions['08'],$description['08'],$options['08'],$function_example['08']),
		array($functions['09'],$description['09'],$options['09'],$function_example['09']),
	));
}

/* ************************************************************************** */
/* MODULE GOOGLE ANALYTICS function for create documentation                  */
/* ************************************************************************** */

function sz_google_admin_documentation_analytics() 
{
	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_ga_ID()',
		'02' => 'szgoogle_get_ga_code()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('google analytics get account ID','szgoogleadmin'),
		'02' => __('google analytics get tracking code','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(

		'01' => array(),

		'02' => array(
			'ga_uacode'               => array(__('UA code'                 ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'ga_position'             => array(__('position'                ,'szgoogleadmin'),'H=Header,F=Footer',__('configuration','szgoogleadmin')),
			'ga_enable_front'         => array(__('enable for front'        ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'ga_enable_admin'         => array(__('enable for admin'        ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'ga_enable_administrator' => array(__('enable for administrator','szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'ga_enable_logged'        => array(__('enable for logged'       ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'ga_enable_subdomain'     => array(__('enable for subdomain'    ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'ga_enable_multiple'      => array(__('enable for multiple'     ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'ga_enable_advertiser'    => array(__('enable for advertiser'   ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
		),
	);

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => '$id = szgoogle_get_ga_ID();',
		'02' => '$code = szgoogle_get_ga_code();',
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
		array($functions['02'],$description['02'],$options['02'],$function_example['02']),
	));
}

/* ************************************************************************** */
/* MODULE GOOGLE DRIVE function for create documentation                      */
/* ************************************************************************** */

function sz_google_admin_documentation_drive()
{
	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$shortcode = array(
		'01' => '[sz-drive-save]',
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_drive_savebutton()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('google drive save button','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(

		'01' => array(
			'url'          => array(__('URL address file','szgoogleadmin'),'string',__('current post','szgoogleadmin')),
			'filename'     => array(__('name of file'    ,'szgoogleadmin'),'small, medium, standard, tail','standard'),
			'sitename'     => array(__('name of site'    ,'szgoogleadmin'),'value' ,'null'),
			'text'         => array(__('text'            ,'szgoogleadmin'),'string','null'),
			'img'          => array(__('image'           ,'szgoogleadmin'),'string','null'),
			'position'     => array(__('position'        ,'szgoogleadmin'),'top, center, bottom, outside','outside'),
			'align'        => array(__('alignment'       ,'szgoogleadmin'),'left, center, right, none','none'),
			'margintop'    => array(__('margin top'      ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_TOP),
			'marginrigh'   => array(__('margin right'    ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_RIGHT),
			'marginbottom' => array(__('margin bottom'   ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_BOTTOM),
			'marginleft'   => array(__('margin left'     ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_LEFT),
			'marginunit'   => array(__('margin unit'     ,'szgoogleadmin'),'em, pt, px' ,SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_UNITS),
		),
	);

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sullo shortcode 

	$shortcode_example = array(
		'01' => '[sz-drive-save url="/public/images/myphoto.jpg"/]',
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => 'szgoogle_get_drive_savebutton(array("url"=>"/public/images/myphoto.jpg"));',
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for shortcodes','szgoogleadmin'),array(
		array($shortcode['01'],$description['01'],$options['01'],$shortcode_example['01']),
	));

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
	));
}


function sz_google_admin_documentation_groups()
{

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$shortcode = array(
		'01' => '[sz-ggroups]',
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_groups_code()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('google groups embedded widget ','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(
		'01' => array(
			'name'           => array(__('name of groups','szgoogleadmin'),'string'       ,__('configuration','szgoogleadmin')),
			'width'          => array(__('width'         ,'szgoogleadmin'),'value'        ,__('configuration','szgoogleadmin')),
			'height'         => array(__('height'        ,'szgoogleadmin'),'value'        ,__('configuration','szgoogleadmin')),
			'showsearch'     => array(__('display search','szgoogleadmin'),'true, false'  ,__('configuration','szgoogleadmin')),
			'showtabs'       => array(__('display tabs'  ,'szgoogleadmin'),'true, false'  ,__('configuration','szgoogleadmin')),
			'hideforumtitle' => array(__('hidden title'  ,'szgoogleadmin'),'true, false'  ,__('configuration','szgoogleadmin')),
			'hidesubject'    => array(__('hidden subject','szgoogleadmin'),'true, false'  ,__('configuration','szgoogleadmin')),
			'hl'             => array(__('language'      ,'szgoogleadmin'),'language code',__('configuration','szgoogleadmin')),
		),
	);

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sullo shortcode 

	$shortcode_example = array(
		'01' => '[sz-ggroups name="adsense-api" showtabs="false"/]',
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => 'echo szgoogle_get_groups_code(array("name"=>"adsense-api"));',
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for shortcodes','szgoogleadmin'),array(
		array($shortcode['01'],$description['01'],$options['01'],$shortcode_example['01']),
	));

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
	));
}


function sz_google_admin_documentation_hangouts()
{
	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$shortcode = array(
		'01' => '[sz-hangouts-start]',
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_hangouts_code_start()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('hangout button start','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(
		'01' => array(
			'type'         => array(__('type'                ,'szgoogleadmin'),'normal, onair, party, moderated','normal'),
			'topic'        => array(__('topic'               ,'szgoogleadmin'),'string','null'),
			'width'        => array(__('width'               ,'szgoogleadmin'),'value, auto','auto'),
			'float'        => array(__('float'               ,'szgoogleadmin'),'left, right, none','none'),
			'align'        => array(__('alignment'           ,'szgoogleadmin'),'left, center, right, none','none'),
			'text'         => array(__('text'                ,'szgoogleadmin'),'string','null'),
			'img'          => array(__('image'               ,'szgoogleadmin'),'string','null'),
			'position'     => array(__('position'            ,'szgoogleadmin'),'top, center, bottom, outside','outside'),
			'margintop'    => array(__('margin top'          ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_TOP),
			'marginrigh'   => array(__('margin right'        ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_RIGHT),
			'marginbottom' => array(__('margin bottom'       ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_BOTTOM),
			'marginleft'   => array(__('margin left'         ,'szgoogleadmin'),'value, none',SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_LEFT),
			'marginunit'   => array(__('margin unit'         ,'szgoogleadmin'),'em, pt, px' ,SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_UNITS),
		),
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sullo shortcode 

	$shortcode_example = array(
		'01' => '[sz-hangout-start type="onair"/]',
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => 'szgoogle_get_hangouts_start(array("type"=>"onair"));',
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for shortcodes','szgoogleadmin'),array(
		array($shortcode['01'],$description['01'],$options['01'],$shortcode_example['01']),
	));

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
	));
}

/* ************************************************************************** */
/* MODULE GOOGLE TRANSLATE function for create documentation                  */
/* ************************************************************************** */

function sz_google_admin_documentation_translate() 
{
	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$shortcode = array(
		'01' => '[sz-translate]',
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_translate_code()',
		'02' => 'szgoogle_get_translate_meta()',
		'03' => 'szgoogle_get_translate_meta_ID()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('google translate widget','szgoogleadmin'),
		'02' => __('google translate get meta code','szgoogleadmin'),
		'03' => __('google translate get meta ID','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(
		'01' => array(
			'language'  => array(__('language for widget','szgoogleadmin'),'string'     ,__('configuration','szgoogleadmin')),
			'mode'      => array(__('display mode'       ,'szgoogleadmin'),'V, H, D'    ,__('configuration','szgoogleadmin')),
			'automatic' => array(__('automatic banner'   ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'analytics' => array(__('google analytics'   ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'uacode'    => array(__('google analytics UA','szgoogleadmin'),'string'     ,__('configuration','szgoogleadmin')),
		),
	);

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sullo shortcode 

	$shortcode_example = array(
		'01' => '[sz-translate language="it" mode="V"/]',
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => 'echo szgoogle_get_translate_code(array("parameter"=>"value"));',
		'02' => 'echo szgoogle_get_translate_meta();',
		'03' => 'echo szgoogle_get_translate_meta_ID();',
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for shortcodes','szgoogleadmin'),array(
		array($shortcode['01'],$description['01'],$options['01'],$shortcode_example['01']),
	));

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
		array($functions['02'],$description['02'],array(),$function_example['02']),
		array($functions['03'],$description['03'],array(),$function_example['03']),
	));
}

/* ************************************************************************** */
/* MODULE GOOGLE PANORAMIO function for create documentation                  */
/* ************************************************************************** */

function sz_google_admin_documentation_panoramio()
{
	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$shortcode = array(
		'01' => '[sz-panoramio]',
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_panoramio_code()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('google panoramio widget','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(

		'01' => array(
			'template'     => array(__('widget type'            ,'szgoogleadmin'),'photo,slideshow,list,photo_list',SZ_PLUGIN_GOOGLE_PANORAMIO_S_TEMPLATE),
			'user'         => array(__('search for user'        ,'szgoogleadmin'),'string','null'),
			'group'        => array(__('search for group'       ,'szgoogleadmin'),'string','null'),
			'tag'          => array(__('search for tag'         ,'szgoogleadmin'),'string','null'),
			'set'          => array(__('select type'            ,'szgoogleadmin'),'all,public,recent','all'),
			'widht'        => array(__('widget width in pixels' ,'szgoogleadmin'),'numeric'                 ,SZ_PLUGIN_GOOGLE_PANORAMIO_S_WIDTH),
			'height'       => array(__('widget height in pixels','szgoogleadmin'),'numeric'                 ,SZ_PLUGIN_GOOGLE_PANORAMIO_S_HEIGHT),
			'bgcolor'      => array(__('background color'       ,'szgoogleadmin'),'hexadecimal','null'),
			'columns'      => array(__('columns of photos'      ,'szgoogleadmin'),'numeric'                 ,SZ_PLUGIN_GOOGLE_PANORAMIO_S_COLUMNS),
			'rows'         => array(__('rows of photos'         ,'szgoogleadmin'),'numeric'                 ,SZ_PLUGIN_GOOGLE_PANORAMIO_S_ROWS),
			'orientation'  => array(__('orientation of the list','szgoogleadmin'),'horizontal,vertical'     ,SZ_PLUGIN_GOOGLE_PANORAMIO_S_ORIENTATION),
			'list_size'    => array(__('photos the list'        ,'szgoogleadmin'),'numeric'                 ,SZ_PLUGIN_GOOGLE_PANORAMIO_S_LIST_SIZE),
			'position'     => array(__('position photo list'    ,'szgoogleadmin'),'left,top,right,bottom'   ,SZ_PLUGIN_GOOGLE_PANORAMIO_S_POSITION),
			'delay'        => array(__('delay in seconds'       ,'szgoogleadmin'),'numeric'                 ,SZ_PLUGIN_GOOGLE_PANORAMIO_S_DELAY),
			'paragraph'    => array(__('dummy paragraph'        ,'szgoogleadmin'),'true,false','true'),
		),
	);

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sullo shortcode 

	$shortcode_example = array(
		'01' => '[sz-panoramio template="slideshow" delay="2.0"/]',
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => 'szgoogle_get_drive_savebutton(array("template"=>"photo"));',
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for shortcodes','szgoogleadmin'),array(
		array($shortcode['01'],$description['01'],$options['01'],$shortcode_example['01']),
	));

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
	));
}

/* ************************************************************************** */
/* MODULE GOOGLE YOUTUBE function for create documentation                   */
/* ************************************************************************** */

function sz_google_admin_documentation_youtube() 
{
	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$shortcode = array(
		'01' => '[sz-ytvideo]',
		'02' => '[sz-ytplaylist]',
		'03' => '[sz-ytbadge]',
		'04' => '[sz-ytbutton]',
		'05' => '[sz-ytlink]',
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_youtube_code_video()',
		'02' => 'szgoogle_get_youtube_code_playlist()',
		'03' => 'szgoogle_get_youtube_code_badge()',
		'04' => 'szgoogle_get_youtube_code_button()',
		'05' => 'szgoogle_get_youtube_code_link()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('youtube video','szgoogleadmin'),
		'02' => __('youtube playlist','szgoogleadmin'),
		'03' => __('youtube channel badge','szgoogleadmin'),
		'04' => __('youtube channel button','szgoogleadmin'),
		'05' => __('youtube channel link','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(

		'01' => array(
			'url'             => array(__('youtube address URL'    ,'szgoogleadmin'),'string','null'),
			'responsive'      => array(__('responsive mode'        ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'width'           => array(__('size pixel width'       ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'height'          => array(__('size pixel height'      ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'margintop'       => array(__('margin top'             ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'marginright'     => array(__('margin right'           ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'marginbottom'    => array(__('margin bottom'          ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'marginleft'      => array(__('margin left'            ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'marginunit'      => array(__('margin unit'            ,'szgoogleadmin'),'px, em',__('configuration','szgoogleadmin')),
			'autoplay'        => array(__('enable autoplay'        ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'loop'            => array(__('enable loop'            ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'fullscreen'      => array(__('enable fullscreen'      ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'disablekeyboard' => array(__('disable keyboard'       ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'theme'           => array(__('theme name'             ,'szgoogleadmin'),'dark, light',__('configuration','szgoogleadmin')),
			'cover'           => array(__('cover image'            ,'szgoogleadmin'),'local, youtube, URL, ID',__('configuration','szgoogleadmin')),
			'title'           => array(__('title for video'        ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'disableiframe'   => array(__('disable IFRAME mode'    ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'analytics'       => array(__('enable google analytics','szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'delayed'         => array(__('enable loading delayed' ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'start'           => array(__('time of start'          ,'szgoogleadmin'),'seconds','null'),
			'end'             => array(__('time of end'            ,'szgoogleadmin'),'seconds','null'),
			'disablerelated'  => array(__('deactive related video' ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'schemaorg'       => array(__('schema.org enable'      ,'szgoogleadmin'),'y=yes, n=no',__('configuration','szgoogleadmin')),
			'name'            => array(__('schema.org name'        ,'szgoogleadmin'),'string',__('youtube video','szgoogleadmin')),
			'description'     => array(__('schema.org description' ,'szgoogleadmin'),'string',__('value of title','szgoogleadmin')),
			'duration'        => array(__('schema.org duration'    ,'szgoogleadmin'),__('<a target="_blank" href="http://en.wikipedia.org/wiki/ISO_8601">format ISO 8601</a>','szgoogleadmin'),'null'),
		),

		'02' => array(
			'id'              => array(__('youtube playlist ID'    ,'szgoogleadmin'),'string','null'),
			'width'           => array(__('size pixel width'       ,'szgoogleadmin'),'value,auto',__('configuration','szgoogleadmin')),
			'height'          => array(__('size pixel height'      ,'szgoogleadmin'),'value,auto',__('configuration','szgoogleadmin')),
			'margintop'       => array(__('margin top'             ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'marginright'     => array(__('margin right'           ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'marginbottom'    => array(__('margin bottom'          ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'marginleft'      => array(__('margin left'            ,'szgoogleadmin'),'value',__('configuration','szgoogleadmin')),
			'marginunit'      => array(__('margin unit'            ,'szgoogleadmin'),'px, em',__('configuration','szgoogleadmin')),
		),

		'03' => array(
			'channel'         => array(__('channel name or ID'     ,'szgoogleadmin'),'string'   ,__('configuration','szgoogleadmin')),
			'width'           => array(__('size pixel width'       ,'szgoogleadmin'),'value'    ,'300'),
			'height'          => array(__('size pixel height'      ,'szgoogleadmin'),'value'    ,'150'),
			'widthunit'       => array(__('unit for width'         ,'szgoogleadmin'),'px, em, %','px' ),
			'heightunit'      => array(__('unit for height'        ,'szgoogleadmin'),'px, em, %','px' ),
		),

		'04' => array(
			'channel'         => array(__('channel name or ID'     ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'layout'          => array(__('layout type'            ,'szgoogleadmin'),'default, full','default'),
			'theme'           => array(__('theme for button'       ,'szgoogleadmin'),'default, dark','default'),
		),

		'05' => array(
			'channel'         => array(__('channel name or ID'     ,'szgoogleadmin'),'string',__('configuration','szgoogleadmin')),
			'subscription'    => array(__('subscription mode'      ,'szgoogleadmin'),'y=yes, n=no','y=yes'),
			'text'            => array(__('anchor text for link'   ,'szgoogleadmin'),'string',__('channel youtube','szgoogleadmin')),
		),

	);

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sullo shortcode 

	$shortcode_example = array(
		'01' => '[sz-ytvideo url="http://www.youtube.com/watch?v=Xz2unftv_l4"/]',
		'02' => '[sz-ytplaylist id="PL1wZKxf9cUnICoU0usAWMbyURT40rJD71"/]',
		'03' => '[sz-ytbadge channel="startbyzero"/]',
		'04' => '[sz-ytbutton layout="full" theme="dark"/]',
		'05' => '[sz-ytlink text="iscriviti al mio canale"/]',
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => "echo szgoogle_get_youtube_code_video(array('parameter'=>'value'));",
		'02' => "echo szgoogle_get_youtube_code_playlist(array('parameter'=>'value'));",
		'03' => "echo szgoogle_get_youtube_code_badge(array('parameter'=>'value'));",
		'04' => "echo szgoogle_get_youtube_code_button(array('parameter'=>'value'));",
		'05' => "echo szgoogle_get_youtube_code_link(array('parameter'=>'value'));",
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for shortcodes','szgoogleadmin'),array(
		array($shortcode['01'],$description['01'],$options['01'],$shortcode_example['01']),
		array($shortcode['02'],$description['02'],$options['02'],$shortcode_example['02']),
		array($shortcode['03'],$description['03'],$options['03'],$shortcode_example['03']),
		array($shortcode['04'],$description['04'],$options['04'],$shortcode_example['04']),
		array($shortcode['05'],$description['05'],$options['05'],$shortcode_example['05']),
	));

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
		array($functions['02'],$description['02'],$options['02'],$function_example['02']),
		array($functions['03'],$description['03'],$options['03'],$function_example['03']),
		array($functions['04'],$description['04'],$options['04'],$function_example['04']),
		array($functions['05'],$description['05'],$options['05'],$function_example['05']),
	));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a modulo                      */
/* ************************************************************************** */

function sz_google_admin_documentation_validate($plugin_options) {
  return $plugin_options;
}

/* ************************************************************************** */
/* Funzioni per contenuto documentazione con stampa della tabella             */
/* ************************************************************************** */

function sz_google_admin_documentation_table($title,$values)
{
	echo '<div class="postbox closed">';
	echo '<div class="handlediv" title="Click to toggle"><br></div>';
	echo '<h3 class="hndle"><span>'.ucfirst($title).'</span></h3>';
	echo '<div class="inside">';

	foreach ($values as $key=>$value) 
	{
		$name    = $value[0];
		$titolo  = $value[1];
		$tabella = $value[2];
		$esempio = $value[3];

		echo '<table class="docs"><tr>';

		if ($titolo) {
			echo '<tr>';
			echo '<th class="tit" colspan="4"><h4 style="font-size:1.1em;">'.ucfirst($titolo).'</span><span style="float:right;color:green">'.$name.'</span></h4></th>';
			echo '</tr>';
		}

		if (!empty($tabella)) {
			echo "<th>".__('parameter','szgoogleadmin')."</th>";
			echo "<th>".__('description','szgoogleadmin')."</th>";
			echo "<th>".__('values','szgoogleadmin')."</th>";
			echo "<th>".__('default','szgoogleadmin')."</th></tr>";
		}

		foreach ($tabella as $key => $value) { 
			echo "<tr>";
			echo '<td class="key">'.$key."</td>";
			echo '<td class="des">'.$value[0]."</td>";
			echo '<td class="val">'.$value[1]."</td>";
			echo '<td class="def">'.$value[2]."</td>";
			echo "</tr>";
		}

		if ($esempio) {
			echo "<tr>";
			echo '<td class="key">'.__('example','szgoogleadmin').'</td>';
			echo '<td colspan="3"><code>'.$esempio."</code></td>";
			echo "</tr>";
		}

		echo "</table>";
	}

	echo "</div>";
	echo "</div>";
}