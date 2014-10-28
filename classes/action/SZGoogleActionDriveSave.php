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

if (!class_exists('SZGoogleActionDriveSave'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionDriveSave extends SZGoogleAction
	{
		/**
		 * Funzione per shortcode drive save che permette di
		 * eseguire un codice embed per il prodotto google drive
		 *
		 * @return string
		 */
		function getShortcode($atts,$content=null) 
		{
			return $this->getHTMLCode(shortcode_atts(array(
				'url'          => '', // valore predefinito
				'filename'     => '', // valore predefinito
				'sitename'     => '', // valore predefinito
				'text'         => '', // valore predefinito
				'img'          => '', // valore predefinito
				'position'     => '', // valore predefinito
				'align'        => '', // valore predefinito
				'margintop'    => '', // valore predefinito
				'marginright'  => '', // valore predefinito
				'marginbottom' => '', // valore predefinito
				'marginleft'   => '', // valore predefinito
				'marginunit'   => '', // valore predefinito
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
				'url'          => '', // valore predefinito
				'filename'     => '', // valore predefinito
				'sitename'     => '', // valore predefinito
				'text'         => '', // valore predefinito
				'img'          => '', // valore predefinito
				'position'     => '', // valore predefinito
				'align'        => '', // valore predefinito
				'margintop'    => '', // valore predefinito
				'marginright'  => '', // valore predefinito
				'marginbottom' => '', // valore predefinito
				'marginleft'   => '', // valore predefinito
				'marginunit'   => '', // valore predefinito
				'action'       => '', // valore predefinito
			),$atts));

			$DEFAULT_ALIGN      = 'none';
			$DEFAULT_POSITION   = 'outside';

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$url          = trim($url);
			$filename     = trim($filename);
			$sitename     = trim($sitename);
			$text         = trim($text);
			$img          = trim($img);

			$position     = strtolower(trim($position));
			$align        = strtolower(trim($align));
			$margintop    = strtolower(trim($margintop));
			$marginright  = strtolower(trim($marginright));
			$marginbottom = strtolower(trim($marginbottom));
			$marginleft   = strtolower(trim($marginleft));
			$marginunit   = strtolower(trim($marginunit));

			// Se non specifico un URL valido per la creazione del bottone
			// esco dalla funzione e ritorno una stringa vuota

			if (empty($url)) { return ''; }

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!in_array($align,array('none','left','right','center'))) $align = $DEFAULT_ALIGN; 
			if (!in_array($position,array('top','center','bottom','outside'))) $position = $DEFAULT_POSITION; 

			if (empty($sitename)) $sitename = get_bloginfo('name'); 
			if (empty($sitename)) $sitename = 'Website'; 
			if (empty($filename)) $filename = basename($url);

			// Calcolo il nome host attuale di wordpress in maniera da preparare
			// la stringa per la sostituzione sonlo se link è sullo stesso dominio

			$URLBlog = home_url('/');
			$URLBlog = parse_url($URLBlog);

			if(isset($URLBlog['host'])) {
				$url = preg_replace('#^https?://'.$URLBlog['host'].'#','', $url);
			}

			// Creazione codice HTML per embed code da inserire nella pagina wordpress

			$HTML  = '<div class="g-savetodrive"';
			$HTML .= ' data-src="'     .$url     .'"';
			$HTML .= ' data-filename="'.$filename.'"';
			$HTML .= ' data-sitename="'.$sitename.'"';
			$HTML .= '></div>';

			$HTML = SZGoogleCommonButton::getButton(array(
				'html'         => $HTML,
				'text'         => $text,
				'image'        => $img,
				'content'      => $content,
				'align'        => $align,
				'position'     => $position,
				'margintop'    => $margintop,
				'marginright'  => $marginright,
				'marginbottom' => $marginbottom,
				'marginleft'   => $marginleft,
				'marginunit'   => $marginunit,
				'class'        => 'sz-google-savetodrive',
			));

			// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
			// viene aggiungo anche dalla sidebar però viene inserito una sola volta

			$this->getModuleObject('SZGoogleModuleDrive')->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}
	}
}