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

			if (SZ_PLUGIN_GOOGLE_DEBUG) SZGoogleDebug::log('execute exec-mods point add actions for hangouts');
		}

		/**
		 * Aggiungo il modulo generale con lo shortcode e il widget per
		 * eseguire la funzione di start button hangout su google+
		 * Questa funzione definisce il codice HTML che deve essere generato.
		 *
		 * @return void
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
			$HTML .= "document.write('";
			$HTML .= '<div class="g-hangout" data-render="createhangout"';
			$HTML .= ' data-hangout_type="'.$type .'"';
			$HTML .= ' data-widget_size="' .$width.'"';

			if ($topic != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= ' data-topic="'.$topic.'"';

			$HTML .= '></div>'."');";
			$HTML .= '</script>';

			// Creazione codice HTML con funzione di wrapping comune a tutti i bottoni in maniera
			// da essere utilizzati anche come dei piccoli badge con immagine e posizionamento

			$HTML = SZGoogleCommon::getCodeButtonWrap(array(
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
		 * @return void
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

	/**
	 * Creazione oggetto principale per creazione ed elaborazione del
	 * modulo richiesto con azioni iniziali specificate nel costruttore
	 */
	$SZ_GOOGLE_MODULE_HANGOUTS = new SZGoogleModuleHangouts();
}

/**
 * Creazione WIDGET per il bottone di partenza hangout.
 * Creazione della classe con riferimento a quella generica.
 */
if (!class_exists('SZGoogleWidgetHangoutsStart'))
{
	class SZGoogleWidgetHangoutsStart extends SZGoogleWidget
	{
		/**
		 * Costruttore principale della classe widget, definizione
		 * delle opzioni legate al widget e al controllo dello stesso
		 */
		function __construct() 
		{
			parent::__construct('SZ-GOOGLE-HANGOUTS-START',__('SZ-Google - Hangouts button','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-hangouts sz-widget-google-hangouts-start', 
				'description' => ucfirst(__('button for starting Hangout.','szgoogleadmin'))
			));
		}

		/**
		 * Funzione per la generazione del codice del widget come
		 * visualizzazione completa nella sidebar di appartenenza
		 */
		function widget($args,$instance) 
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
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
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'badge'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width_auto'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$instance);

			// Se sul widget ho escluso il badge dal pulsante azzero anche
			// le variabili del badge eventualmente impostate e memorizzate 

			if ($controls['badge'] != SZ_PLUGIN_GOOGLE_VALUE_YES) 
			{
				$options['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
				$options['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
				$options['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			}

			// Correzione del valore di dimensione nel caso venga
			// specificata la maniera automatica e quindi usare javascript

			if ($controls['width_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			if ($object = SZGoogleModule::$SZGoogleModuleHangouts) {
				$HTML = $object->getHangoutsStartCode($options);
			}

			// Output del codice HTML legato al widget da visualizzare
			// chiamata alla funzione generale per wrap standard

			echo $this->common_widget($args,$instance,$HTML);
		}

		// Funzione per modifica parametri collegati al widget con 
		// memorizzazione dei valori direttamente nel database wordpress

		function update($new_instance,$old_instance) 
		{
			return $this->common_update(array(
				'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'type'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'topic'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'badge'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'text'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'img'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'position'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			),$new_instance,$old_instance);
		}

		// Funzione per la visualizzazione del form presente sulle 
		// sidebar nel pannello di amministrazione di wordpress
	
		function form($instance) 
		{
			$array = array(
				'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'type'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'topic'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'badge'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'      => SZ_PLUGIN_GOOGLE_HANGOUTS_BUTTON_SIZE_WIDGET,
				'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			);

			// Creazione array per elenco campi da recuperare su FORM e
			// caricamento del file con il template HTML da visualizzare

			$instance = wp_parse_args((array) $instance,$array);

			$text       = trim($instance['text']);
			$img        = trim($instance['img']);

			$topic      = trim(strip_tags($instance['topic']));
			$type       = trim(strip_tags($instance['type']));
			$badge      = trim(strip_tags($instance['badge']));
			$title      = trim(strip_tags($instance['title']));
			$align      = trim(strip_tags($instance['align']));
			$position   = trim(strip_tags($instance['position']));
			$width      = trim(strip_tags($instance['width']));
			$width_auto = trim(strip_tags($instance['width_auto']));

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.'sz-google-widget-hangouts-start.php');
		}
	}
}
