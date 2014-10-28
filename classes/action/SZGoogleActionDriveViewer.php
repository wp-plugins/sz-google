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

if (!class_exists('SZGoogleActionDriveViewer'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionDriveViewer extends SZGoogleAction
	{
		/**
		 * Funzione per shortcode per drive viewer che permette di
		 * eseguire un codice embed per il prodotto google drive
		 *
		 * @return string
		 */
		function getShortcode($atts,$content=null) 
		{
			return $this->getHTMLCode(shortcode_atts(array(
				'url'           => '', // valore predefinito
				'title'         => '', // valore predefinito
				'titleposition' => '', // valore predefinito
				'titlealign'    => '', // valore predefinito
				'width'         => '', // valore predefinito
				'height'        => '', // valore predefinito
				'margintop'     => '', // valore predefinito
				'marginright'   => '', // valore predefinito
				'marginbottom'  => '', // valore predefinito
				'marginleft'    => '', // valore predefinito
				'marginunit'    => '', // valore predefinito
				'action'        => 'shortcode',
			),$atts),$content);
		}

		/**
		 * Creazione codice HTML per il componente richiamato che
		 * deve essere usato in comune sia per widget che shortcode
		 *
		 * @return string
		 */
		function getHTMLCode($atts=array(),$content=null)
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'url'           => '', // valore predefinito
				'title'         => '', // valore predefinito
				'titleposition' => '', // valore predefinito
				'titlealign'    => '', // valore predefinito
				'width'         => '', // valore predefinito
				'height'        => '', // valore predefinito
				'margintop'     => '', // valore predefinito
				'marginright'   => '', // valore predefinito
				'marginbottom'  => '', // valore predefinito
				'marginleft'    => '', // valore predefinito
				'marginunit'    => '', // valore predefinito
				'action'        => '', // valore predefinito
			),$atts));

			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = $this->getModuleOptions('SZGoogleModuleDrive');

			// Elimino spazi aggiunti di troppo ed eseguo la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$url           = trim($url);
			$title         = esc_html(trim($title));

			$titleposition = strtolower(trim($titleposition));
			$titlealign    = strtolower(trim($titlealign));
			$width         = strtolower(trim($width));
			$height        = strtolower(trim($height));
			$margintop     = strtolower(trim($margintop));
			$marginright   = strtolower(trim($marginright));
			$marginbottom  = strtolower(trim($marginbottom));
			$marginleft    = strtolower(trim($marginleft));
			$marginunit    = strtolower(trim($marginunit));

			// Se non specifico un URL valido per la creazione del bottone
			// esco dalla funzione e ritorno una stringa vuota

			if (empty($url)) { return ''; }

			// Configurazione delle variabili per la creazione del codice
			// HTML da utilizzare rispettando le opzioni richieste

			$optionSRC = 'https://docs.google.com/viewer?url='.rawurlencode($url).'&embedded=true';

			// Controllo le variabili usate come opzioni da utilizzare nel caso
			// non esistano valori specificati o valori non coerenti con quelli ammessi

			if ($action == 'widget') {
				if ($width         == '') $width         = $options['drive_viewer_w_width'];
				if ($height        == '') $height        = $options['drive_viewer_w_height'];
				if ($titleposition == '') $titleposition = $options['drive_viewer_w_t_position'];
				if ($titlealign    == '') $titlealign    = $options['drive_viewer_w_t_align'];
			} else {
				if ($width         == '') $width         = $options['drive_viewer_s_width'];
				if ($height        == '') $height        = $options['drive_viewer_s_height'];
				if ($titleposition == '') $titleposition = $options['drive_viewer_s_t_position'];
				if ($titlealign    == '') $titlealign    = $options['drive_viewer_s_t_align'];
			}

			if (!in_array($titleposition,array('top','bottom'))) $titleposition = 'top'; 
			if (!in_array($titlealign,array('none','left','right','center'))) $titlealign = 'none'; 

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width  == '')     $width = "100%";
			if ($width  == 'auto') $width = "100%";

			if ($height == '')     $height = '400';
			if ($height == 'auto') $height = '400';

			// Creazione del codice CSS per la composizione dei margini
			// usando le opzioni specificate negli shortcode o nelle funzioni PHP

			$marginCSS = $this->getModuleObject('SZGoogleModuleDrive')->getStyleCSSfromMargins(
				$margintop,$marginright,$marginbottom,$marginleft,$marginunit);

			$talignCSS = $this->getModuleObject('SZGoogleModuleDrive')->getStyleCSSfromAlign($titlealign);

			$TITLE  = '<div class="sz-google-drive-viewer-title" style="padding:0.5em;'.$talignCSS.'">'.$title.'</div>';

			// Apertura delle divisioni che rappresentano il wrapper
			// comune per eventuali personalizzazioni di visualizzazione

			$HTML  = '<div class="sz-google-drive">';
			$HTML .= '<div class="sz-google-drive-viewer" style="'.$marginCSS.'">';

			if ($title != "" and $titleposition == 'top') $HTML .= $TITLE;

			$HTML .= '<div class="sz-google-drive-viewer-embed">';
			$HTML .= '<script type="text/javascript">';
			$HTML .= "var h='<'+'";

			$HTML .= 'iframe src="'.$optionSRC.'"';
			$HTML .= ' width="' .$width .'"';
			$HTML .= ' height="'.$height.'"';
			$HTML .= ' frameborder="0"';
			$HTML .= ' style="border:none;"';

			$HTML .= "></'+'iframe'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';
			$HTML .= '</div>';

			// Chiusura delle divisioni che rappresentano il wrapper

			if ($title != "" and $titleposition == 'bottom') $HTML .= $TITLE;

			$HTML .= '</div>';
			$HTML .= '</div>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}
	}
}