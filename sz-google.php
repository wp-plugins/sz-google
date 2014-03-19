<?php
/*
Plugin Name: SZ - Google
Plugin URI: https://wpitalyplus.com/sz-google/
Description: Plugin to integrate <a href="http://google.com" target="_blank">Google's</a> products in <a href="http://wordpress.org" target="_blank">WordPress</a> with particular attention to the widgets provided by the social network Google+. Before using the plug-in <em>sz-google</em> pay attention to the options to be specified in the admin panel and enter all the parameters necessary for the proper functioning of the plugin. If you want to know the latest news and releases from the plug-in <a href="http://wordpress.org/plugins/sz-google/">sz-google</a> follow the <a href="https://plus.google.com/+wpitalyplus" target="_blank">official page</a> present in Google+ or subscribe to our community <a href="https://plus.google.com/communities/109254048492234113886" target="_blank">WP Italyplus</a> always present on Google+.
Author: Massimo Della Rovere
Version: 1.7.0
Author URI: https://plus.google.com/+MassimoDellaRovere
License: GPLv2 or later
Copyright 2012-2013 startbyzero (email: webmaster@startbyzero.com)
*/

/**
 * Questo plugin è stato scritto con il supporto della nostra community
 * WP Italyplus presente sul social network di google+, colgo l'occasione
 * per ringraziare tutte le persone che ci hanno aiutato e supportato nello
 * sviluppo di questo plugin per wordpress, i moduli da sviluppare sono 
 * ancora tantissimi, quindi qualsiasi idea o consiglio che può interessare
 * sviluppi futuri possono essere postati direttamente nella community.
 * 
 * @Website..: https://wpitalyplus.com
 * @Community: https://plus.google.com/communities/109254048492234113886
 */
if (!defined('ABSPATH')) die("Accesso diretto al file non permesso");

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleInitPlugin'))
{
	/**
	 * Definizione delle costanti da usare nel plugin per uso generale,
	 * qui vanno definite le costanti per URL, basename, versione, ect.
	 */
	define('SZ_PLUGIN_GOOGLE',true);
	define('SZ_PLUGIN_GOOGLE_MAIN',__FILE__);
	define('SZ_PLUGIN_GOOGLE_VERSION','1.7.0');

	/**
	 * Il plugin necessita di alcuni controllo sugli utenti collegati prima che questi
	 * vengano caricati dal core. Quindi in assensa si anticipa il caricamento.
	 */
	if (!function_exists('is_user_logged_in()')) {
		if (is_readable(ABSPATH.WPINC.'/pluggable.php')) {
		   require_once(ABSPATH.WPINC.'/pluggable.php');
		}
	}

	/**
	 * Inclusione delle costanti definite per ogni singolo modulo presente
	 * nel plugin. Ogni modulo ha delle costanti con un suffisso predefinito.
	 */
	@require(dirname(__FILE__ ).'/classes/plugin/SZGooglePluginConstants.php');

	/**
	 * Definizione della classe principale del plugin per l'esecuzione delle
	 * operazioni iniziali e l'applicazione dei filtri necessari.
	 */
	class SZGooglePluginAuto
	{
		function __construct() 
		{
			// Attivazione del caricamento dinamico delle classi senza dover
			// utilizzare la funzione di require prima della definizione di classe

			spl_autoload_register(array($this,'autoloaderClasses'));
		}

		/**
		 * Attivazione funzione di autoloader per le classi del plugin, se la funzione dovesse
		 * essere richiamata per classi diverse da SZGoogle il sistema di autoloading viene ignorato.
		 *
		 * @param  string $classname
		 * @return void
		 */
		function autoloaderClasses($classname) 
		{
			// Caricamento delle classi che interessano la parte di amministrazione
			// queste classi inizieranno con il prefisso "SZGoogleAdmin"

			if (substr($classname,0,13) == 'SZGoogleAdmin') {
				if (is_readable(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES_ADMIN.$classname.'.php')) {
					   @require(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES_ADMIN.$classname.'.php'); return;
				}
			}

			// Caricamento delle classi che interessano la parte dei moduli
			// queste classi inizieranno con il prefisso "SZGoogleModule"

			if (substr($classname,0,14) == 'SZGoogleModule') {
				if (is_readable(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES_MODULES.$classname.'.php')) {
					   @require(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES_MODULES.$classname.'.php'); return;
				}
			}

			// Caricamento delle classi che interessano la parte del plugin
			// queste classi inizieranno con il prefisso "SZGooglePlugin"

			if (substr($classname,0,14) == 'SZGooglePlugin') {
				if (is_readable(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES_PLUGIN.$classname.'.php')) {
					   @require(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES_PLUGIN.$classname.'.php'); return;
				}
			}

			// Caricamento delle classi che interessano la parte dei widgets
			// queste classi inizieranno con il prefisso "SZGoogleWidget"

			if (substr($classname,0,14) == 'SZGoogleWidget') {
				if (is_readable(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES_WIDGETS.$classname.'.php')) {
					   @require(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES_WIDGETS.$classname.'.php'); return;
				}
			}
		}
	}

	/**
	 * Creazione oggetto di inizializzazione e chiamata alle funzioni principali
	 * per attivazione e caricamento delle parti necessarie al plugin.
	 */
	new SZGooglePluginAuto();
	new SZGooglePluginInit();
}
