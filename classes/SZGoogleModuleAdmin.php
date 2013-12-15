<?php
/**
 * Classe SZGoogleModuleAdmin per la creazione di istanze che controllino le
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
if (!class_exists('SZGoogleModuleAdmin'))
{
	class SZGoogleModuleAdmin
	{
		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * da applicare alle varie chiamate delle funzioni wordpress
		 */
		protected $pagetitle       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $menutitle       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $menuslug        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $capability      = SZ_PLUGIN_GOOGLE_VALUE_CAPABILITY;
		protected $parentslug      = SZ_PLUGIN_GOOGLE_ADMIN_BASENAME;
		protected $titlefix        = SZ_PLUGIN_GOOGLE_VALUE_TITLEFIX;
		protected $sections        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $sectionstitle   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $sectionsoptions = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $validate        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $callback        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		protected $callbacksection = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			// Impostazione variabili per la corretta esecuzione del modulo,
			// posso essere ridefinite nella funzione moduleSetup()

			$this->validate        = array($this,'moduleValidate');
			$this->callback        = array($this,'moduleCallback');
			$this->callbacksection = array($this,'moduleCallbackSection');

			// Definizione delle azioni wordpress per la creazione del 
			// menu di amministrazione e del form delle opzioni collegate

			add_action('admin_menu',array($this,'moduleAddMenu'));
			add_action('admin_init',array($this,'moduleAddFields'));
 		}

		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			if (function_exists('add_submenu_page')) 
			{
				$pagehook = add_submenu_page($this->parentslug,$this->titlefix.$this->pagetitle,
					$this->menutitle,$this->capability,$this->menuslug,$this->callback);
				add_action('admin_print_scripts-'.$pagehook,'sz_google_admin_add_plugin');
			}
 		}

		/**
		 * Impostazione delle variabili per le opzioni che devono
		 * essere elencate nella schermata di amministrazione wordpress
		 *
		 * @return void
		 */
		function moduleAddFields()
		{
 		}

		/**
		 * Chiamata alla funzione generale per la creazione del form generale
		 * le sezioni devono essere passate come un array con nome => titolo
		 *
		 * @return void
		 */
		function moduleCallback()
		{
			sz_google_common_form($this->sectionstitle,$this->sectionsoptions,$this->sections); 
		}

		/**
		 * Definizione di una callback dummy per la sezione che viene
		 * elaborata durante la definizione delle sezioni e campi di input
		 *
		 * @return void
		 */
		function moduleCallbackSection()
		{
		}

		/**
		 * Definizione di un validatore dummy per la sezione che viene
		 * elaborata durante la definizione delle sezioni e campi di input
		 *
		 * @return void
		 */
		function moduleValidate($options) {
	  		return $options;
		}
	}
}
