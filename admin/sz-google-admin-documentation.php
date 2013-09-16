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
		add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - '.ucwords(__('documentation','szgoogleadmin')),ucwords(__('documentation','szgoogleadmin')),'manage_options','sz-google-admin-documentation.php','sz_google_admin_documentation_callback'); 
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
	add_settings_section('sz_google_documentation_groups','','sz_google_admin_documentation_groups','sz-google-admin-documentation-groups.php');
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
		'sz-google-admin-documentation-groups.php'    => ucwords(__('google groups','szgoogleadmin')),
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
			'id'         => array(__('profile id','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'width'      => array(__('widget width','szgoogleadmin'),__('integer,auto','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'align'      => array(__('widget alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'layout'     => array(__('widget layout','szgoogleadmin'),__('portrait,landscape','szgoogleadmin'),__('portrait','szgoogleadmin')),
			'theme'      => array(__('widget theme','szgoogleadmin'),__('light,dark','szgoogleadmin'),__('light','szgoogleadmin')),
			'cover'      => array(__('widget cover','szgoogleadmin'),__('true,false','szgoogleadmin'),__('true','szgoogleadmin')),
			'tagline'    => array(__('widget tagline','szgoogleadmin'),__('true,false','szgoogleadmin'),__('true','szgoogleadmin')),
			'author'     => array(__('widget rel=author','szgoogleadmin'),__('true,false','szgoogleadmin'),__('false','szgoogleadmin')),
		),

		'02' => array(
			'id'         => array(__('page id','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'width'      => array(__('widget width','szgoogleadmin'),__('integer,auto','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'align'      => array(__('widget alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'layout'     => array(__('widget layout','szgoogleadmin'),__('portrait,landscape','szgoogleadmin'),__('portrait','szgoogleadmin')),
			'theme'      => array(__('widget theme','szgoogleadmin'),__('light,dark','szgoogleadmin'),__('light','szgoogleadmin')),
			'cover'      => array(__('widget cover','szgoogleadmin'),__('true,false','szgoogleadmin'),__('true','szgoogleadmin')),
			'tagline'    => array(__('widget tagline','szgoogleadmin'),__('true,false','szgoogleadmin'),__('true','szgoogleadmin')),
			'publisher'  => array(__('widget rel=publisher','szgoogleadmin'),__('true,false','szgoogleadmin'),__('false','szgoogleadmin')),
		),

		'03' => array(
			'id'         => array(__('community id','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'width'      => array(__('widget width','szgoogleadmin'),__('integer,auto','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'align'      => array(__('widget alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'layout'     => array(__('widget layout','szgoogleadmin'),__('portrait,landscape','szgoogleadmin'),__('portrait','szgoogleadmin')),
			'theme'      => array(__('widget theme','szgoogleadmin'),__('light,dark','szgoogleadmin'),__('light','szgoogleadmin')),
			'photo'      => array(__('widget photo','szgoogleadmin'),__('true,false','szgoogleadmin'),__('true','szgoogleadmin')),
			'owner'      => array(__('widget owners','szgoogleadmin'),__('true,false','szgoogleadmin'),__('false','szgoogleadmin')),
		),

		'04' => array(
			'id'         => array(__('page id or profile id','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'align'      => array(__('widget alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'width'      => array(__('widget width','szgoogleadmin'),__('integer,auto','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'height'     => array(__('widget height','szgoogleadmin'),__('integer,auto','szgoogleadmin'),__('configuration','szgoogleadmin')),
		),

		'05' => array(
			'url'        => array(__('complete URL address','szgoogleadmin'),__('string','szgoogleadmin'),__('current post','szgoogleadmin')),
			'size'       => array(__('button size','szgoogleadmin'),__('small,medium,standard,tail','szgoogleadmin'),__('standard','szgoogleadmin')),
			'width'      => array(__('button width','szgoogleadmin'),__('integer','szgoogleadmin'),__('null','szgoogleadmin')),
			'annotation' => array(__('button annotation','szgoogleadmin'),__('inline,bubble,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'align'      => array(__('button alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'text'       => array(__('button wrap text','szgoogleadmin'),__('string','szgoogleadmin'),__('null','szgoogleadmin')),
			'img'        => array(__('button wrap image','szgoogleadmin'),__('string','szgoogleadmin'),__('null','szgoogleadmin')),
			'position'   => array(__('button wrap position','zgoogleadmin'),__('top,center,bottom,outside','szgoogleadmin'),__('outside','szgoogleadmin')),
		),

		'06' => array(
			'url'        => array(__('complete URL address','szgoogleadmin'),__('string','szgoogleadmin'),__('current post','szgoogleadmin')),
			'size'       => array(__('button size','szgoogleadmin'),__('small,medium,standard,tail','szgoogleadmin'),__('standard','szgoogleadmin')),
			'width'      => array(__('button width','szgoogleadmin'),__('integer','szgoogleadmin'),__('null','szgoogleadmin')),
			'annotation' => array(__('button annotation','szgoogleadmin'),__('inline,bubble,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'align'      => array(__('button alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'text'       => array(__('button wrap text','szgoogleadmin'),__('string','szgoogleadmin'),__('null','szgoogleadmin')),
			'img'        => array(__('button wrap image','szgoogleadmin'),__('string','szgoogleadmin'),__('null','szgoogleadmin')),
			'position'   => array(__('button wrap position','zgoogleadmin'),__('top,center,bottom,outside','szgoogleadmin'),__('outside','szgoogleadmin')),
		),

		'07' => array(
			'url'        => array(__('URL google+ page or profile','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'size'       => array(__('button size','szgoogleadmin'),__('small,medium,large','szgoogleadmin'),__('medium','szgoogleadmin')),
			'width'      => array(__('button width','szgoogleadmin'),__('integer','szgoogleadmin'),__('null','szgoogleadmin')),
			'annotation' => array(__('button annotation','szgoogleadmin'),__('inline,bubble,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'align'      => array(__('button alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'rel'        => array(__('button relation','zgoogleadmin'),__('author,publisher,none','szgoogleadmin'),__('none','szgoogleadmin')),
			'text'       => array(__('button wrap text','szgoogleadmin'),__('string','szgoogleadmin'),__('null','szgoogleadmin')),
			'img'        => array(__('button wrap image','szgoogleadmin'),__('string','szgoogleadmin'),__('null','szgoogleadmin')),
			'position'   => array(__('button wrap position','zgoogleadmin'),__('top,center,bottom,outside','szgoogleadmin'),__('outside','szgoogleadmin')),
		),

		'08' => array(
			'url'        => array(__('complete URL address','szgoogleadmin'),__('string','szgoogleadmin'),__('current post','szgoogleadmin')),
			'width'      => array(__('widget fixed width','szgoogleadmin'),__('integer,auto','szgoogleadmin'),__('auto','szgoogleadmin')),
			'align'      => array(__('widget alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
		),

		'09' => array(
			'url'        => array(__('complete URL address','szgoogleadmin'),__('string','szgoogleadmin'),__('current post','szgoogleadmin')),
			'align'      => array(__('widget alignment','szgoogleadmin'),__('left,center,right,none','szgoogleadmin'),__('none','szgoogleadmin')),
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

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => '$id = szgoogle_get_ga_ID();',
		'02' => '$code = szgoogle_get_ga_code();',
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],array(),$function_example['01']),
		array($functions['02'],$description['02'],array(),$function_example['02']),
	));
}

/* ************************************************************************** */
/* MODULE GOOGLE GROUPS function for create documentation                  */
/* ************************************************************************** */

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
			'name'           => array(__('name of groups','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'width'          => array(__('widget width','szgoogleadmin'),__('integer','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'height'         => array(__('widget height','szgoogleadmin'),__('integer','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'showsearch'     => array(__('widget display search','szgoogleadmin'),__('true,false','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'showtabs'       => array(__('widget display tabs','szgoogleadmin'),__('true,false','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'hideforumtitle' => array(__('widget hidden title','szgoogleadmin'),__('true,false','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'hidesubject'    => array(__('widget hidden subject','szgoogleadmin'),__('true,false','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'hl'             => array(__('widget language','szgoogleadmin'),__('language code','szgoogleadmin'),__('configuration','szgoogleadmin')),
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
			'language'  => array(__('language for widget','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'mode'      => array(__('display mode','szgoogleadmin'),__('V,H,D','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'automatic' => array(__('automatic banner','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'analytics' => array(__('google analytics','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'uacode'    => array(__('google analytics UA','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
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
/* MODULE GOOGLE YOUTUBE function for create documentation                   */
/* ************************************************************************** */

function sz_google_admin_documentation_youtube() 
{
	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$shortcode = array(
		'01' => '[sz-ytvideo]',
		'02' => '[sz-ytbadge]',
		'03' => '[sz-ytbutton]',
		'04' => '[sz-ytlink]',
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'01' => 'szgoogle_get_youtube_code_video()',
		'02' => 'szgoogle_get_youtube_code_badge()',
		'03' => 'szgoogle_get_youtube_code_button()',
		'04' => 'szgoogle_get_youtube_code_link()',
	); 

	// Definizione elenco degli shortcode presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$description = array(
		'01' => __('youtube video','szgoogleadmin'),
		'02' => __('youtube channel badge','szgoogleadmin'),
		'03' => __('youtube channel button','szgoogleadmin'),
		'04' => __('youtube channel link','szgoogleadmin'),
	); 

	// Definizione elenco parametri con valori consentiti e di default che sono
	// collegati alo shortcode interessato, molti parametri valgono anche per le funzioni

	$options = array(

		'01' => array(
			'url'             => array(__('youtube address URL','szgoogleadmin'),__('string','szgoogleadmin'),__('nobody','szgoogleadmin')),
			'responsive'      => array(__('responsive mode','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'width'           => array(__('size pixel width','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'height'          => array(__('size pixel height','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'margintop'       => array(__('margin top','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'marginright'     => array(__('margin right','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'marginbottom'    => array(__('margin bottom','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'marginleft'      => array(__('margin left','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'marginunit'      => array(__('margin unit','szgoogleadmin'),__('px,em','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'autoplay'        => array(__('enable autoplay','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'loop'            => array(__('enable loop','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'fullscreen'      => array(__('enable fullscreen','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'disablekeyboard' => array(__('disable keyboard','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'theme'           => array(__('theme name','szgoogleadmin'),__('dark,light','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'cover'           => array(__('cover image','szgoogleadmin'),__('local,youtube,URL,ID','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'title'           => array(__('title for video','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'disableiframe'   => array(__('disable IFRAME mode','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'analytics'       => array(__('enable google analytics','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'delayed'         => array(__('enable loading delayed','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'start'           => array(__('time of start','szgoogleadmin'),__('numeric value seconds','szgoogleadmin'),__('nobody','szgoogleadmin')),
			'end'             => array(__('time of end','szgoogleadmin'),__('numeric value seconds','szgoogleadmin'),__('nobody','szgoogleadmin')),
			'disablerelated'  => array(__('deactive related video','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'schemaorg'       => array(__('schema.org enable','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'name'            => array(__('schema.org name','szgoogleadmin'),__('string','szgoogleadmin'),__('youtube video','szgoogleadmin')),
			'description'     => array(__('schema.org description','szgoogleadmin'),__('string','szgoogleadmin'),__('value of title','szgoogleadmin')),
			'duration'        => array(__('schema.org duration','szgoogleadmin'),__('<a target="_blank" href="http://en.wikipedia.org/wiki/ISO_8601">format ISO 8601</a>','szgoogleadmin'),__('nobody','szgoogleadmin')),
		),

		'02' => array(
			'channel'         => array(__('channel name or ID','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'width'           => array(__('size pixel width','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('300','szgoogleadmin')),
			'height'          => array(__('size pixel height','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('150','szgoogleadmin')),
			'widthunit'       => array(__('unit for width','szgoogleadmin'),__('px,em,%','szgoogleadmin'),__('px','szgoogleadmin')),
			'heightunit'      => array(__('unit for height','szgoogleadmin'),__('px,em,%','szgoogleadmin'),__('px','szgoogleadmin')),
		),

		'03' => array(
			'channel'         => array(__('channel name or ID','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'layout'          => array(__('layout type','szgoogleadmin'),__('default,full','szgoogleadmin'),__('default','szgoogleadmin')),
			'theme'           => array(__('theme for button','szgoogleadmin'),__('default,dark','szgoogleadmin'),__('default','szgoogleadmin')),
		),

		'04' => array(
			'channel'         => array(__('channel name or ID','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
			'subscription'    => array(__('subscription mode','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('y=yes','szgoogleadmin')),
			'text'            => array(__('anchor text for link','szgoogleadmin'),__('string','szgoogleadmin'),__('channel youtube','szgoogleadmin')),
		),

	);

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sullo shortcode 

	$shortcode_example = array(
		'01' => '[sz-ytvideo url="http://www.youtube.com/watch?v=Xz2unftv_l4"/]',
		'02' => '[sz-ytbadge channel="startbyzero"/]',
		'03' => '[sz-ytbutton layout="full" theme="dark"/]',
		'04' => '[sz-ytlink text="iscriviti al mio canale"/]',
	); 

	// Definizione array per contenere il codice di esempio da aggiungere
	// in fondo alla tabella delle singole opzioni permesse sulla funzione 

	$function_example = array(
		'01' => "echo szgoogle_get_youtube_code_video(array('parameter'=>'value'));",
		'02' => "echo szgoogle_get_youtube_code_badge(array('parameter'=>'value'));",
		'03' => "echo szgoogle_get_youtube_code_button(array('parameter'=>'value'));",
		'04' => "echo szgoogle_get_youtube_code_link(array('parameter'=>'value'));",
	); 

	// Chiamata alla funzione per la creazione delle singole sezioni con la
	// suddivisione per shortcodes, functions php and other.

	echo sz_google_admin_documentation_table(__('documentation for shortcodes','szgoogleadmin'),array(
		array($shortcode['01'],$description['01'],$options['01'],$shortcode_example['01']),
		array($shortcode['02'],$description['02'],$options['02'],$shortcode_example['02']),
		array($shortcode['03'],$description['03'],$options['03'],$shortcode_example['03']),
		array($shortcode['04'],$description['04'],$options['04'],$shortcode_example['04']),
	));

	echo sz_google_admin_documentation_table(__('documentation for PHP functions','szgoogleadmin'),array(
		array($functions['01'],$description['01'],$options['01'],$function_example['01']),
		array($functions['02'],$description['02'],$options['02'],$function_example['02']),
		array($functions['03'],$description['03'],$options['03'],$function_example['03']),
		array($functions['04'],$description['04'],$options['04'],$function_example['04']),
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