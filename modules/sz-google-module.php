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
if (!class_exists('SZGoogleInitModules'))
{
	/**
	 * Definizione della classe principale del plugin per esecuzione delle
	 * operazioni di inclusione che riguardano i singoli moduli attivati
	 */
	class SZGoogleInitModules
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
			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute construct class SZGoogleInitModules');

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
			$dirname = dirname(__FILE__);

			if ($this->options['plus']      == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-plus.php');
			if ($this->options['analytics'] == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-analytics.php');
			if ($this->options['drive']     == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-drive.php');
			if ($this->options['fonts']     == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-fonts.php');
			if ($this->options['groups']    == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-groups.php');
			if ($this->options['hangouts']  == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-hangouts.php');
			if ($this->options['panoramio'] == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-panoramio.php');
			if ($this->options['translate'] == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-translate.php');
			if ($this->options['youtube']   == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once($dirname.'/sz-google-module-youtube.php');
		}
	}

	/**
	 * Creazione oggetto di inizializzazione e chiamata alle funzioni principali
	 * per attivazione e caricamento delle parti necessarie al plugin.
	 */
	$SZ_GOOGLE_MODULE = new SZGoogleInitModules();
}