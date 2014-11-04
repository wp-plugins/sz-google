<?php

/**
 * Classe SZGoogleCommon per esecuzione funzioni di uso generale o calcolo
 * di variabili da usare in qualsiasi modulo del plugin. Inserire in questa
 * classe le funzioni che vengono richiamate da moduli differenti.
 *
 * @package SZGoogle
 * @subpackage SZGoogleCommon
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome.

if (!class_exists('SZGoogleCommonButton'))
{
	class SZGoogleCommonButton
	{
		/**
		 * Funzione per disegno wrapper legato ad un bottone di uso
		 * comune a più moduli del plugin e con le stesse opzioni.
		 *
		 * @param  array $atts
		 * @return string
		 */
		static function getButton($atts) 
		{
			extract(shortcode_atts(array(
				'html'         => '',
				'text'         => '',
				'image'        => '',
				'content'      => '',
				'float'        => '',
				'align'        => '',
				'position'     => '',
				'class'        => '',
				'margintop'    => '',
				'marginright'  => '',
				'marginbottom' => '',
				'marginleft'   => '',
				'marginunit'   => '',
				'uniqueID'     => '',
			),$atts));

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!ctype_digit($margintop)    and $margintop    != 'none') $margintop    = ''; 
			if (!ctype_digit($marginright)  and $marginright  != 'none') $marginright  = ''; 
			if (!ctype_digit($marginbottom) and $marginbottom != 'none') $marginbottom = '1'; 
			if (!ctype_digit($marginleft)   and $marginleft   != 'none') $marginleft   = ''; 

			if (!in_array($marginunit,array('px','pt','em'))) $marginunit = 'em';

			// Calcolo il codice CSS da inserire nel primo wrapper
			// del bottone su cui si sta elaborando il rendering

			$CSS = '';

			if (!empty($float) and $float != 'none') $CSS .= 'float:'.$float.';';
			if (!empty($align) and $align != 'none') $CSS .= 'text-align:'.$align.';';

			// Calcolo il codice HTML per eseguire un WRAP sul
			// codice del bottone preparato in precedenza dal chiamante
	
			$HTML  = '<div class="'.$class.'"';
				if ($CSS      != '') $HTML .= ' style="'.$CSS.'"';
				if ($uniqueID != '') $HTML .= ' id="'.$uniqueID.'"';
			$HTML .= '>';

			$HTML .= '<div class="sz-google-button" style="';

			if (!empty($margintop)    and $margintop    != 'none') $HTML .= 'margin-top:'   .$margintop   .$marginunit.';';
			if (!empty($marginright)  and $marginright  != 'none') $HTML .= 'margin-right:' .$marginright .$marginunit.';';
			if (!empty($marginbottom) and $marginbottom != 'none') $HTML .= 'margin-bottom:'.$marginbottom.$marginunit.';';
			if (!empty($marginleft)   and $marginleft   != 'none') $HTML .= 'margin-left:'  .$marginleft  .$marginunit.';';

			$HTML .= '">';

			$HTML .= '<div class="sz-google-button-wrap" style="position:relative;">';
			$HTML .= '<div class="sz-google-button-body">';

			// Se trovo contenuto per il parametro "text" dello shortcode
			// lo aggiungo prima del codice embed originale di google

			if ($text != '') {
				$HTML .= '<div class="sz-google-button-text">';
				$HTML .= '<p>'.$text.'</p>';
				$HTML .= '</div>';
			}

			// Se trovo contenuto per il parametro "image" dello shortcode
			// lo aggiungo prima del codice embed originale di google

			if ($image != '') {
				$HTML .= '<div class="sz-google-button-imgs">';
				$HTML .= '<p><img src="'.$image.'" alt=""/></p>';
				$HTML .= '</div>';
			}

			// Se trovo contenuto tra inizio e fine dello shortcode
			// lo aggiungo prima del codice embed originale di google

			if ($content != '') {
				$HTML .= '<div class="sz-google-button-cont">';
				$HTML .= $content;
				$HTML .= '</div>';
			}

			$HTML .= '</div>';

			// Aggiunta del codice per inserimento iframe originale
			// di google con allineamento e posizionamento

			$HTML .= '<div class="sz-google-button-code">';
			$HTML .= '<div class="sz-google-button-side"';
			$HTML .= ' style="display:block;';

			if ($position == 'top')    $HTML .= 'position:absolute;width:100%;padding:0;top:1em;';		
			if ($position == 'center') $HTML .= 'position:absolute;width:100%;padding:0;top:40%;';		
			if ($position == 'bottom') $HTML .= 'position:absolute;width:100%;padding:0;bottom:1em;';		

			if ($align    == 'left')   $HTML .= 'left:1em;text-align:left';		
			if ($align    == 'center') $HTML .= 'left:0;text-align:center';		
			if ($align    == 'right')  $HTML .= 'right:1em;text-align:right';		

			$HTML .= '">';
			$HTML .= $html;
			$HTML .= '</div>';
			$HTML .= '</div>';

			$HTML .= '</div>';
			$HTML .= '</div>';
			$HTML .= '</div>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}
	}
}
