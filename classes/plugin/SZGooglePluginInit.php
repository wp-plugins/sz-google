<?php
/**
 * Classe SZGoogleModule per la creazione di istanze che controllino le
 * opzioni e le funzioni comuni che ogni modulo del plugin deve richiamare
 * o elaborare. Tutti i moduli devo fare riferimento a questa classe. 
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGooglePluginInit'))
{
	class SZGooglePluginInit
	{
		function __construct() 
		{
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
	     * Creazione oggetto per Modulo Base con impostazione del 
	     * dominio di traduzione e memorizzazione delle opzioni configurate
	     *
	     * @return void
	     */
		function setLanguageDomain() 
		{
			load_plugin_textdomain('szgoogle',false,SZ_PLUGIN_GOOGLE_BASENAME_LANGUAGE_FRONT);

			if (is_admin()) {
				load_plugin_textdomain('szgoogleadmin',false,SZ_PLUGIN_GOOGLE_BASENAME_LANGUAGE_ADMIN);
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
			// Attivazione hook per la funzione di attivazione e disattivazione
			// del plugin dal pannello di amministrazione wordpress

			register_activation_hook  (SZ_PLUGIN_GOOGLE_MAIN,array('SZGooglePlugin','activate'));
			register_deactivation_hook(SZ_PLUGIN_GOOGLE_MAIN,array('SZGooglePlugin','deactivate'));
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
			$SZ_GOOGLE_MODULE = new SZGoogleModuleInit();			
			@require_once(SZ_PLUGIN_GOOGLE_BASENAME_FUNCTIONS.'sz-google-functions.php');
		}

		/**
	     * Richiamo gli script per integrazine plugin con il pannello di amministrazione,
	     * viene aggiunto un menu dedicato al plugin con tutte le opzioni collegate ai moduli
	     *
	     * @return void
	     */
		function includeAdmin() 
		{
			if (is_admin()) $SZ_GOOGLE_ADMIN_BASE = new SZGoogleAdminBase();
		}
	}
}
