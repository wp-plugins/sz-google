<?php
/**
 * Modulo GOOGLE HANGOUTS per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleModuleHangouts'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleHangouts extends SZGoogleModule
	{
		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			// Assegnazione variabile con nome classe per attivare il flag del modulo
			// nella classe di riferimento e sapere quali moduli risultano attivi

			parent::__construct('SZGoogleModuleHangouts');

			// Definizione degli shortcode collegati al modulo con un array in cui bisogna
			// specificare l'opzione di attivazione il nome dello shortcode e la funzione da eseguire

			$this->moduleShortcodes = array(
				'hangouts_start_shortcode' => array('sz-hangouts-start',array($this,'getHangoutsStartShortcode'))
			);

			$this->moduleWidgets = array(
				'hangouts_start_widget'    => 'SZGoogleWidgetHangoutsStart',
			);

			// Esecuzione dei componenti esistenti legati al modulo come
			// le azioni generali e la generazione di shortcode e widget.

			$this->moduleAddActions();
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
			$options = get_option('sz_google_options_hangouts');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'hangouts_start_widget'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'hangouts_start_shortcode' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Chiamata alla funzione comune per controllare le variabili che devono avere
			// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

			$options = $this->checkOptionIsYesNo($options,array(
				'hangouts_start_widget'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'hangouts_start_shortcode' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali della funzione di reperimento opzioni

			return $options;
		}

		/**
		 * Aggiungo le azioni del modulo corrente, questa funzione deve
		 * essere implementate per ogni modulo in maniera personalizzata
		 * non è possibile creare una funzione di standardizzazione
		 *
		 * @return void
		 */
		function moduleAddActions()
		{
			$options = $this->getOptions();
		}

		/**
		 * Aggiungo il modulo generale con lo shortcode e il widget per
		 * eseguire la funzione di start button hangout su google+
		 * Questa funzione definisce il codice HTML che deve essere generato.
		 *
		 * @return string
		 */
		function getHangoutsStartCode($atts=array(),$content=null)
		{
			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'type'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'topic'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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

			if (!in_array($type,array('normal','onair','party','moderate')))   $type     = SZ_PLUGIN_GOOGLE_HANGOUTS_TYPE;
			if (!in_array($float,array('none','left','right')))                $float    = SZ_PLUGIN_GOOGLE_VALUE_BUTTON_FLOAT;
			if (!in_array($align,array('none','left','right','center')))       $align    = SZ_PLUGIN_GOOGLE_VALUE_BUTTON_ALIGN;
			if (!in_array($position,array('top','center','bottom','outside'))) $position = SZ_PLUGIN_GOOGLE_VALUE_BUTTON_POSITION;

			if ($class == SZ_PLUGIN_GOOGLE_VALUE_NULL) $class = SZ_PLUGIN_GOOGLE_HANGOUTS_BUTTON_CLASS;
			if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

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

			if ($topic != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= ' data-topic="'.$topic.'"';

			$HTML .= "></'+'div'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';

			// Creazione codice HTML con funzione di wrapping comune a tutti i bottoni in maniera
			// da essere utilizzati anche come dei piccoli badge con immagine e posizionamento

			$HTML = SZGooglePluginCommon::getCodeButtonWrap(array(
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

			add_action('SZGoogleFooter',array($this,'setJavascriptPlatform'));

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per shortcode [sz-hangouts-start] che permette di
		 * eseguire il start button hangout su google+
		 *
		 * @return string
		 */
		function getHangoutsStartShortcode($atts,$content=null) 
		{
			return $this->getHangoutsStartCode(shortcode_atts(array(
				'type'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_HANGOUTS_BUTTON_SIZE_SHORTCODE,
				'topic'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}
	}
}
