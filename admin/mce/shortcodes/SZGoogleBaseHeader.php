<?php
/**
 * Codice HTML per il form di impostazione collegato 
 * al widget presente nella parte di amministrazione, questo
 * codice è su file separato per escluderlo dal frontend
 *
 * @package SZGoogle
 * @subpackage SZGoogleTinyMCE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Definizione e inizializzazione array che sarà
// usato per la creazione di variabili automatiche

$variables = array();

// Lettura array e creazione identificativi nome
// con il prefisso convenzionale ID_ NAME_ VALUE_

foreach($array as $item=>$value) 
{
	$PREFIX_I = 'ID_'   .$item;
	$PREFIX_N = 'NAME_' .$item;
	$PREFIX_V = 'VALUE_'.$item;

	$variables[$PREFIX_I] = $PREFIX_I;
	$variables[$PREFIX_N] = $PREFIX_N;
	$variables[$PREFIX_V] = esc_attr(${$item});
}

// Estrazione array per la creazione di variabili
// con nome indicato nella chiave e valore associato

extract($variables,EXTR_OVERWRITE);

// Aggiungere lo stile e Javascript del plugin che serve per la
// gestione del FORM sia a livello grafico che funzionale

function sz_google_ajax_load_scripts() 
{
	wp_enqueue_style('sz-google-style-admin',
		plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/css/sz-google-style-admin.css',
		array(),SZ_PLUGIN_GOOGLE_VERSION
	);

	wp_enqueue_script('sz-google-javascript-widgets',
		plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/js/jquery.szgoogle.widgets.js',
		array('jquery'),SZ_PLUGIN_GOOGLE_VERSION,false
	);

	wp_enqueue_script('tiny_mce_popup',
		includes_url('js/tinymce/tiny_mce_popup.js'),
		array('jquery'),SZ_PLUGIN_GOOGLE_VERSION,false
	);

	wp_enqueue_script('tiny_mce_component',
		plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/mce/js/'.SZGOOGLE_AJAX_NAME.'.js',
		array('tiny_mce_popup'),SZ_PLUGIN_GOOGLE_VERSION,false
	);
}

// Aggiungo una classe alla ezione <BODY> per indicare
// delle regole CSS e adattare alcune parti alla finestra popup

function sz_google_ajax_body_classes($classes) {
	return $classes.'SZMCE';
}

// Definisco il titolo della pagina in base al valore
// description specificato nella chiamata javascript

function sz_google_ajax_title($admin_title,$title) {
	return $_GET['title'];
}

// Aggiungo i Filtri e le azioni per personalizzare la
// composizione standard ADMIN con i componenti del plugin

add_filter('admin_title','sz_google_ajax_title',99,2);
add_filter('admin_body_class','sz_google_ajax_body_classes'); 
add_action('admin_enqueue_scripts','sz_google_ajax_load_scripts');

if (!did_action('wp_enqueue_media')) wp_enqueue_media();

// Caricamento Header comune della parte di amministrazione
// in maniera tale da caricare i stili che servono per FORM

require(ABSPATH.'wp-admin/admin-header.php');

// Apertura del FORM per contenere i parametri che devono essere
// indicati nello shortcode che andremmo a comporre con OK

echo "<form id=\"MCE\" action=\"javascript:void(0);\" method=\"post\">\n";