<?php
/**
 * Programma principale per elaborazione dei moduli attivati nel plugin,
 * questo script controlla tutte le opzioni di attivazione presenti
 * nel pannello di amministrazione come primo menu della configurazione.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleModuleInit'))
{
	/**
	 * Definizione della classe principale del plugin per esecuzione delle
	 * operazioni di inclusione che riguardano i singoli moduli attivati
	 */
	class SZGoogleModuleInit
	{
		/**
		 * Memorizzazione oggetto SZGoogleModule e array 
		 * delle opzioni collegate alla configurazione dei moduli
		 */
		protected $object;
		protected $options;

		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct() 
		{
			// Creazione oggetto per Modulo Base con impostazione del 
			// dominio di traduzione e memorizzazione delle opzioni configurate

			$this->object = new SZGoogleModule();
			$this->options = $this->object->getOptions();

			// Caricamento dei moduli che risultano attivi in base alle opzioni
			// di configurazione impostate tramite il pannello di amministrazione

			$this->loadModules();
		}

		/**
		 * Inclusione dei file corrispondenti ai moduli che risultano attivi, per le 
		 * opzioni di attivazione e disattivazione controllaaaaare il menu in admin
		 *
		 * @return void
		 */
		function loadModules() 
		{
			if ($this->options['plus']      == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModulePlus();
			if ($this->options['analytics'] == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModuleAnalytics();
			if ($this->options['calendar']  == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModuleCalendar();
			if ($this->options['drive']     == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModuleDrive();
			if ($this->options['fonts']     == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModuleFonts();
			if ($this->options['groups']    == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModuleGroups();
			if ($this->options['hangouts']  == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModuleHangouts();
			if ($this->options['panoramio'] == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModulePanoramio();
			if ($this->options['translate'] == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModuleTranslate();
			if ($this->options['youtube']   == SZ_PLUGIN_GOOGLE_VALUE_YES) new SZGoogleModuleYoutube();
		}
	}
}