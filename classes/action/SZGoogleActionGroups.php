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

if (!class_exists('SZGoogleActionGroups'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionGroups extends SZGoogleAction
	{
		/**
		 * Funzione per shortcode per widget gruppo che permette di
		 * eseguire un codice embed per il prodotto google groups
		 *
		 * @return string
		 */
		function getShortcode($atts,$content=null) 
		{
			return $this->getHTMLCode(shortcode_atts(array(
				'name'           => '', // valore predefinito
				'domain'         => '', // valore predefinito
				'width'          => '', // valore predefinito
				'height'         => '', // valore predefinito
				'showsearch'     => '', // valore predefinito
				'showtabs'       => '', // valore predefinito
				'hideforumtitle' => '', // valore predefinito
				'hidesubject'    => '', // valore predefinito
				'hl'             => '', // valore predefinito
				'action'         => 'shortcode',
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
			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = $this->getModuleOptions('SZGoogleModuleGroups');

			if ($options['groups_showsearch']  == '1') $options['groups_showsearch']  = 'true'; else $options['groups_showsearch']  = 'false';  
			if ($options['groups_showtabs']    == '1') $options['groups_showtabs']    = 'true'; else $options['groups_showtabs']    = 'false';  
			if ($options['groups_hidetitle']   == '1') $options['groups_hidetitle']   = 'true'; else $options['groups_hidetitle']   = 'false';  
			if ($options['groups_hidesubject'] == '1') $options['groups_hidesubject'] = 'true'; else $options['groups_hidesubject'] = 'false';  

			// Se non è specificvata nessuna lingua o quella del tema richiamo
			// la funzione nativa di wordpress per calcolare la lingua di sistema

			if ($options['groups_language'] == '99') $language = substr(get_bloginfo('language'),0,2);	
				else $language = trim($options['groups_language']);

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'name'           => '', // valore predefinito
				'domain'         => '', // valore predefinito
				'width'          => '', // valore predefinito
				'height'         => '', // valore predefinito
				'showsearch'     => '', // valore predefinito
				'showtabs'       => '', // valore predefinito
				'hideforumtitle' => '', // valore predefinito
				'hidesubject'    => '', // valore predefinito
				'hl'             => '', // valore predefinito
				'action'         => '', // valore predefinito
			),$atts));

			// Controllo le variabili che devono avere obbligatorio il valore 
			// di true o false, in caso diverso prendo il valore di default specificato 

			$hl             = trim($hl);
			$name           = trim($name);
			$domain         = trim($domain);

			$showsearch     = strtolower(trim($showsearch));
			$showtabs       = strtolower(trim($showtabs));
			$hideforumtitle = strtolower(trim($hideforumtitle));
			$hidesubject    = strtolower(trim($hidesubject));

			if (!in_array($showsearch,    array('true','false'))) $showsearch     = $options['groups_showsearch']; 
			if (!in_array($showtabs,      array('true','false'))) $showtabs       = $options['groups_showtabs']; 
			if (!in_array($hideforumtitle,array('true','false'))) $hideforumtitle = $options['groups_hidetitle']; 
			if (!in_array($hidesubject,   array('true','false'))) $hidesubject    = $options['groups_hidesubject']; 

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if ($name == '') $name = $options['groups_name'];
			if ($name == '') $name = 'adsense-api';

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if ($width  == '' or $width  == '0' or !is_numeric($width))  $width  = $options['groups_width'];
			if ($height == '' or $height == '0' or !is_numeric($height)) $height = $options['groups_height'];

			if ($width  == '' or $width  == '0' or !is_numeric($width))  $width  = '100%';
			if ($height == '' or $height == '0' or !is_numeric($height)) $height = '700';

			// Creazione codice HTML per embed code da inserire nella pagina wordpress
			// prima praparo il codice del bottone singolo e poi chiamo funzione di wrapping

			$HTML  = '<script type="text/javascript">';
			$HTML .= "var h='<'+'";
			$HTML .= 'iframe src="https://groups.google.com/forum/embed/?place='.urlencode('forum/'.$name);
			$HTML .= '&amp;hl='.urlencode($hl);
			$HTML .= '&amp;showsearch='.urlencode($showsearch);
			$HTML .= '&amp;showtabs='.urlencode($showtabs);
			$HTML .= '&amp;hideforumtitle='.urlencode($hideforumtitle);
			$HTML .= '&amp;hidesubject='.urlencode($hidesubject);
			$HTML .= '&amp;showpopout=true';

			if ($domain != '') $HTML .= '&amp;domain='.urlencode($domain);

			// Se sono in locahost non calcolo URL della pagina attuale, in caso
			// contrario allego la funzione javascript per inserire il parametro in URL

			if (isset($_SERVER['HTTP_HOST']) and strtolower($_SERVER['HTTP_HOST']) == 'localhost') 
			{
				$HTML .= '" ';

			} else {

				$HTML .= "&amp;parenturl=' + encodeURIComponent(window.location.href) + '\"' + ";
				$HTML .= "' ";
			}

			$HTML .= 'width="' .$width .'" ';
			$HTML .= 'height="'.$height.'" ';
			$HTML .= 'style="border-width:0" ';
			$HTML .= 'frameborder="0" scrolling="no"';
			$HTML .= "></'+'iframe'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}
	}
}