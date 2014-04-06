<?php
/**
 * Modulo GOOGLE DRIVE per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleModuleDrive'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleDrive extends SZGoogleModule
	{
		protected $setJavascriptPlusone = false;

		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			parent::__construct('SZGoogleModuleDrive');

			$this->moduleShortcodes = array(
				'drive_embed_shortcode'      => array('sz-drive-embed' ,array($this,'getDriveEmbedShortcode')),
				'drive_viewer_shortcode'     => array('sz-drive-viewer',array($this,'getDriveViewerShortcode')),
				'drive_savebutton_shortcode' => array('sz-drive-save'  ,array($this,'getDriveSaveButtonShortcode')),
			);

			$this->moduleWidgets = array(
				'drive_embed_widget'         => 'SZGoogleWidgetDriveEmbed',
				'drive_viewer_widget'        => 'SZGoogleWidgetDriveViewer',
				'drive_savebutton_widget'    => 'SZGoogleWidgetDriveSaveButton',
			);

			// Esecuzione dei componenti esistenti legati al modulo come
			// le azioni generali e la generazione di shortcode e widget.

			$this->moduleAddShortcodes();
			$this->moduleAddWidgets();
		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptions()
		{
			$options = get_option('sz_google_options_drive');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'drive_sitename'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_shortcode'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_s_width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_s_height'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_s_height_p'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_s_height_v'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_widget'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_w_width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_w_height'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_w_height_p'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_embed_w_height_v'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_shortcode'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_s_width'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_s_height'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_s_t_position'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_s_t_align'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_widget'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_w_width'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_w_height'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_w_t_position'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_viewer_w_t_align'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_savebutton_widget'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_savebutton_shortcode' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			));

			// Controllo delle opzioni in caso di valori non conformi
			// richiamo della funzione per il controllo Yes o No

			$options = $this->checkOptionIsYesNo($options,array(
				'drive_embed_shortcode'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive_embed_widget'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive_viewer_shortcode'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive_viewer_widget'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive_savebutton_widget'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive_savebutton_shortcode' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali della funzione di reperimento opzioni

			return $options;
		}

		/**
		 * Funzione per shortcode [sz-drive-embed] che permette di
		 * eseguire un codice embed per la visualizzazione di documenti
		 *
		 * @return string
		 */
		function getDriveEmbedShortcode($atts,$content=null) 
		{
			return $this->getDriveEmbedCode(shortcode_atts(array(
				'type'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'id'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'single'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'gid'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'range'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'start'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'loop'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'delay'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'folderview'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'        => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Aggiungo il modulo generale con lo shortcode e il widget per
		 * eseguire la funzione di embed su visualizzazione documento
		 *
		 * @return string
		 */
		function getDriveEmbedCode($atts=array(),$content=null)
		{
			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'type'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'id'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'single'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'gid'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'range'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'start'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'loop'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'delay'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'folderview'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = $this->getOptions();

			// Elimino spazi aggiunti di troppo ed eseguo la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$id            = trim($id);
			$type          = strtolower(trim($type));
			$single        = strtolower(trim($single));
			$gid           = strtolower(trim($gid));
			$range         = strtolower(trim($range));
			$start         = strtolower(trim($start));
			$loop          = strtolower(trim($loop));
			$delay         = strtolower(trim($delay));
			$folderview    = strtolower(trim($folderview));
			$width         = strtolower(trim($width));
			$height        = strtolower(trim($height));
			$margintop     = strtolower(trim($margintop));
			$marginright   = strtolower(trim($marginright));
			$marginbottom  = strtolower(trim($marginbottom));
			$marginleft    = strtolower(trim($marginleft));
			$marginunit    = strtolower(trim($marginunit));

			// Se non specifico un URL valido per la creazione del bottone
			// esco dalla funzione e ritorno una stringa vuota

			if (empty($id)) { return SZ_PLUGIN_GOOGLE_VALUE_NULL; }

			// Controllo le impostazioni che riguardano la dimensione del componente
			// in quanto alcuni documenti hanno una dimensione di default specifica

			if ($action == SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
			{
				if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width  = $options['drive_embed_w_width'];
				if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
				{
					if ($type == 'document')     $height = $options['drive_embed_w_height'];
					if ($type == 'folder')       $height = $options['drive_embed_w_height'];
					if ($type == 'pdf')          $height = $options['drive_embed_w_height'];
					if ($type == 'forms')        $height = $options['drive_embed_w_height'];
					if ($type == 'presentation') $height = $options['drive_embed_w_height_p'];
					if ($type == 'spreadsheet')  $height = $options['drive_embed_w_height'];
					if ($type == 'video')        $height = $options['drive_embed_w_height_v'];
				}

			// Controllo le impostazioni che riguardano la dimensione del componente
			// in quanto alcuni documenti hanno una dimensione di default specifica

			} else {

				if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width  = $options['drive_embed_s_width'];
				if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
				{
					if ($type == 'document')     $height = $options['drive_embed_s_height'];
					if ($type == 'folder')       $height = $options['drive_embed_s_height'];
					if ($type == 'pdf')          $height = $options['drive_embed_s_height'];
					if ($type == 'forms')        $height = $options['drive_embed_s_height'];
					if ($type == 'presentation') $height = $options['drive_embed_s_height_p'];
					if ($type == 'spreadsheet')  $height = $options['drive_embed_s_height'];
					if ($type == 'video')        $height = $options['drive_embed_s_height_v'];
				}
			}

			// Controllo le variabili usate come opzioni da utilizzare nel caso
			// non esistano valori specificati o valori non coerenti con quelli ammessi

			if (!in_array($start ,array('true','false'))) $start  = 'false'; 
			if (!in_array($loop  ,array('true','false'))) $loop   = 'false'; 
			if (!in_array($single,array('true','false'))) $single = 'false'; 

			if (!in_array($type,array('folder','document','presentation','spreadsheet','forms','pdf','video'))) $type = 'document'; 
			if (!in_array($folderview,array('list','grid'))) $folderview = 'list'; 

			// Controllo dei campi numerici e verifica che non contengano
			// caratteri non numerici, nel caso applico i valori di default

			if (!ctype_digit($delay)) $delay  = '3';
			if (!ctype_digit($width)) $width  = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			if (!ctype_digit($height))$height = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			if (!ctype_digit($gid))   $gid    = SZ_PLUGIN_GOOGLE_VALUE_ZERO;

			// Configurazione delle variabili per la creazione del codice
			// HTML da utilizzare rispettando le opzioni richieste

			if ($type == 'folder')       $optionSRC = 'https://docs.google.com/embeddedfolderview?id=%s#%s';
			if ($type == 'document')     $optionSRC = 'https://docs.google.com/document/d/%s/pub?embedded=true';
			if ($type == 'presentation') $optionSRC = 'https://docs.google.com/presentation/d/%s/embed?start=%s&amp;loop=%s&amp;delayms=%s';
			if ($type == 'spreadsheet')  $optionSRC = 'https://docs.google.com/spreadsheet/pub?key=%s&amp;output=html&amp;widget=true&amp;single=%s&amp;gid=%s';
			if ($type == 'forms')        $optionSRC = 'https://docs.google.com/forms/d/%s/viewform?embedded=true';
			if ($type == 'pdf')          $optionSRC = 'https://docs.google.com/file/d/%s/preview';
			if ($type == 'video')        $optionSRC = 'https://docs.google.com/file/d/%s/preview';

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "100%";
			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "100%";

			if (in_array($type,array('presentation','video'))) {
				if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = '250';
				if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = '250';
			} else {
				if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = '400';
				if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = '400';
			} 

			// Creazione del codice CSS per la composizione dei margini
			// usando le opzioni specificate negli shortcode o nelle funzioni PHP

			$marginCSS = $this->getStyleCSSfromMargins(
				$margintop,$marginright,$marginbottom,$marginleft,$marginunit);

			// Creazione URL iframe in base alla tipologia rchiesta e i vari formati
			// che differiscono dal numero e dal nome delle opzioni permesse.

			if ($type == 'folder')       $optionSRC = sprintf($optionSRC,urlencode($id),urlencode($folderview));
			if ($type == 'document')     $optionSRC = sprintf($optionSRC,urlencode($id));
			if ($type == 'spreadsheet')  $optionSRC = sprintf($optionSRC,urlencode($id),urlencode($single),urlencode($gid),urlencode($range));
			if ($type == 'presentation') $optionSRC = sprintf($optionSRC,urlencode($id),urlencode($start),urlencode($loop),urlencode($delay.'000'));
			if ($type == 'forms')        $optionSRC = sprintf($optionSRC,urlencode($id));
			if ($type == 'pdf')          $optionSRC = sprintf($optionSRC,urlencode($id));
			if ($type == 'video')        $optionSRC = sprintf($optionSRC,urlencode($id));

			if ($type == 'spreadsheet' && $range != SZ_PLUGIN_GOOGLE_VALUE_NULL) $optionSRC .= "&amp;range=".urlencode($range);

			// Apertura delle divisioni che rappresentano il wrapper
			// comune per eventuali personalizzazioni di visualizzazione

			$HTML  = '<div class="sz-google-drive">';
			$HTML .= '<div class="sz-google-drive-embed" style="'.$marginCSS.'">';

			$HTML .= '<div class="sz-google-drive-embed-embed">';
			$HTML .= '<script type="text/javascript">';
			$HTML .= "var h='<'+'";

			$HTML .= 'iframe src="'.$optionSRC.'"';
			$HTML .= ' width="' .$width .'"';
			$HTML .= ' height="'.$height.'"';
			$HTML .= ' frameborder="0"';
			$HTML .= ' style="border:none;"';

			if ($type == 'presentation') {
				$HTML .= ' allowfullscreen="true"';
				$HTML .= ' mozallowfullscreen="true"';
				$HTML .= ' webkitallowfullscreen="true"';
			}

			$HTML .= "></'+'iframe'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';
			$HTML .= '</div>';

			// Chiusura delle divisioni che rappresentano il wrapper

			$HTML .= '</div>';
			$HTML .= '</div>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per shortcode [sz-drive-viewer] che permette di
		 * eseguire un codice embed per la visualizzazione di documenti
		 *
		 * @return string
		 */
		function getDriveViewerShortcode($atts,$content=null) 
		{
			return $this->getDriveViewerCode(shortcode_atts(array(
				'url'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'title'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'titleposition' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'titlealign'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'        => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Aggiungo il modulo generale con lo shortcode e il widget per
		 * eseguire la funzione di embed su visualizzazione documento
		 *
		 * @return string
		 */
		function getDriveViewerCode($atts=array(),$content=null)
		{
			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'url'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'title'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'titleposition' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'titlealign'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = $this->getOptions();

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

			if (empty($url)) { return SZ_PLUGIN_GOOGLE_VALUE_NULL; }

			// Configurazione delle variabili per la creazione del codice
			// HTML da utilizzare rispettando le opzioni richieste

			$optionSRC = 'https://docs.google.com/viewer?url='.rawurlencode($url).'&embedded=true';

			// Controllo le variabili usate come opzioni da utilizzare nel caso
			// non esistano valori specificati o valori non coerenti con quelli ammessi

			if ($action == SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) {
				if ($width         == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width         = $options['drive_viewer_w_width'];
				if ($height        == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height        = $options['drive_viewer_w_height'];
				if ($titleposition == SZ_PLUGIN_GOOGLE_VALUE_NULL) $titleposition = $options['drive_viewer_w_t_position'];
				if ($titlealign    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $titlealign    = $options['drive_viewer_w_t_align'];
			} else {
				if ($width         == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width         = $options['drive_viewer_s_width'];
				if ($height        == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height        = $options['drive_viewer_s_height'];
				if ($titleposition == SZ_PLUGIN_GOOGLE_VALUE_NULL) $titleposition = $options['drive_viewer_s_t_position'];
				if ($titlealign    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $titlealign    = $options['drive_viewer_s_t_align'];
			}

			if (!in_array($titleposition,array('top','bottom'))) $titleposition = 'top'; 
			if (!in_array($titlealign,array('none','left','right','center'))) $titlealign = 'none'; 

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "100%";
			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "100%";

			if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = '400';
			if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = '400';

			// Creazione del codice CSS per la composizione dei margini
			// usando le opzioni specificate negli shortcode o nelle funzioni PHP

			$marginCSS = $this->getStyleCSSfromMargins(
				$margintop,$marginright,$marginbottom,$marginleft,$marginunit);

			$talignCSS = $this->getStyleCSSfromAlign($titlealign);

			$TITLE  = '<div class="sz-google-drive-viewer-title" style="padding:0.5em;'.$talignCSS.'">'.$title.'</div>';

			// Apertura delle divisioni che rappresentano il wrapper
			// comune per eventuali personalizzazioni di visualizzazione

			$HTML  = '<div class="sz-google-drive">';
			$HTML .= '<div class="sz-google-drive-viewer" style="'.$marginCSS.'">';

			if ($titleposition == 'top') $HTML .= $TITLE;

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

			if ($titleposition == 'bottom') $HTML .= $TITLE;

			$HTML .= '</div>';
			$HTML .= '</div>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per shortcode [sz-drive-save] che permette di
		 * eseguire un codice embed per il bottone save to drive
		 *
		 * @return string
		 */
		function getDriveSaveButtonShortcode($atts,$content=null) 
		{
			return $this->getDriveSaveButtonCode(shortcode_atts(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'filename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'sitename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Aggiungo il modulo generale con lo shortcode e il widget per
		 * eseguire la funzione di embed su bottone salva su drive
		 *
		 * @return string
		 */
		function getDriveSaveButtonCode($atts=array(),$content=null)
		{
			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'filename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'sitename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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

			if (empty($url)) { return SZ_PLUGIN_GOOGLE_VALUE_NULL; }

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!in_array($align,array('none','left','right','center'))) $align = $DEFAULT_ALIGN; 
			if (!in_array($position,array('top','center','bottom','outside'))) $position = $DEFAULT_POSITION; 

			if (empty($sitename)) $sitename = get_bloginfo('name'); 
			if (empty($sitename)) $sitename = SZ_PLUGIN_GOOGLE_DRIVE_SITENAME; 
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

			$HTML = SZGoogleModuleButton::getButton(array(
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

			$this->addCodeJavascriptFooter();

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per aggiungere il codice javascript dei vari
		 * componenti di google plus nel footer e controllo se 
		 * la richiesta è stata eseguita già in qualche parte diversa
		 *
		 * @return void
		 */
		function addCodeJavascriptFooter()
		{
			// Se ho già inserito il codice javascript nella sezione footer
			// esco dalla funzione altrimenti setto la variabile e continuo

			if ($this->setJavascriptPlusone) return;
				else $this->setJavascriptPlusone = true;

			// Caricamento azione nel footer del plugin per il caricamento
			// del framework javascript messo a disposizione da google

			add_action('szgoogle_footer',array($this,'setJavascriptPlusOne'));
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */
	if (!function_exists('szgoogle_drive_get_object')) {
		function szgoogle_drive_get_object() { 
			if (!is_a(SZGoogleModule::$SZGoogleModuleDrive,'SZGoogleModuleDrive')) return false;
				else return SZGoogleModule::$SZGoogleModuleDrive;
		}
	}

	if (!function_exists('szgoogle_drive_get_embed')) {
		function szgoogle_drive_get_embed($options=array()) {
			if (!$object = szgoogle_drive_get_object()) return false;
				else return $object->getDriveEmbedCode($options);
		}
	}

	if (!function_exists('szgoogle_drive_get_viewer')) {
		function szgoogle_drive_get_viewer($options=array()) {
			if (!$object = szgoogle_drive_get_object()) return false;
				else return $object->getDriveViewerCode($options);
		}
	}

	if (!function_exists('szgoogle_drive_get_savebutton')) {
		function szgoogle_drive_get_savebutton($options=array()) {
			if (!$object = szgoogle_drive_get_object()) return false;
				else return $object->getDriveSaveButtonCode($options);
		}
	}
}