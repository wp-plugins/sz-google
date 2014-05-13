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

if (!class_exists('SZGoogleActionYoutubeBadge'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionYoutubeBadge extends SZGoogleAction
	{
		/**
		 * Funzione per shortcode youtube badge che permette di
		 * eseguire un codice embed per il prodotto google youtube
		 *
		 * @return string
		 */
		function getShortcode($atts,$content=null) 
		{
			return $this->getHTMLCode(shortcode_atts(array(
				'channel'    => '', // valore predefinito
				'width'      => '', // valore predefinito
				'widthunit'  => '', // valore predefinito
				'height'     => '', // valore predefinito
				'heightunit' => '', // valore predefinito
				'action'     => 'shortcode',
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
				'channel'    => '',
				'width'      => '',
				'widthunit'  => '',
				'height'     => '',
				'heightunit' => '',
				'action'     => '',
			),$atts));

			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = (object) $this->getModuleOptions('SZGoogleModuleYoutube');

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$channel    = trim($channel);
			$width      = trim($width);
			$widthunit  = trim($widthunit);
			$height     = trim($height);
			$heightunit = trim($heightunit);

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if ($channel    == '') $channel    = $options->youtube_channel;
			if ($width      == '') $width      = '300';
			if ($height     == '') $height     = '100';
			if ($widthunit  == '') $widthunit  = 'px';
			if ($heightunit == '') $heightunit = 'px';

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if (!ctype_digit($width))  $width  = '300'; 
			if (!ctype_digit($height)) $height = '100'; 

			// Creazione codice HTML per embed code da inserire nella pagina wordpress

			$HTML  = '<iframe src="https://www.youtube.com/subscribe_widget?p='.$channel.'" ';
			$HTML .= 'style="overflow:hidden;';
			$HTML .= 'width:'.$width.$widthunit.';';
			$HTML .= 'height:'.$height.$heightunit.';';
			$HTML .= 'border:0;" ';
			$HTML .= 'scrolling="no" frameborder="0"';
			$HTML .= '></iframe>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento di un video youtube 

			return $HTML;
		}
	}
}