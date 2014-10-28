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

if (!class_exists('SZGoogleActionFontsTinyMCE'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionFontsTinyMCE extends SZGoogleAction
	{
		/**
		 * Aggiungo nella fase del costruttore i filtri e le azioni
		 * necessarie a controllare il login con codice a tempo
		 */
		function __construct() 
		{		
			// Calcolo per opzioni di configurazione collegate al modulo
			// richiesto e specificate nel pannello di amministrazione
			
			$options = (object) $this->getModuleOptions('SZGoogleModuleFonts');

			// Controllo i componenti che devo aggiungere a TinyMCE
			// come il selettore della famiglia da applicare alla selezione

			if ($options->fonts_tinyMCE_family == '1') {
				add_filter('mce_buttons_2',array($this,'add_mce_fonts_family'));
			}

			// Controllo i componenti che devo aggiungere a TinyMCE
			// come il selettore della dimensione da applicare alla selezione

			if ($options->fonts_tinyMCE_size == '1') {
				add_filter('mce_buttons_2',array($this,'add_mce_fonts_size'));
			}
		}

		/**
		 * Definizione della funzione che verrà richiamata nel
		 * caso bisognerà aggiungere il selettore del Font Family
		 */ 
		function add_mce_fonts_family($buttons) {
			array_unshift($buttons,'fontselect');
			return $buttons;
		}
 
		/**
		 * Definizione della funzione che verrà richiamata nel
		 * caso bisognerà aggiungere il selettore del Font Size
		 */ 
		function add_mce_fonts_size($buttons) {
			array_unshift($buttons,'fontsizeselect');
			return $buttons;
		}
	}
}