<?php

/**
 * Classe SZGooglePlugin per inizializzazione del plugin e richiamo
 * di tutte le classi che compongono le parti principali. Vengono
 * caricati i moduli che risultano attivati e la parte di amministrazione.
 *
 * @package SZGoogle
 * @subpackage SZGooglePlugin
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome.

if (!class_exists('SZGooglePlugin'))
{
	class SZGooglePlugin
	{
		private $module  = false;
		private $options = false;

		/**
		 * Definizione costruttore per le operazioni iniziali
		 * del plugin da eseguire dopo il controllo dei requisiti.
		 *
		 * @return void
		 */
		function __construct() 
		{
			$this->module = new SZGoogleModule();

			// Creazione oggetto per modulo base con impostazione del 
			// dominio di traduzione e memorizzazione delle opzioni configurate.

			add_action('plugins_loaded',array($this,'includeLanguageDomain'));

			// Richiamo le funzioni per il caricamento delle parti principali
			// del plugin con la definizione dei moduli che risultano attivati.

			$this->includeHook();		// (1) Registrazione hook di attivazione e disattivazione
			$this->includeHead();		// (2) Registrazione funzioni per esecuzione HEAD
			$this->includeFooter();		// (3) Registrazione funzioni per esecuzione FOOTER
			$this->includeModules();	// (4) Registrazione funzioni per esecuzione dei moduli
		}

		/**
		 * Definizione hooks per la registrazione delle azioni legate
		 * alle operazioni di attivazione e disattivazione del plugin.
		 *
		 * @return void
		 */
		function includeHook() 
		{
			// Attivazione hook per la funzione di attivazione e disattivazione
			// del plugin dal pannello di amministrazione wordpress

			register_activation_hook  (SZ_PLUGIN_GOOGLE_MAIN,array(new SZGooglePluginActivation,'action'));
			register_deactivation_hook(SZ_PLUGIN_GOOGLE_MAIN,array(new SZGooglePluginDeactivation,'action'));
		}

		/**
		 * Esecuzione funzione per aggiungere dei valori alla sezione <head>
		 * della pagina HTML collegata con WP_HEAD tramite action(szgoogle-head)
		 *
		 * @return void
		 */
		function includeHead() {
			add_action('wp_head',array($this,'addSectionHead'),1);
			add_action('wp_head',array($this,'addSectionCSSInline'),99);
		}

		/**
		 * Esecuzione funzione per aggiungere dei valori alla sezione <footer>
		 * della pagina HTML collegata con WP_FOOTER tramite action(szgoogle-footer)
		 *
		 * @return void
		 */
		function includeFooter() {
			add_action('wp_footer',array($this,'addSectionFooter'));
		}

		/**
		 * Caricamento dei moduli del plugin che risultano attivi e abilitazione
		 * delle funzioni sulla parte amministrativa solo se necessario.
		 *
		 * @return void
		 */
		function includeModules() 
		{
			$options = (object) $this->getOptions();

			if ($options->plus          == '1') new SZGoogleModulePlus();
			if ($options->analytics     == '1') new SZGoogleModuleAnalytics();
			if ($options->authenticator == '1') new SZGoogleModuleAuthenticator();
			if ($options->calendar      == '1') new SZGoogleModuleCalendar();
			if ($options->drive         == '1') new SZGoogleModuleDrive();
			if ($options->fonts         == '1') new SZGoogleModuleFonts();
			if ($options->groups        == '1') new SZGoogleModuleGroups();
			if ($options->hangouts      == '1') new SZGoogleModuleHangouts();
			if ($options->maps          == '1') new SZGoogleModuleMaps();
			if ($options->panoramio     == '1') new SZGoogleModulePanoramio();
			if ($options->translate     == '1') new SZGoogleModuleTranslate();
			if ($options->youtube       == '1') new SZGoogleModuleYoutube();
		
			// Richiamo gli script per integrazione plugin con il pannello di amministrazione,
			// viene aggiunto un menu dedicato al plugin con tutte le opzioni collegate ai moduli

			if (is_admin()) new SZGoogleAdminBase();

			// Controllo se viene eseguita una chiamata AJAX per attivare
			// le funzioni collegate al codice azione corrispondente

			if (defined('DOING_AJAX') && DOING_AJAX) {
				new SZGoogleModuleAjax();
			}
		}

		/**
		 * Creazione oggetto per modulo base con impostazione del 
		 * dominio di traduzione e memorizzazione delle opzioni configurate
		 *
		 * @return void
		 */
		function includeLanguageDomain() 
		{
			$dirAdmin = dirname(plugin_basename(SZ_PLUGIN_GOOGLE_MAIN)).'/admin/languages';
			$dirFront = dirname(plugin_basename(SZ_PLUGIN_GOOGLE_MAIN)).'/frontend/languages';

			if (is_admin()) load_plugin_textdomain('szgoogleadmin',false,$dirAdmin);
			                load_plugin_textdomain('szgooglefront',false,$dirFront);
		}

		/**
		 * Funzioni per la creazione di "action" e elaborazione codice HTML
		 * da inserire nelle varie sezioni della pagina WEB Head & Footer.
		 */
		function addSectionHead()      { $this->addSectionCommon('SZ_HEAD'); }
		function addSectionCSSInline() { $this->addSectionCommon('SZ_CCSI'); }
		function addSectionFooter()    { $this->addSectionCommon('SZ_FOOT'); }

		/**
		 * Funzione per la creazione di "action" e elaborazione codice HTML
		 * da inserire nelle varie sezioni della pagina WEB Head & Footer.
		 *
		 * @param  string $action
		 * @return void
		 */
		function addSectionCommon($action) 
		{
			if(has_action($action)) {
				echo "\n";
				echo "<!-- This section is created with the SZ-Google for WordPress plugin ".SZ_PLUGIN_GOOGLE_VERSION." -->\n";
				echo "<!-- ===================================================================== -->\n";
				do_action($action); 
				echo "<!-- ===================================================================== -->\n";
			}
		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptions()
		{
			if ($this->options) return $this->options;
				else $this->options = $this->module->getOptionsSet('sz_google_options_base');

			return $this->options;
		}
	}
}