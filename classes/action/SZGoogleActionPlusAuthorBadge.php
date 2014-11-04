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

if (!class_exists('SZGoogleActionPlusAuthorBadge'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionPlusAuthorBadge extends SZGoogleAction
	{
		/**
		 * Definizione della funzione che viene normalmente richiamata
		 * dagli hook presenti in add_action e add_filter di wordpress.
		 */
		function addAction() { 
			add_filter('the_content',array($this,'addPlusAuthorBadgeContent'));
		}

		/**
		 * Funzione per generare un badge autore da aggiungere al contesto
		 * del post presente su wordpress, viene usato il filtro the_content.
		 */
		function addPlusAuthorBadgeContent($content) 
		{
			return $content;
		}
	}
}