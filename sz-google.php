<?php
/*
Plugin Name: SZ - Google
Plugin URI: https://wpitalyplus.com/sz-google/
Description: Plugin to integrate <a href="http://google.com" target="_blank">Google's</a> products in <a href="http://wordpress.org" target="_blank">WordPress</a> with particular attention to the widgets provided by the social network Google+. Before using the plug-in <em>sz-google</em> pay attention to the options to be specified in the admin panel and enter all the parameters necessary for the proper functioning of the plugin. If you want to know the latest news and releases from the plug-in <a href="http://wordpress.org/plugins/sz-google/">sz-google</a> follow the <a href="https://plus.google.com/+wpitalyplus" target="_blank">official page</a> present in Google+ or subscribe to our community <a href="https://plus.google.com/communities/109254048492234113886" target="_blank">WP Italyplus</a> always present on Google+.
Author: Massimo Della Rovere
Version: 1.6.7
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
	 * qui vanno definite le costanti per il debug, la versione, ect.
	 */
	define('SZ_PLUGIN_GOOGLE',true);
	define('SZ_PLUGIN_GOOGLE_DEBUG',false);
	define('SZ_PLUGIN_GOOGLE_VERSION','1.6.7');
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
			// Attivazione del caricamento dinamico delle classi senza dover
			// utilizzare la funzione di require prima della definizione di classe

			spl_autoload_register(array($this,'autoloaderClasses'));

			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute init-load point functions');

			// Creazione oggetto per Modulo Base con impostazione del 
			// dominio di traduzione e memorizzazione delle opzioni configurate

			add_action('plugins_loaded',array($this,'setLanguageDomain'));

			// (1) includeHook    = Registrazione hook di attivazione e disattivazione
			// (2) includeHead    = Registrazione funzioni per esecuzione HEAD
			// (3) includeFooter  = Registrazione funzioni per esecuzione FOOTER
			// (4) includeModules = Registrazione funzioni per esecuzione dei moduli
			// (5) includeAdmin   = Registrazione funzioni per pannello di amministrazione

			$this->includeHook();
			$this->includeHead();
			$this->includeFooter();
			$this->includeModules();
			$this->includeAdmin();
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
				if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute auto-load class '.$classname.'.php');
	    	}
		}

		/**
	     * Creazione oggetto per Modulo Base con impostazione del 
	     * dominio di traduzione e memorizzazione delle opzioni configurate
	     *
	     * @return void
	     */
		function setLanguageDomain() 
		{
			if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute init-load point textdomain szgoogle');

			load_plugin_textdomain('szgoogle',false,SZ_PLUGIN_GOOGLE_BASENAME_LANGUAGE);

			if (is_admin()) {
				load_plugin_textdomain('szgoogleadmin',false,SZ_PLUGIN_GOOGLE_BASENAME_LANGUAGE);
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

			if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute init-load point hooks');

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
			add_action('wp_head',array('SZGooglePlugin','addSectionCSSInline'),99);
		}

		/**
		 * Esecuzione funzione per aggiungere dei valori alla sezione <footer>
		 * della pagina HTML collegata con WP_FOOTER tramite action(szgoogle-footer)
		 *
		 * @return void
		 */
		function includeFooter()
		{
			add_action('wp_footer',array('SZGooglePlugin','addSectionFooter'));
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
				if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute init-load point PHP code for admin');

				// Caricamento del file che contiene tutte le classi e le opzioni
				// per esecuzione plugin nella parte amministrativa di wordpress

				@include_once(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN.'sz-google-admin.php');
			}
		}
	}

	/**
	 * Creazione oggetto di inizializzazione e chiamata alle funzioni principali
	 * per attivazione e caricamento delle parti necessarie al plugin.
	 */
	$SZ_GOOGLE_OBJECT = new SZGoogleInitPlugin();
}