<?php

/**
 * Classe SZGooglePluginActivation per eseguire la funzione di 
 * disattivazione definita come hook principale di wordpress.
 *
 * @package SZGoogle
 * @subpackage SZGooglePlugin
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome.

if (!class_exists('SZGooglePluginDeactivation'))
{
	class SZGooglePluginDeactivation
	{
		function action()
		{
			// Esecuzione flush rules per regole di rewrite personalizzate nel
			// caso in cui il plugin aggiunga delle nuove opzioni di rewrite.

			SZGoogleCommon::rewriteFlushRules();
		}
	}
}