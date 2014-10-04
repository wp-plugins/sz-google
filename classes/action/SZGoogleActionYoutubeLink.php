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

if (!class_exists('SZGoogleActionYoutubeLink'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionYoutubeLink extends SZGoogleAction
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
				'channel'      => '', // valore predefinito
				'subscription' => '', // valore predefinito
				'text'         => '', // valore predefinito
				'image'        => '', // valore predefinito
				'newtab'       => '', // valore predefinito
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
				'channel'      => '', // valore predefinito
				'subscription' => '', // valore predefinito
				'text'         => '', // valore predefinito
				'image'        => '', // valore predefinito
				'newtab'       => '', // valore predefinito
			),$atts));

			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = (object) $this->getModuleOptions('SZGoogleModuleYoutube');

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$channel      = trim($channel);
			$subscription = trim($subscription);
			$text         = trim($text);
			$image        = trim($image);
			$newtab       = trim($newtab);

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if ($channel      == '') $channel       = $options->youtube_channel;
			if ($subscription == '') $subscription  = '1';
			if ($newtab       == '') $newtab        = '0';
			if ($text         == '') $text          = SZGoogleCommon::getTranslate('channel youtube');

			// Conversione dei valori specificati direttamete nei parametri con
			// i valori usati per la memorizzazione dei valori di default

			if ($newtab       == 'yes' or $newtab       == 'y') $newtab       = '1'; 
			if ($newtab       == 'no'  or $newtab       == 'n') $newtab       = '0'; 

			if ($subscription == 'yes' or $subscription == 'y') $subscription = '1'; 
			if ($subscription == 'no'  or $subscription == 'n') $subscription = '0'; 

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			$YESNO = array('1','0');

			if (!in_array($newtab,$YESNO))       $newtab       = '1'; 
			if (!in_array($subscription,$YESNO)) $subscription = '1'; 

			// Verifico se canale è un nome o identificativo univoco 
			// come ad esempio il canale wordpress italy+ UCJqiM61oRRvhTD5il2n56xg

			$type = $this->getModuleObject('SZGoogleModuleYoutube')->youtubeCheckChannel($channel);

			if ($type == 'ID') $ytURL = 'http://www.youtube.com/channel/';
				else $ytURL = 'http://www.youtube.com/user/';

			// Creazione HREF per il canale youtube con il controllo
			// per aggiungere il parametro che riguarda la sottoscrizione

			if ($newtab == '0') $NEWTAB = ''; else $NEWTAB = ' target="_blank"';

			if ($subscription == '0') $HREF = '<a href="'.$ytURL.$channel.'"'.$NEWTAB.'>'; 
				else $HREF = '<a href="'.$ytURL.$channel.'?sub_confirmation='.$subscription.'"'.$NEWTAB.'>';

			// Se viene indicata un'immagine vado sostituire la stringa text 
			// inmaniera da dare priorità all'immagine rispetto al testo

			if ($image != '') $text = '<img src="'.$image.'" alt=""/>'; 

			// Creazione codice HTML per embed code da inserire nella pagina wordpress
			// Se esiste il contenuto tra lo shortcode o prendo i valori delle opzioni

			if (empty($content)) $HTML = $HREF.$text.'</a>';
				else $HTML  = $HREF.$content.'</a>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento di un video youtube 

			return $HTML;
		}
	}
}