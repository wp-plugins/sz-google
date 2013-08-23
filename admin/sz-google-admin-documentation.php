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
//		'sz-google-admin-documentation-gplus.php'     => ucwords(__('google+','szgoogleadmin')),
//		'sz-google-admin-documentation-analytics.php' => ucwords(__('google analytics','szgoogleadmin')),
//		'sz-google-admin-documentation-groups.php'    => ucwords(__('google groups','szgoogleadmin')),
		'sz-google-admin-documentation-translate.php' => ucwords(__('google translate','szgoogleadmin')),
		'sz-google-admin-documentation-youtube.php'   => ucwords(__('youtube','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('quick plugin documentation','szgoogleadmin')),'sz_google_options_documentation',$sections,true); 
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

function sz_google_admin_documentation_table($tabella,$titolo=false,$esempio=false) 
{
	echo '<table class="docs"><tr>';

	if ($titolo) {
		echo "<tr>";
		echo '<th class="tit" colspan="4"><h4>'.$titolo."</h4></th>";
		echo "</tr>";
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


function sz_google_admin_documentation_gplus()     {}
function sz_google_admin_documentation_analytics() {}
function sz_google_admin_documentation_groups()    {}

/* ************************************************************************** */
/* Funzioni per contenuto documentazione su GOOGLE TRANSLATE                  */
/* ************************************************************************** */

function sz_google_admin_documentation_translate() 
{
	$tabella = array(
		'language'  => array(__('language for widget','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
		'mode'      => array(__('display mode','szgoogleadmin'),__('V,H,D','szgoogleadmin'),__('configuration','szgoogleadmin')),
		'automatic' => array(__('automatic banner','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
		'analytics' => array(__('google analytics','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('configuration','szgoogleadmin')),
		'uacode'    => array(__('google analytics UA','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
	);

	$titolo_01  = '[sz-translate/]';
	$titolo_02  = 'szgoogle_get_translate_code()';
	$titolo_03  = 'szgoogle_get_translate_meta()';
	$titolo_04  = 'szgoogle_get_translate_meta_ID()';

	$esempi_01 = '[sz-translate language="it" mode="V"/]';
	$esempi_02 = "echo szgoogle_get_translate_code(array('parameter'=>'value'));";
	$esempi_03 = "echo szgoogle_get_translate_meta();";
	$esempi_04 = "echo szgoogle_get_translate_meta_ID();";

	echo sz_google_admin_documentation_table($tabella,$titolo_01,$esempi_01); 
	echo sz_google_admin_documentation_table($tabella,$titolo_02,$esempi_02); 
	echo sz_google_admin_documentation_table(array() ,$titolo_03,$esempi_03); 
	echo sz_google_admin_documentation_table(array() ,$titolo_04,$esempi_04); 
}

/* ************************************************************************** */
/* Funzioni per contenuto documentazione su YOUTUBE                           */
/* ************************************************************************** */

function sz_google_admin_documentation_youtube() 
{
	$doctxt_01 = array(
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
	);

	$doctxt_02 = array(
		'channel'         => array(__('channel name or ID','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
		'width'           => array(__('size pixel width','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('300','szgoogleadmin')),
		'height'          => array(__('size pixel height','szgoogleadmin'),__('numeric value','szgoogleadmin'),__('150','szgoogleadmin')),
		'widthunit'       => array(__('unit for width','szgoogleadmin'),__('px,em,%','szgoogleadmin'),__('px','szgoogleadmin')),
		'heightunit'      => array(__('unit for height','szgoogleadmin'),__('px,em,%','szgoogleadmin'),__('px','szgoogleadmin')),
	);

	$doctxt_03 = array(
		'channel'         => array(__('channel name or ID','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
		'layout'          => array(__('layout type','szgoogleadmin'),__('default,full','szgoogleadmin'),__('default','szgoogleadmin')),
		'theme'           => array(__('theme for button','szgoogleadmin'),__('default,dark','szgoogleadmin'),__('default','szgoogleadmin')),
	);

	$doctxt_04 = array(
		'channel'         => array(__('channel name or ID','szgoogleadmin'),__('string','szgoogleadmin'),__('configuration','szgoogleadmin')),
		'subscription'    => array(__('subscription mode','szgoogleadmin'),__('y=yes,n=no','szgoogleadmin'),__('y=yes','szgoogleadmin')),
		'text'            => array(__('anchor text for link','szgoogleadmin'),__('string','szgoogleadmin'),__('channel youtube','szgoogleadmin')),
	);

	// Preparazione variabili per la gestione dei titoli che
	// saranno visualizzati su ogni sezione di documentazione

	$titolo_01  = '[sz-ytvideo/]';
	$titolo_02  = '[sz-ytbadge/]';
	$titolo_03  = '[sz-ytbutton/]';
	$titolo_04  = '[sz-ytlink/]';

	// Preparazione variabili per la gestione dei titoli che
	// saranno visualizzati su ogni sezione di documentazione

	$titolo_11  = 'szgoogle_get_youtube_code_video()';
	$titolo_12  = 'szgoogle_get_youtube_code_badge()';
	$titolo_13  = 'szgoogle_get_youtube_code_button()';
	$titolo_14  = 'szgoogle_get_youtube_code_link()';

	// Preparazione variabili per la gestione degli esempi che
	// saranno visualizzati su ogni sezione di documentazione

	$esempi_01 = '[sz-ytvideo url="http://www.youtube.com/watch?v=Xz2unftv_l4"/]';
	$esempi_02 = '[sz-ytbadge channel="startbyzero"/]';
	$esempi_03 = '[sz-ytbutton layout="full" theme="dark"/]';
	$esempi_04 = '[sz-ytlink text="iscriviti al mio canale"/]';

	// Preparazione variabili per la gestione degli esempi che
	// saranno visualizzati su ogni sezione di documentazione

	$esempi_11 = "echo szgoogle_get_youtube_code_video(array('parameter'=>'value'));";
	$esempi_12 = "echo szgoogle_get_youtube_code_badge(array('parameter'=>'value'));";
	$esempi_13 = "echo szgoogle_get_youtube_code_button(array('parameter'=>'value'));";
	$esempi_14 = "echo szgoogle_get_youtube_code_link(array('parameter'=>'value'));";

	// Chiamata alla funzione per la creazione dellle singole sezioni

	echo sz_google_admin_documentation_table($doctxt_01,$titolo_01,$esempi_01); 
	echo sz_google_admin_documentation_table($doctxt_02,$titolo_02,$esempi_02); 
	echo sz_google_admin_documentation_table($doctxt_03,$titolo_03,$esempi_03); 
	echo sz_google_admin_documentation_table($doctxt_04,$titolo_04,$esempi_04); 

	echo sz_google_admin_documentation_table($doctxt_01,$titolo_11,$esempi_11); 
	echo sz_google_admin_documentation_table($doctxt_02,$titolo_12,$esempi_12); 
	echo sz_google_admin_documentation_table($doctxt_03,$titolo_13,$esempi_13); 
	echo sz_google_admin_documentation_table($doctxt_04,$titolo_14,$esempi_14); 
}