<?php

/**
 * Class to initialize the plugin and recall
 * of all classes that make up the main parts
 *
 * @package SZGoogle
 * @subpackage Classes
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Before the definition of the class, check if there is a definition
// with the same name or the same as previously defined in other script

if (!class_exists('SZGooglePluginActivation'))
{
	class SZGooglePluginActivation
	{
		function action()
		{
			// Controllo formale delle opzioni e memorizzazione sul database
			// in base ad una prima installazione o update del plugin.

			$this->checkOptions('sz_google_options_api'); 
			$this->checkOptions('sz_google_options_base'); 
			$this->checkOptions('sz_google_options_plus'); 
			$this->checkOptions('sz_google_options_ga');
			$this->checkOptions('sz_google_options_authenticator');
			$this->checkOptions('sz_google_options_calendar'); 
			$this->checkOptions('sz_google_options_drive'); 
			$this->checkOptions('sz_google_options_fonts'); 
			$this->checkOptions('sz_google_options_groups');
			$this->checkOptions('sz_google_options_hangouts');
			$this->checkOptions('sz_google_options_panoramio');
			$this->checkOptions('sz_google_options_translate');
			$this->checkOptions('sz_google_options_youtube');

			// Esecuzione flush rules per regole di rewrite personalizzate nel
			// caso in cui il plugin aggiunga delle nuove opzioni di rewrite.

			add_action('wp_loaded',array('SZGoogleCommon','rewriteFlushRules'));
		}

		/**
		 * Funzione per il caricamento dei file contenenti le opzioni collegate
		 * ai diversi moduli del plugin che si trovano nella cartella /options 
		 *
		 * @param  string,array $nameset
		 * @return void
		 */
		private function checkOptions($nameset)
		{
			// Caricamento file delle opzioni con array() contenente i nomi delle
			// opzioni che devono essere memorizzate nel database di wordpress.

			$values = array();
			$fields = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/{$nameset}.php");

			// Controllo se ho ricevuto un array dal file delle opzioni
			// in caso contrario ignoro la richiesta di controllo opzioni.

			if (is_array($fields)) 
			{
				foreach($fields as $item=>$data) {
					$values[$item] = $data['value'];
				}

				$this->checkOptionSet($nameset,$values);
			}
		}

		/**
		 * Controllo il singolo nameset di opzione per verificare se il valore
		 * indicato deve essere aggiunto al database in fase di attivazione.
		 *
		 * @param  string,array $name,$values
		 * @return void
		 */
		private function checkOptionSet($name,$values) 
		{
			if (is_array($values)) {

				// Controllo se esistono le opzioni richieste, in caso
				// affermativo passo al controllo di ogni singola opzione 

				if ($options = get_option($name)) 
				{
					if (!is_array($options)) $options=array(); 

					// Controllo se nelle opzioni ci sono degli indici che non
					// vengono più utilizzati li tolgo da array generale

					foreach ($options as $key=>$item) {
						if (!isset($values[$key])) unset($options[$key]);
					}

					// Controllo le opzioni che sono state inserite nel nuovo
					// release e le aggiungo al contenitore array generale

					foreach ($values as $key=>$item) {
						if (!isset($options[$key])) $options[$key]=$item;
					}

					update_option($name,$options);

				} else {

					// Se le opzioni non esistono in quanto il plugin potrebbe
					// essere la prima volta che viene installato -> aggiungo array 

					add_option($name,$values);
				}
			}
		}
	}
}