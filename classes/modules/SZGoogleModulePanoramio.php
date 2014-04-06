<?php
/**
 * Modulo GOOGLE PANORAMIO per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleModulePanoramio'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModulePanoramio extends SZGoogleModule
	{
		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			parent::__construct('SZGoogleModulePanoramio');

			$this->moduleShortcodes = array(
				'panoramio_shortcode' => array('sz-panoramio',array($this,'getPanoramioShortcode')),
			);

			$this->moduleWidgets = array(
				'panoramio_widget'    => 'SZGoogleWidgetPanoramio',
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
			$options = get_option('sz_google_options_panoramio');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'panoramio_widget'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_shortcode'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_template'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_width'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_height'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_orientation' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_list_size'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_position'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_paragraph'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_delay'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_set'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_columns'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_s_rows'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_template'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_width'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_height'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_orientation' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_list_size'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_position'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_paragraph'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_delay'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_set'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_columns'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'panoramio_w_rows'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			));

			// Controllo delle opzioni in caso di valori non conformi
			// richiamo della funzione per il controllo isnull()

			$options = $this->checkOptionIsNull($options,array(
				'panoramio_s_template'    => SZ_PLUGIN_GOOGLE_PANORAMIO_S_TEMPLATE,
				'panoramio_s_width'       => SZ_PLUGIN_GOOGLE_PANORAMIO_S_WIDTH,
				'panoramio_s_height'      => SZ_PLUGIN_GOOGLE_PANORAMIO_S_HEIGHT,
				'panoramio_s_orientation' => SZ_PLUGIN_GOOGLE_PANORAMIO_S_ORIENTATION,
				'panoramio_s_list_size'   => SZ_PLUGIN_GOOGLE_PANORAMIO_S_LIST_SIZE,
				'panoramio_s_position'    => SZ_PLUGIN_GOOGLE_PANORAMIO_S_POSITION,
				'panoramio_s_paragraph'   => SZ_PLUGIN_GOOGLE_PANORAMIO_S_PARAGRAPH,
				'panoramio_s_delay'       => SZ_PLUGIN_GOOGLE_PANORAMIO_S_DELAY,
				'panoramio_s_set'         => SZ_PLUGIN_GOOGLE_PANORAMIO_S_SET,
				'panoramio_s_columns'     => SZ_PLUGIN_GOOGLE_PANORAMIO_S_COLUMNS,
				'panoramio_s_rows'        => SZ_PLUGIN_GOOGLE_PANORAMIO_S_ROWS,
				'panoramio_w_template'    => SZ_PLUGIN_GOOGLE_PANORAMIO_W_TEMPLATE,
				'panoramio_w_width'       => SZ_PLUGIN_GOOGLE_PANORAMIO_W_WIDTH,
				'panoramio_w_height'      => SZ_PLUGIN_GOOGLE_PANORAMIO_W_HEIGHT,
				'panoramio_w_orientation' => SZ_PLUGIN_GOOGLE_PANORAMIO_W_ORIENTATION,
				'panoramio_w_list_size'   => SZ_PLUGIN_GOOGLE_PANORAMIO_W_LIST_SIZE,
				'panoramio_w_position'    => SZ_PLUGIN_GOOGLE_PANORAMIO_W_POSITION,
				'panoramio_w_paragraph'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'panoramio_w_delay'       => SZ_PLUGIN_GOOGLE_PANORAMIO_W_DELAY,
				'panoramio_w_set'         => SZ_PLUGIN_GOOGLE_PANORAMIO_W_SET,
				'panoramio_w_columns'     => SZ_PLUGIN_GOOGLE_PANORAMIO_W_COLUMNS,
				'panoramio_w_rows'        => SZ_PLUGIN_GOOGLE_PANORAMIO_W_ROWS,
			));

			// Controllo delle opzioni in caso di valori non conformi
			// richiamo della funzione per il controllo Yes o No

			$options = $this->checkOptionIsYesNo($options,array(
				'panoramio_widget'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'panoramio_shortcode'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'panoramio_s_paragraph' => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'panoramio_w_paragraph' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali della funzione di reperimento opzioni

			return $options;
		}

		/**
		 * Funzione per esecuzione shortcode legato a google panoramio,
		 * verrà richiamata la funzione comune di generazione codice HTML.
		 *
		 * @return string
		 */
		function getPanoramioShortcode($atts,$content=null)
		{
			return $this->getPanoramioCode(shortcode_atts(array(
				'template'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'user'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'group'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'tag'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'set'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'bgcolor'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'delay'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'columns'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'rows'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'orientation' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'listsize'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'paragraph'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'      => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Funzione per creazione codice HTML legato sia allo shortcode
		 * che al widget di google panoramio, il codice è comune.
		 *
		 * @return string
		 */
		function getPanoramioCode($atts=array(),$content=null)
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'template'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'user'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'group'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'tag'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'set'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'bgcolor'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'delay'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'columns'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'rows'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'orientation'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'listsize'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'paragraph'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Controllo le variabili che devono avere obbligatorio il valore 
			// di true o false, in caso diverso prendo il valore di default specificato 

			$user      = trim($user);
			$group     = trim($group);
			$tag       = trim($tag);
			$set       = strtolower(trim($set));
			$template  = strtolower(trim($template));
			$width     = strtolower(trim($width));
			$height    = strtolower(trim($height));
			$bgcolor   = strtolower(trim($bgcolor));
			$delay     = strtolower(trim($delay));
			$columns   = strtolower(trim($columns));
			$rows      = strtolower(trim($rows));
			$listsize  = strtolower(trim($listsize));
			$position  = strtolower(trim($position));
			$paragraph = strtolower(trim($paragraph));
			$action    = strtolower(trim($action));

			// Lettura delle opzioni per la definzione di parametri che non hanno
			// specificato nessun valore e che saranno sostituiti con quelli di default

			$options = $this->getOptions();

			if ($action == SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
			{
				$DEFAULT_TEMPLATE    = $options['panoramio_w_template'];
				$DEFAULT_WIDTH       = $options['panoramio_w_width'];
				$DEFAULT_HEIGHT      = $options['panoramio_w_height'];
				$DEFAULT_LIST_SIZE   = $options['panoramio_w_list_size'];
				$DEFAULT_POSITION    = $options['panoramio_w_position'];
				$DEFAULT_ORIENTATION = $options['panoramio_w_orientation'];
				$DEFAULT_PARAGRAPH   = $options['panoramio_w_paragraph'];
				$DEFAULT_DELAY       = $options['panoramio_w_delay'];
				$DEFAULT_SET         = $options['panoramio_w_set'];
				$DEFAULT_COLUMNS     = $options['panoramio_w_columns'];
				$DEFAULT_ROWS        = $options['panoramio_w_rows'];

			} else {

				$DEFAULT_TEMPLATE    = $options['panoramio_s_template'];
				$DEFAULT_WIDTH       = $options['panoramio_s_width'];
				$DEFAULT_HEIGHT      = $options['panoramio_s_height'];
				$DEFAULT_LIST_SIZE   = $options['panoramio_s_list_size'];
				$DEFAULT_POSITION    = $options['panoramio_s_position'];
				$DEFAULT_ORIENTATION = $options['panoramio_s_orientation'];
				$DEFAULT_PARAGRAPH   = $options['panoramio_s_paragraph'];
				$DEFAULT_DELAY       = $options['panoramio_s_delay'];
				$DEFAULT_SET         = $options['panoramio_s_set'];
				$DEFAULT_COLUMNS     = $options['panoramio_s_columns'];
				$DEFAULT_ROWS        = $options['panoramio_s_rows'];
			}

			// Controllo la variabile che controlla il paragrafo vuoto da aggiungere
			// dopo il blocco di codice (shortocde) per compatibilità al post di wordpress

			if ($paragraph == 'true')  $paragraph = SZ_PLUGIN_GOOGLE_VALUE_YES;
			if ($paragraph == 'false') $paragraph = SZ_PLUGIN_GOOGLE_VALUE_NO;

			if (!in_array($paragraph,array(SZ_PLUGIN_GOOGLE_VALUE_YES,SZ_PLUGIN_GOOGLE_VALUE_NO))) $paragraph = $DEFAULT_PARAGRAPH;

			// Controllo la coerenza delle opzioni di elaborazione modulo e 
			// sostituzione con valori di default quando presentano dei problemi

			if (!in_array($template   ,array('photo','slideshow','list','photo_list'))) $template    = $DEFAULT_TEMPLATE;
			if (!in_array($set        ,array('all','public','recent')))                 $set         = $DEFAULT_SET;
			if (!in_array($orientation,array('horizontal','vertical')))                 $orientation = $DEFAULT_ORIENTATION;
			if (!in_array($position   ,array('left','top','right','bottom')))           $position    = $DEFAULT_POSITION;

 			if (!ctype_xdigit(str_replace("#","",$bgcolor))) $bgcolor = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			if (!is_numeric($delay) or $delay < 0) $delay = $DEFAULT_DELAY; 

			if (!ctype_digit($columns))  $columns  = $DEFAULT_COLUMNS; 
			if (!ctype_digit($rows))     $rows     = $DEFAULT_ROWS;
			if (!ctype_digit($listsize)) $listsize = $DEFAULT_LIST_SIZE; 

			// Controllo i valori passati in array che specificano la dimensione del widget
			// in caso contrario imposto il valore su quello specificato nelle opzioni

			if (!is_numeric($width)  and $width  != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width  = $DEFAULT_WIDTH;
			if (!is_numeric($height) and $height != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = $DEFAULT_HEIGHT;

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width  = "'+w+'";
			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width  = "'+w+'";

			if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = $DEFAULT_HEIGHT;
			if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = $DEFAULT_HEIGHT;

			// Creazione identificativo univoco per riconoscere il codice embed 
			// nel caso la funzioine venga richiamata più volte nella stessa pagina

			$unique = md5(uniqid(),false);
			$keyIDs = 'sz-google-panoramio-'.$unique;

			// Creazione codice HTML per inserimento javascript di google 

			$HTML  = '<div class="sz-google-panoramio">';
			$HTML .= '<div class="sz-google-panoramio-wrap">';
			$HTML .= '<div class="sz-google-panoramio-iframe" id="'.$keyIDs.'">';

			$HTML .= '<script type="text/javascript">';
			$HTML .= "var w=document.getElementById('".$keyIDs."').offsetWidth;";
			$HTML .= "var h='<'+'";

			$HTML .= 'iframe src="https://ssl.panoramio.com/wapi/template/'.$template.'.html?';
			$HTML .= 'width='       .$width;
			$HTML .= '&height='     .$height;
			$HTML .= '&bgcolor='    .rawurlencode($bgcolor);
			$HTML .= '&delay='      .rawurlencode($delay);
			$HTML .= '&columns='    .rawurlencode($columns);
			$HTML .= '&rows='       .rawurlencode($rows);
			$HTML .= '&orientation='.rawurlencode($orientation);
			$HTML .= '&list_size='  .rawurlencode($listsize);
			$HTML .= '&position='   .rawurlencode($position);

			if ($user  != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&user=' .rawurlencode($user);
			if ($group != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&group='.rawurlencode($group);
			if ($tag   != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&tag='  .rawurlencode($tag);

			if ($user  == SZ_PLUGIN_GOOGLE_VALUE_NULL and $group == SZ_PLUGIN_GOOGLE_VALUE_NULL and $tag == SZ_PLUGIN_GOOGLE_VALUE_NULL) {
				if ($set != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&set='.rawurlencode($set);
			}

			$HTML .= '" ';
			$HTML .= 'scrolling="no" frameborder="0" marginwidth="0" marginheight="0" ';
 			$HTML .= 'width="'.$width.'" ';
			$HTML .= 'height="'.$height.'"';
			$HTML .= "></'+'iframe'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';

			$HTML .= '</div>';
			$HTML .= '</div>';
			$HTML .= '</div>';

			if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET and $paragraph == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				$HTML .= '<p></p>';
			}

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */
	if (!function_exists('szgoogle_panoramio_get_object')) {
		function szgoogle_panoramio_get_object() { 
			if (!is_a(SZGoogleModule::$SZGoogleModulePanoramio,'SZGoogleModulePanoramio')) return false;
				else return SZGoogleModule::$SZGoogleModulePanoramio;
		}
	}

	if (!function_exists('szgoogle_panoramio_get_code')) {
		function szgoogle_panoramio_get_code($options=array()) {
			if (!$object = szgoogle_panoramio_get_object()) return false;
				else return $object->getPanoramioCode($options);
		}
	}
}