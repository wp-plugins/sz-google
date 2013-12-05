<?php
/*
Plugin Name: SZ - Google
Plugin URI: https://wpitalyplus.com/sz-google/
Description: Plugin to integrate <a href="http://google.com" target="_blank">Google's</a> products in <a href="http://wordpress.org" target="_blank">WordPress</a> with particular attention to the widgets provided by the social network Google+. Before using the plug-in <em>sz-google</em> pay attention to the options to be specified in the admin panel and enter all the parameters necessary for the proper functioning of the plugin. If you want to know the latest news and releases from the plug-in <a href="http://wordpress.org/plugins/sz-google/">sz-google</a> follow the <a href="https://plus.google.com/+wpitalyplus" target="_blank">official page</a> present in Google+ or subscribe to our community <a href="https://plus.google.com/communities/109254048492234113886" target="_blank">WP Italyplus</a> always present on Google+.
Author: Massimo Della Rovere
Version: 1.6.6
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
 * Definizione delle costanti da usare nel plugin per uso generale,
 * qui vanno definite le costanti per il debug, la versione, ect.
 */
define('SZ_PLUGIN_GOOGLE',true);
define('SZ_PLUGIN_GOOGLE_DEBUG',false);
define('SZ_PLUGIN_GOOGLE_VERSION','1.6.6');
define('SZ_PLUGIN_GOOGLE_PATH',plugin_dir_url(__FILE__));
define('SZ_PLUGIN_GOOGLE_BASENAME',dirname(__FILE__ ));
define('SZ_PLUGIN_GOOGLE_BASENAMP',dirname(plugin_basename(__FILE__ )));
define('SZ_PLUGIN_GOOGLE_REPOSITORY','http://wordpress.org/plugins/sz-google/');

/**
 * Inclusione delle costanti definite per ogni singolo modulo presente
 * nel plugin. Ogni mofulo ha delle costanti con un suffisso predefinito.
 */
@require(SZ_PLUGIN_GOOGLE_BASENAME.'/classes/SZGoogleConstants.php');

/**
 * Il plugin necessita di alcuni controllo sugli utenti collegati prima che questi
 * vengano caricati dal core. Quindi in assensa si anticipa il caricamento.
 */
if (!function_exists('is_user_logged_in()')) {
	require_once(ABSPATH.WPINC.'/pluggable.php');
}

/**
 * Definizione della classe principale del plugin per l'esecuzione delle
 * operazioni iniziali e l'applicazione dei filtri necessari.
 */
class SZGoogleInitPlugin
{
	function __construct() 
	{
		// Attivazione del caricamento dinamico delle classi

		spl_autoload_register(array($this,'autoloaderClasses'));

		// Controllo costante di DEBUG per scrittura messaggio di
		// breakpoint nel file di log PHP indicato in php.ini

		if (SZ_PLUGIN_GOOGLE_DEBUG) {
			SZGoogleDebug::log('execute init-load point functions');
		}
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
		if (substr($classname,0,8) == 'SZGoogle' and is_readable(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES.$classname.'.php')) 
		{
			@require(SZ_PLUGIN_GOOGLE_BASENAME_CLASSES.$classname.'.php');

			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('execute auto-load class '.$classname.'.php');
			}
    	}
	}

	/**
     * Richiamo le funzioni per la registrazione delle azioni legate
     * alle azioni di attivazione e disattivazione plugin
     *
     * @return void
     */
	function includeHook() 
	{
		// Controllo costante di DEBUG per scrittura messaggio di
		// breakpoint nel file di log PHP indicato in php.ini

		if (SZ_PLUGIN_GOOGLE_DEBUG) {
			SZGoogleDebug::log('execute init-load point hooks');
		}

		// Attivazione hook per la funzione di attivazione e disattivazione
		// del plugin dal pannello di amministrazione wordpress

		register_activation_hook  (__FILE__,array('SZGooglePlugin','activate'));
		register_deactivation_hook(__FILE__,array('SZGooglePlugin','deactivate'));
	}

	/**
	 * Esecuzione funzione per aggiungere dei valori alla sezione <head>
	 * della pagina HTML collegata con WP_HEAD tramite action(szgoogle-head)
	 *
	 * @return void
	 */
	function includeHead()
	{
		add_action('wp_head',array('SZGooglePlugin','addSectionHead'),1);
	}

	/**
     * Richiamo gli script per la definizione dei moduli e delle funzioni PHP 
     * da poter utilizzare direttamente in fase di programmazione sui temi di wordpress
     *
     * @return void
     */
	function includeModules() 
	{
		if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute init-load point PHP code for module');
		if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute init-load point PHP code for functions');

		@require_once(SZ_PLUGIN_GOOGLE_BASENAME_MODULES.'sz-google-module.php');
		@require_once(SZ_PLUGIN_GOOGLE_BASENAME_MODULES.'sz-google-functions.php');
	}

	/**
     * Richiamo gli script per integrazine plugin con il pannello di amministrazione,
     * viene aggiunto un menu dedicato al plugin con tutte le opzioni collegate ai moduli
     *
     * @return void
     */
	function includeAdmin() 
	{
		if (is_admin()) 
		{
			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('execute init-load point PHP code for admin');
			}

			@include_once(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN.'sz-google-admin.php');
		}
	}
}

/**
 * Creazione oggetto di inizializzazione e chiamata alle funzioni principali
 * per attivazione e caricamento delle parti necessarie al plugin.
 * 
 * (1) includeHook    = Registrazione hook di attivazione e disattivazione
 * (2) includeModules = Registrazione funzioni per esecuzione dei moduli
 * (3) includeAdmin   = Registrazione funzioni per pannello di amministrazione
 */
$SZ_GOOGLE_OBJECT = new SZGoogleInitPlugin();

$SZ_GOOGLE_OBJECT->includeHook();
$SZ_GOOGLE_OBJECT->includeHead();
$SZ_GOOGLE_OBJECT->includeModules();
$SZ_GOOGLE_OBJECT->includeAdmin();
