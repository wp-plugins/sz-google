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

if (!class_exists('SZGoogleActionHangoutsStart'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionHangoutsStart extends SZGoogleAction
	{
		/**
		 * Funzione per shortcode per avvio hangout che permette di
		 * eseguire un codice embed per il prodotto google hangouts
		 *
		 * @return string
		 */
		function getShortcode($atts,$content=null) 
		{
			return $this->getHTMLCode(shortcode_atts(array(
				'type'         => '', // valore predefinito
				'width'        => '180',
				'topic'        => '', // valore predefinito
				'float'        => '', // valore predefinito
				'align'        => '', // valore predefinito
				'text'         => '', // valore predefinito
				'img'          => '', // valore predefinito
				'position'     => '', // valore predefinito
				'margintop'    => '', // valore predefinito
				'marginright'  => '', // valore predefinito
				'marginbottom' => '', // valore predefinito
				'marginleft'   => '', // valore predefinito
				'marginunit'   => '', // valore predefinito
				'class'        => '', // valore predefinito
				'action'       => 'shortcode',
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
				'type'         => '', // valore predefinito
				'width'        => '', // valore predefinito
				'topic'        => '', // valore predefinito
				'float'        => '', // valore predefinito
				'align'        => '', // valore predefinito
				'text'         => '', // valore predefinito
				'img'          => '', // valore predefinito
				'position'     => '', // valore predefinito
				'margintop'    => '', // valore predefinito
				'marginright'  => '', // valore predefinito
				'marginbottom' => '', // valore predefinito
				'marginleft'   => '', // valore predefinito
				'marginunit'   => '', // valore predefinito
				'class'        => '', // valore predefinito
				'action'       => '', // valore predefinito
			),$atts));

			// Elimino spazi aggiunti di troppo ed eseguo la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$text         = trim($text);
			$img          = trim($img);
			$class        = trim($class);
			$topic        = htmlspecialchars(trim($topic),ENT_QUOTES);

			$type         = strtolower(trim($type));
			$width        = strtolower(trim($width));
			$align        = strtolower(trim($align));
			$float        = strtolower(trim($float));
			$position     = strtolower(trim($position));
			$margintop    = strtolower(trim($margintop));
			$marginright  = strtolower(trim($marginright));
			$marginbottom = strtolower(trim($marginbottom));
			$marginleft   = strtolower(trim($marginleft));
			$marginunit   = strtolower(trim($marginunit));

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!in_array($type,array('normal','onair','party','moderate')))   $type     = 'normal';
			if (!in_array($float,array('none','left','right')))                $float    = 'none';
			if (!in_array($align,array('none','left','right','center')))       $align    = 'none';
			if (!in_array($position,array('top','center','bottom','outside'))) $position = 'outside';

			if ($class == '') $class = 'sz-google-hangouts-button';
			if (!is_numeric($width) and $width != 'auto') $width = '';

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width == '')     $width = "'+w+'";
			if ($width == 'auto') $width = "'+w+'";

			$uniqueID = 'sz-google-hangouts-'.md5(uniqid(),false);

			// Creazione codice HTML per embed code da inserire nella pagina wordpress
			// prima praparo il codice del bottone singolo e poi chiamo funzione di wrapping

			$HTML  = '<script type="text/javascript">';
			$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
			$HTML .= "var h='<'+'";

			$HTML .= 'div class="g-hangout"';
			$HTML .= ' data-render="createhangout"';
			$HTML .= ' data-hangout_type="'.$type .'"';
			$HTML .= ' data-widget_size="' .$width.'"';

			if ($topic != '') $HTML .= ' data-topic="'.$topic.'"';

			$HTML .= "></'+'div'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';

			// Creazione codice HTML con funzione di wrapping comune a tutti i bottoni in maniera
			// da essere utilizzati anche come dei piccoli badge con immagine e posizionamento

			$HTML = SZGoogleCommonButton::getButton(array(
				'html'         => $HTML,
				'text'         => $text,
				'image'        => $img,
				'content'      => $content,
				'float'        => $float,
				'align'        => $align,
				'position'     => $position,
				'margintop'    => $margintop,
				'marginright'  => $marginright,
				'marginbottom' => $marginbottom,
				'marginleft'   => $marginleft,
				'marginunit'   => $marginunit,
				'class'        => $class,
				'uniqueID'     => $uniqueID,
			));

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta
			
			add_action('SZ_FOOT',array($this->getModuleObject('SZGoogleModuleHangouts'),'setJavascriptPlatform'));

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}
	}
}