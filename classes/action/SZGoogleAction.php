<?php

/**
 * Definizione di una classe che identifica un'azione richiamata dal
 * modulo principale in base alle opzioni che sono state attivate
 * nel pannello di amministrazione o nella configurazione del plugin
 *
 * @package SZGoogle
 * @subpackage SZGoogleActions
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleAction'))
{
	/**
	 * Definizione della classe principale da utilizzare per 
	 * la definizione delle azioni collegate ai vari moduli
	 */
	class SZGoogleAction 
	{
		/**
		 * Funzione per reperire le opzioni di configurazione che
		 * sono collegate al modulo indicato nel parametro passato
		 */
		function getModuleOptions($name) {
			if (!$object = SZGoogleModule::getObject($name)) $object = new $name;
			return $object->getOptions();
		}

		/**
		 * Reperire il riferimento oggetto del modulo richiamato
		 * per facilitare il richiamo dei metodi da questa azione
		 */
		function getModuleObject($name) {
			if (!$object = SZGoogleModule::getObject($name)) $object = new $name;
			return $object;
		}
	}
}