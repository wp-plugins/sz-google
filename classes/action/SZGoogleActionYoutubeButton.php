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

if (!class_exists('SZGoogleActionYoutubeButton'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionYoutubeButton extends SZGoogleAction
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
				'layout'     => '', // valore predefinito
				'theme'      => '', // valore predefinito
				'subscriber' => '', // valore predefinito
				'align'      => '', // valore predefinito
			),$atts),$content,true);
		}

		/**
		 * Creazione codice HTML per il componente richiamato che
		 * deve essere usato in comune sia per widget che shortcode
		 *
		 * @return string
		 */
		function getHTMLCode($atts=array(),$content=null,$shortcode=false)
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'channel'    => '', // valore predefinito
				'layout'     => '', // valore predefinito
				'theme'      => '', // valore predefinito
				'subscriber' => '', // valore predefinito
				'align'      => '', // valore predefinito
			),$atts));

			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = (object) $this->getModuleOptions('SZGoogleModuleYoutube');

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$channel    = trim($channel);
			$layout     = strtolower(trim($layout));
			$theme      = strtolower(trim($theme));
			$subscriber = strtolower(trim($subscriber));
			$align      = strtolower(trim($align));

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if ($channel == '') $channel = $options->youtube_channel;
			if ($layout  == '') $layout  = 'default';
			if ($theme   == '') $theme   = 'default';
			if ($align   == '') $align   = 'none';

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if (!in_array($layout,array('default','full'))) $layout = 'default'; 
			if (!in_array($theme, array('default','dark'))) $theme  = 'default'; 
			if (!in_array($align, array('none','left','center','right'))) $align = 'none'; 

			// Conversione dei valori specificati direttamete nei parametri con
			// i valori usati per la memorizzazione dei valori di default

			if ($subscriber == 'yes' or $subscriber == 'y') $subscriber = '1'; 
			if ($subscriber == 'no'  or $subscriber == 'n') $subscriber = '0'; 

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			$YESNO = array('1','0');

			if (!in_array($subscriber,$YESNO)) $subscriber = '1'; 

			// Verifico se canale è un nome o identificativo univoco 
			// come ad esempio il canale wordpress italy+ UCJqiM61oRRvhTD5il2n56xg

			$type = $this->getModuleObject('SZGoogleModuleYoutube')->youtubeCheckChannel($channel);

			// Creazione contenitore principale per eseguire un metodo
			// di allineamento personalizzato usando le opzioni disponibili

			$style = '';

			if ($align != 'none')   $style .= 'text-align:'.$align.';';
			if ($shortcode == true) $style .= 'margin-bottom:1em;';

			// Creazione codice HTML per embed code da inserire nella pagina wordpress
			// ricordarsi di aggiungere il codice javascript per il rendering

			$HTML  = '<div class="s-ytsubscribe" style="'.$style.'">';
			$HTML .= '<div class="g-ytsubscribe" ';

			if ($type == 'ID') $HTML .= 'data-channelid="'.$channel.'" ';
				else $HTML .= 'data-channel="'.$channel.'" ';

			if ($subscriber == '1') $HTML .= 'data-count="default" ';
				else $HTML .= 'data-count="hidden" ';

			$HTML .= 'data-layout="'.$layout.'" ';
			$HTML .= 'data-theme="'.$theme.'"';
			$HTML .= '></div>';

			// Chiusura contenitore principale per eseguire un metodo
			// di allineamento personalizzato usando le opzioni disponibili

			$HTML .= '</div>';

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->getModuleObject('SZGoogleModuleYoutube')->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento di un video youtube 

			return $HTML;
		}	
	}
}