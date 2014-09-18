<?php
/**
 * Classe per la definizione di uno widget che viene
 * richiamato dalla classe del modulo principale
 *
 * @package SZGoogle
 * @subpackage SZGoogleWidget 
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleWidgetYoutubeVideo'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleWidget
	 */
	class SZGoogleWidgetYoutubeVideo extends SZGoogleWidget
	{
		/**
		 * Costruttore principale della classe widget, definizione
		 * delle opzioni legate al widget e al controllo dello stesso
		 */
		function __construct() 
		{
			parent::__construct('SZ-Google-Youtube-Video',__('SZ-Google - Youtube video','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-youtube sz-widget-google-youtube-video', 
				'description' => ucfirst(__('youtube video.','szgoogleadmin'))
			));
		}

		/**
		 * Generazione del codice HTML del widget per la 
		 * visualizzazione completa nella sidebar di appartenenza
		 */
		function widget($args,$instance) 
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'title'           => '', // valore predefinito
				'url'             => '', // valore predefinito
				'responsive'      => '', // valore predefinito
				'width'           => '', // valore predefinito
				'height'          => '', // valore predefinito
				'margintop'       => '', // valore predefinito
				'marginright'     => '', // valore predefinito
				'marginbottom'    => '', // valore predefinito
				'marginleft'      => '', // valore predefinito
				'marginunit'      => '', // valore predefinito
				'analytics'       => '', // valore predefinito
				'delayed'         => '', // valore predefinito
				'autoplay'        => '', // valore predefinito
				'loop'            => '', // valore predefinito
				'fullscreen'      => '', // valore predefinito
				'schemaorg'       => '', // valore predefinito
				'disableiframe'   => '', // valore predefinito
				'disablekeyboard' => '', // valore predefinito
				'disablerelated'  => '', // valore predefinito
				'name'            => '', // valore predefinito
				'description'     => '', // valore predefinito
				'duration'        => '', // valore predefinito
				'start'           => '', // valore predefinito
				'end'             => '', // valore predefinito
				'theme'           => '', // valore predefinito
				'cover'           => '', // valore predefinito
			),$instance);

			// Azzeramento variabile title per non confonderla con il title che deve
			// essere usato a livello di shortcode e non nei widgets

			$options['title'] = '';

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			$OBJC = new SZGoogleActionYoutubeVideo();
			$HTML = $OBJC->getHTMLCode($options);

			// Output del codice HTML legato al widget da visualizzare
			// chiamata alla funzione generale per wrap standard

			echo $this->common_widget($args,$instance,$HTML);
		}

		/**
		 * Modifica parametri collegati al FORM del widget con la
		 * memorizzazione dei valori direttamente nel database wordpress
		 */
		function update($new_instance,$old_instance) 
		{
			// Esecuzione operazioni aggiuntive sui campi presenti
			// nel form widget prima della memorizzazione database

			return $this->common_update(array(
				'title'           => '0', // esecuzione strip_tags
				'url'             => '1', // esecuzione strip_tags
				'responsive'      => '1', // esecuzione strip_tags
				'width'           => '1', // esecuzione strip_tags
				'height'          => '1', // esecuzione strip_tags
				'delayed'         => '1', // esecuzione strip_tags
				'autoplay'        => '1', // esecuzione strip_tags
				'loop'            => '1', // esecuzione strip_tags
				'fullscreen'      => '1', // esecuzione strip_tags
				'schemaorg'       => '1', // esecuzione strip_tags
				'disableiframe'   => '1', // esecuzione strip_tags
				'disablekeyboard' => '1', // esecuzione strip_tags
				'disablerelated'  => '1', // esecuzione strip_tags
				'start'           => '1', // esecuzione strip_tags
				'end'             => '1', // esecuzione strip_tags
				'theme'           => '1', // esecuzione strip_tags
				'cover'           => '1', // esecuzione strip_tags
			),$new_instance,$old_instance);
		}

		/**
		 * Visualizzazione FORM del widget presente nella gestione 
		 * delle sidebar nel pannello di amministrazione di wordpress
		 */
		function form($instance) 
		{
			// Creazione array per elenco campi che devono essere 
			// presenti nel form prima di richiamare wp_parse_args()

			$array = array(
				'title'           => '', // valore predefinito
				'url'             => '', // valore predefinito
				'responsive'      => '', // valore predefinito
				'width'           => '', // valore predefinito
				'height'          => '', // valore predefinito
				'delayed'         => '', // valore predefinito
				'autoplay'        => '', // valore predefinito
				'loop'            => '', // valore predefinito
				'fullscreen'      => '', // valore predefinito
				'schemaorg'       => '', // valore predefinito
				'disableiframe'   => '', // valore predefinito
				'disablekeyboard' => '', // valore predefinito
				'disablerelated'  => '', // valore predefinito
				'start'           => '', // valore predefinito
				'end'             => '', // valore predefinito
				'theme'           => '', // valore predefinito
				'cover'           => '', // valore predefinito
			);

			// Creazione array per elenco campi da recuperare su FORM e
			// caricamento del file con il template HTML da visualizzare

			extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

			// Lettura delle opzioni per il controllo dei valori di default
			// da assegnare al widget nel momento che viene inserito in sidebar

			if ($object = SZGoogleModule::getObject('SZGoogleModuleYoutube')) 
			{
				$options = (object) $object->getOptions();

				if (!in_array($theme,array('light','dark')))    $theme = $options->youtube_theme;
				if (!in_array($cover,array('local','youtube'))) $cover = $options->youtube_cover;

				if (!in_array($responsive     ,array('n','y'))) $responsive      = $options->youtube_responsive;
				if (!in_array($delayed        ,array('n','y'))) $delayed         = $options->youtube_delayed;
				if (!in_array($autoplay       ,array('n','y'))) $autoplay        = $options->youtube_autoplay;
				if (!in_array($loop           ,array('n','y'))) $loop            = $options->youtube_loop;
				if (!in_array($fullscreen     ,array('n','y'))) $fullscreen      = $options->youtube_fullscreen;
				if (!in_array($schemaorg      ,array('n','y'))) $schemaorg       = $options->youtube_schemaorg;
				if (!in_array($disableiframe  ,array('n','y'))) $disableiframe   = $options->youtube_disableiframe;
				if (!in_array($disablekeyboard,array('n','y'))) $disablekeyboard = $options->youtube_disablekeyboard;
				if (!in_array($disablerelated ,array('n','y'))) $disablerelated  = $options->youtube_disablerelated;

				if (!ctype_digit($width)  and $width  != 'auto') $width  = $options->youtube_width;
				if (!ctype_digit($height) and $height != 'auto') $height = $options->youtube_height;
			}

			// Impostazione eventuale di parametri di default per i
			// campi che contengono dei valori non validi o non coerenti 

			$DEFAULT = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/sz_google_options_youtube.php");

			if (!in_array($theme,array('light','dark')))    $theme = 'dark';
			if (!in_array($cover,array('local','youtube'))) $cover = 'local';

			if (!in_array($responsive     ,array('0','1','n','y'))) $responsive      = $DEFAULT['youtube_responsive']['value'];
			if (!in_array($delayed        ,array('0','1','n','y'))) $delayed         = $DEFAULT['youtube_delayed']['value'];
			if (!in_array($autoplay       ,array('0','1','n','y'))) $autoplay        = $DEFAULT['youtube_autoplay']['value'];
			if (!in_array($loop           ,array('0','1','n','y'))) $loop            = $DEFAULT['youtube_loop']['value'];
			if (!in_array($fullscreen     ,array('0','1','n','y'))) $fullscreen      = $DEFAULT['youtube_fullscreen']['value'];
			if (!in_array($schemaorg      ,array('0','1','n','y'))) $schemaorg       = $DEFAULT['youtube_schemaorg']['value'];
			if (!in_array($disableiframe  ,array('0','1','n','y'))) $disableiframe   = $DEFAULT['youtube_disableiframe']['value'];
			if (!in_array($disablekeyboard,array('0','1','n','y'))) $disablekeyboard = $DEFAULT['youtube_disablekeyboard']['value'];
			if (!in_array($disablerelated ,array('0','1','n','y'))) $disablerelated  = $DEFAULT['youtube_disablerelated']['value'];

			if (!ctype_digit($width)  or $width  == 0) { $width  = $DEFAULT['youtube_width']['value'];  $width_auto  = '1'; }
			if (!ctype_digit($height) or $height == 0) { $height = $DEFAULT['youtube_height']['value']; $height_auto = '1'; }

			// Purtroppo i valori di youtube sono stati impostati diversamente 
			// dai valori delle opzioni di configurazione quindi facciamo un replace

			$responsive      = str_replace(array('0','1'),array('n','y'),$responsive);
			$delayed         = str_replace(array('0','1'),array('n','y'),$delayed);
			$autoplay        = str_replace(array('0','1'),array('n','y'),$autoplay);
			$loop            = str_replace(array('0','1'),array('n','y'),$loop);
			$fullscreen      = str_replace(array('0','1'),array('n','y'),$fullscreen);
			$schemaorg       = str_replace(array('0','1'),array('n','y'),$schemaorg);
			$disableiframe   = str_replace(array('0','1'),array('n','y'),$disableiframe);
			$disablekeyboard = str_replace(array('0','1'),array('n','y'),$disablekeyboard);
			$disablerelated  = str_replace(array('0','1'),array('n','y'),$disablerelated);

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidget.php');
			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/' .__CLASS__.'.php');
		}
	}
}