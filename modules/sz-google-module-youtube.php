<?php
/**
 * Modulo YOUTUBE per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Definizione della classe principale da utilizzare per questo
 * modulo. La classe deve essere una extends di SZGoogleModule
 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
 */
class SZGoogleModuleYoutube extends SZGoogleModule
{
	function __construct()
	{
		parent::__construct('SZGoogleModuleYoutube');

		$this->moduleShortcodes = array(
			'youtube_shortcode'          => array('sz-ytvideo'   ,'sz_google_shortcodes_youtube_video'),
			'youtube_shortcode_badge'    => array('sz-ytbadge'   ,'sz_google_shortcodes_youtube_badge'),
			'youtube_shortcode_button'   => array('sz-ytbutton'  ,'sz_google_shortcodes_youtube_button'),
			'youtube_shortcode_link'     => array('sz-ytlink'    ,'sz_google_shortcodes_youtube_link'),
			'youtube_shortcode_playlist' => array('sz-ytplaylist','sz_google_shortcodes_youtube_playlist'),
		);

		$this->moduleWidgets = array(
			'youtube_widget'             => 'sz_google_module_youtube_widget_video',
			'youtube_widget_playlist'    => 'sz_google_module_youtube_widget_playlist',
		);
	}

	/**
	 * Calcolo le opzioni legate al modulo con esecuzione dei 
	 * controlli formali di coerenza e impostazione dei default
	 *
	 * @return array
	 */
	function getOptions()
	{
		$options = get_option('sz_google_options_youtube');

		// Controllo delle opzioni in caso di valori non esistenti
		// richiamo della funzione per il controllo isset()

		$options = $this->checkOptionIsSet($options,array(
			'youtube_channel'            => SZ_PLUGIN_GOOGLE_YOUTUBE_CHANNEL,
			'youtube_widget'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_widget_badge'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_widget_playlist'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode_badge'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode_button'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode_link'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode_playlist' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_responsive'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_width'              => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH,
			'youtube_height'             => SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT,
			'youtube_margin_top'         => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO,
			'youtube_margin_right'       => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO,
			'youtube_margin_bottom'      => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO,
			'youtube_margin_left'        => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO,
			'youtube_margin_unit'        => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT,
			'youtube_force_ssl'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_autoplay'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_loop'               => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_fullscreen'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'youtube_disablekeyboard'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_theme'              => SZ_PLUGIN_GOOGLE_YOUTUBE_THEME,
			'youtube_cover'              => SZ_PLUGIN_GOOGLE_YOUTUBE_COVER,
			'youtube_disableiframe'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_analytics'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_delayed'            => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_schemaorg'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_disablerelated'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		));

		// Controllo delle opzioni in caso di valori non conformi
		// richiamo della funzione per il controllo isnull()

		$options = $this->checkOptionIsNull($options,array(
			'youtube_channel'            => SZ_PLUGIN_GOOGLE_YOUTUBE_CHANNEL,
			'youtube_width'              => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH,
			'youtube_height'             => SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT,
			'youtube_margin_top'         => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO,
			'youtube_margin_right'       => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO,
			'youtube_margin_bottom'      => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO,
			'youtube_margin_left'        => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO,
			'youtube_margin_unit'        => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT,
			'youtube_force_ssl'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_autoplay'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_loop'               => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_fullscreen'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'youtube_disablekeyboard'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_theme'              => SZ_PLUGIN_GOOGLE_YOUTUBE_THEME,
			'youtube_cover'              => SZ_PLUGIN_GOOGLE_YOUTUBE_COVER,
			'youtube_disableiframe'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_analytics'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_delayed'            => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_schemaorg'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_disablerelated'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		));

		// Chiamata alla funzione comune per controllare le variabili che devono avere
		// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

		$options = $this->checkOptionIsYesNo($options,array(
			'youtube_widget'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_widget_badge'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_widget_playlist'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode_badge'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode_button'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode_link'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_shortcode_playlist' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_responsive'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_force_ssl'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_autoplay'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_loop'               => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_fullscreen'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'youtube_disablekeyboard'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_disableiframe'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_analytics'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_delayed'            => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_schemaorg'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'youtube_disablerelated'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		));

		// Ritorno indietro il gruppo di opzioni corretto dai
		// controlli formali della funzione di reperimento opzioni
	
		return $options;
	}
}

global $SZ_YOUTUBE_OBJECT;

$SZ_YOUTUBE_OBJECT = new SZGoogleModuleYoutube();
$SZ_YOUTUBE_OBJECT->moduleAddWidgets();
$SZ_YOUTUBE_OBJECT->moduleAddShortcodes();

/* ************************************************************************** */
/* YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUT */
/* YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUT */
/* YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUT */
/* YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUT */
/* YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUTUBE VIDEO YOUT */
/* ************************************************************************** */

global $SZ_GOOGLE_YOUTUBE; 
global $SZ_GOOGLE_YOUTUBE_API; 

$SZ_GOOGLE_YOUTUBE = true;
$SZ_GOOGLE_YOUTUBE_API = array();


function sz_google_module_youtube_get_code_video($atts=array())
{
	global $SZ_YOUTUBE_OBJECT;
	$options = $SZ_YOUTUBE_OBJECT->getOptions();

	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'url'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'responsive'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'autoplay'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'loop'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'fullscreen'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'disablekeyboard' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'theme'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'cover'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'disableiframe'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'analytics'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'delayed'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'start'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'end'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'schemaorg'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'name'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'description'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'duration'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'disablerelated'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$url             = trim($url);
	$title           = trim($title);
	$cover           = trim($cover);
	$name            = trim($name);
	$description     = trim($description);
	$duration        = trim($duration);

	$responsive      = strtolower(trim($responsive));
	$margintop       = strtolower(trim($margintop));
	$marginright     = strtolower(trim($marginright));
	$marginbottom    = strtolower(trim($marginbottom));
	$marginleft      = strtolower(trim($marginleft));
	$marginunit      = strtolower(trim($marginunit));
	$autoplay        = strtolower(trim($autoplay));
	$loop            = strtolower(trim($loop));
	$fullscreen      = strtolower(trim($fullscreen));
	$disablekeyboard = strtolower(trim($disablekeyboard));
	$theme           = strtolower(trim($theme));
	$disableiframe   = strtolower(trim($disableiframe));
	$analytics       = strtolower(trim($analytics));
	$delayed         = strtolower(trim($delayed));
	$start           = strtolower(trim($start));
	$end             = strtolower(trim($end));
	$schemaorg       = strtolower(trim($schemaorg));
	$disablerelated  = strtolower(trim($disablerelated));

	// Controllo le caratteristiche del link per creare URL del
	// sorgente iframe da utilizzare nel codice embed e cambio schema se necessario

	$frame = false; 
	$vidID = false; 
	$links = html_entity_decode($url); 
	$datas = parse_url($links);

	// Controllo se il parsing URL contiene elementi necessari
	// Controllo se il link riporta uno schema conosciuto

	if (isset($datas['scheme']) and isset($datas['host'])) 
	{
		if ($datas['scheme'] == 'http' or $datas['scheme'] == 'https') 
		{
			// Se host contiene il nome classico allora il codice del video si trova
			// su variabile (v) specificata su stringa URL e quindi eseguo il parsing

			if ($datas['host'] == 'www.youtube.com') {
				parse_str(parse_url($links,PHP_URL_QUERY),$argom);
				if (isset($argom['v'])) $vidID = trim($argom['v']);  
			}

			// Se host è con codice short prendo le 11 cifre significative che
			// contengono il codice univoco del video youtube

			if ($datas['host'] == 'youtu.be') {
				if (strlen($paths)>=11) $vidID = substr($paths,1,11); 
			}

			// Se ho indicato di usare sempre https forzo il protocollo URL
			// anche se su stringa originale viene specificato un valore diverso

			if ($options['youtube_force_ssl'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				$datas['scheme'] = 'https'; 
			}

		}
	}

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if ($responsive      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $responsive      = $options['youtube_responsive'];
	if ($width           == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width           = $options['youtube_width'];
	if ($height          == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height          = $options['youtube_height'];
	if ($margintop       == SZ_PLUGIN_GOOGLE_VALUE_NULL) $margintop       = $options['youtube_margin_top'];
	if ($marginright     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $marginright     = $options['youtube_margin_right'];
	if ($marginbottom    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $marginbottom    = $options['youtube_margin_bottom'];
	if ($marginleft      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $marginleft      = $options['youtube_margin_left'];
	if ($marginunit      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $marginunit      = $options['youtube_margin_unit'];
	if ($autoplay        == SZ_PLUGIN_GOOGLE_VALUE_NULL) $autoplay        = $options['youtube_autoplay'];
	if ($loop            == SZ_PLUGIN_GOOGLE_VALUE_NULL) $loop            = $options['youtube_loop'];
	if ($fullscreen      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $fullscreen      = $options['youtube_fullscreen'];
	if ($disablekeyboard == SZ_PLUGIN_GOOGLE_VALUE_NULL) $disablekeyboard = $options['youtube_disablekeyboard'];
	if ($theme           == SZ_PLUGIN_GOOGLE_VALUE_NULL) $theme           = $options['youtube_theme'];
	if ($cover           == SZ_PLUGIN_GOOGLE_VALUE_NULL) $cover           = $options['youtube_cover'];
	if ($disableiframe   == SZ_PLUGIN_GOOGLE_VALUE_NULL) $disableiframe   = $options['youtube_disableiframe'];
	if ($analytics       == SZ_PLUGIN_GOOGLE_VALUE_NULL) $analytics       = $options['youtube_analytics'];
	if ($delayed         == SZ_PLUGIN_GOOGLE_VALUE_NULL) $delayed         = $options['youtube_delayed'];
	if ($schemaorg       == SZ_PLUGIN_GOOGLE_VALUE_NULL) $schemaorg       = $options['youtube_schemaorg'];
	if ($disablerelated  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $disablerelated  = $options['youtube_disablerelated'];

	// Conversione dei valori specificati direttamete nei parametri con
	// i valori usati per la memorizzazione dei valori di default

	if ($responsive      == 'yes' or $responsive      == 'y') $responsive      = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($autoplay        == 'yes' or $autoplay        == 'y') $autoplay        = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($loop            == 'yes' or $loop            == 'y') $loop            = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($fullscreen      == 'yes' or $fullscreen      == 'y') $fullscreen      = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($disablekeyboard == 'yes' or $disablekeyboard == 'y') $disablekeyboard = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($disableiframe   == 'yes' or $disableiframe   == 'y') $disableiframe   = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($analytics       == 'yes' or $analytics       == 'y') $analytics       = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($delayed         == 'yes' or $delayed         == 'y') $delayed         = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($schemaorg       == 'yes' or $schemaorg       == 'y') $schemaorg       = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($disablerelated  == 'yes' or $disablerelated  == 'y') $disablerelated  = SZ_PLUGIN_GOOGLE_VALUE_YES; 

	if ($responsive      == 'no'  or $responsive      == 'n') $responsive      = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($autoplay        == 'no'  or $autoplay        == 'n') $autoplay        = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($loop            == 'no'  or $loop            == 'n') $loop            = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($fullscreen      == 'no'  or $fullscreen      == 'n') $fullscreen      = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($disablekeyboard == 'no'  or $disablekeyboard == 'n') $disablekeyboard = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($disableiframe   == 'no'  or $disableiframe   == 'n') $disableiframe   = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($analytics       == 'no'  or $analytics       == 'n') $analytics       = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($delayed         == 'no'  or $delayed         == 'n') $delayed         = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($schemaorg       == 'no'  or $schemaorg       == 'n') $schemaorg       = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($disablerelated  == 'no'  or $disablerelated  == 'n') $disablerelated  = SZ_PLUGIN_GOOGLE_VALUE_NO; 

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	$YESNO = array(SZ_PLUGIN_GOOGLE_VALUE_YES,SZ_PLUGIN_GOOGLE_VALUE_NO);

	if (!in_array($responsive,$YESNO))      $responsive      = $options['youtube_responsive']; 
	if (!in_array($autoplay,$YESNO))        $autoplay        = $options['youtube_autoplay']; 
	if (!in_array($loop,$YESNO))            $loop            = $options['youtube_loop']; 
	if (!in_array($fullscreen,$YESNO))      $fullscreen      = $options['youtube_fullscreen']; 
	if (!in_array($disablekeyboard,$YESNO)) $disablekeyboard = $options['youtube_disablekeyboard']; 
	if (!in_array($disableiframe,$YESNO))   $disableiframe   = $options['youtube_disableiframe']; 
	if (!in_array($analytics,$YESNO))       $analytics       = $options['youtube_analytics']; 
	if (!in_array($delayed,$YESNO))         $delayed         = $options['youtube_delayed']; 
	if (!in_array($schemaorg,$YESNO))       $schemaorg       = $options['youtube_schemaorg'];
	if (!in_array($disablerelated,$YESNO))  $disablerelated  = $options['youtube_disablerelated'];

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if (!is_numeric($width))        $width        = $options['youtube_width'];
	if (!is_numeric($height))       $height       = $options['youtube_height'];
	if (!is_numeric($margintop))    $margintop    = $options['youtube_margin_top'];
	if (!is_numeric($marginbottom)) $marginbottom = $options['youtube_margin_bottom'];

	if (!is_numeric($width))        $width        = SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH;
	if (!is_numeric($height))       $height       = SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT;
	if (!is_numeric($margintop))    $margintop    = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;
	if (!is_numeric($marginbottom)) $marginbottom = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;

	if (!is_numeric($marginright) and strtolower(trim($marginright)) <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO) $marginright = $options['youtube_margin_right'];
	if (!is_numeric($marginleft)  and strtolower(trim($marginleft))  <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO) $marginleft  = $options['youtube_margin_left'];

	if (!is_numeric($marginright) and strtolower(trim($marginright)) <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO) $marginright = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_RIGHT;
	if (!is_numeric($marginleft)  and strtolower(trim($marginleft))  <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO) $marginleft  = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_LEFT;

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if (!in_array($marginunit,array('em','px')))    $marginunit = $options['youtube_margin_unit']; 
	if (!in_array($theme,array('dark','light')))    $theme      = $options['youtube_theme']; 

	if (!in_array($marginunit,array('em','px')))    $marginunit = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT; 
	if (!in_array($theme,array('dark','light')))    $theme      = SZ_PLUGIN_GOOGLE_YOUTUBE_THEME; 

	if (!ctype_digit($start)) $start = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!ctype_digit($end))   $end   = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Se ho impostato la modalità responsive la dimensione è sempre 100%
	// per occupare tutto lo spazio del contenitore genitore, stesso controllo per valore=0

	if ($responsive == SZ_PLUGIN_GOOGLE_VALUE_YES or $width == '0') $CSS = 'width:100%;';
		else $CSS = 'width:'.$width.'px;';

	if ($responsive == SZ_PLUGIN_GOOGLE_VALUE_YES) 
	{
		$marginright = '0';
		$marginleft  = '0';
	}

	if ($autoplay        == SZ_PLUGIN_GOOGLE_VALUE_YES) $AUTOPLAY        = '1'; else $AUTOPLAY        = '0';
	if ($loop            == SZ_PLUGIN_GOOGLE_VALUE_YES) $LOOP            = '1'; else $LOOP            = '0';
	if ($fullscreen      == SZ_PLUGIN_GOOGLE_VALUE_YES) $FULLSCREEN      = '1'; else $FULLSCREEN      = '0';
	if ($disablekeyboard == SZ_PLUGIN_GOOGLE_VALUE_YES) $DISABLEKEYBOARD = '1'; else $DISABLEKEYBOARD = '0';

	// Creazione variabile per il calcolo dei margini da applicare
	// se margini destra e sinistra sono uguali a zero diventano "auto" 

	if ($margintop == '0') $CSS .= 'margin-top:0;';
		else $CSS .= 'margin-top:'.trim($margintop).trim($marginunit).';';

	if (in_array($marginright,array('0','auto'))) $CSS .= 'margin-right:'.$marginright.';';
		else $CSS .= 'margin-right:'.trim($marginright).trim($marginunit).';';

	if ($marginbottom == '0') $CSS .= 'margin-bottom:0;';
		else $CSS .= 'margin-bottom:'.trim($marginbottom).trim($marginunit).';';

	if (in_array($marginleft,array('0','auto'))) $CSS .= 'margin-left:'.$marginleft.';';
		else $CSS .= 'margin-left:'.trim($marginleft).trim($marginunit).';';

	// Se non ho trovato nessun video ID durante l'analisi URL
	// preparo codice HTML per indicare errore di elaborazione funzione

	if ($vidID === false) 
	{
		$HTML  = '<div class="sz-youtube-main" style="'.$CSS.'">';
		$HTML .= '<div class="sz-youtube-warn" style="display:block;padding:1em 0;text-align:center;background-color:#e1e1e1;border:1px solid #b1b1b1;">';
		$HTML .= ucfirst(SZGoogleCommon::getTranslate('youtube URL string specified is not valid.'));
		$HTML .= '</div>';
		$HTML .= '</div>';

		return $HTML;
	}

	// Creazione identificativo univoco per riconoscere il codice embed 
	// nel caso la funzioine venga richiamata più volte nella stessa pagina

	$unique = md5(uniqid(),false);
	$keyID  = 'sz-youtube-'.$unique;

	// Creazione variabili per gestire le immagini di copertina e 
	// la modalità di caricamento codice embed ritardato

	$ONCLICK    = '';
	$CSSIMAGE_1 = 'display:block;';
	$CSSIMAGE_2 = 'display:block;';
	$COVERIMAGE = trim($cover);
	$COVERPLAYS = SZ_PLUGIN_GOOGLE_PATH_IMAGE.'youtube-play.png';

	if (ctype_digit($COVERIMAGE)) {
		$COVERSRC = wp_get_attachment_image_src($COVERIMAGE,'full');
		if (isset($COVERSRC[0])) $COVERIMAGE = $COVERSRC[0]; 
			else $COVERIMAGE = 'local'; 
	}

	if (strtolower($COVERIMAGE) == 'youtube') {
		$image = $datas['scheme'].'://img.youtube.com/vi/';
		$COVERIMAGE = $image.$vidID.'/hqdefault.jpg';
	} 

	if (strtolower($COVERIMAGE) == 'local') {
		$COVERIMAGE = SZ_PLUGIN_GOOGLE_PATH_IMAGE.'youtube-cover.jpg';
	} 

	// Creazione variabili per gestire le immagini di copertina e 
	// la modalità di caricamento codice embed ritardato

	if ($delayed == SZ_PLUGIN_GOOGLE_VALUE_YES) 
	{
		$CSSIMAGE_1 .= 'cursor:pointer;';
		$CSSIMAGE_1 .= 'background-color:#f1f1f1;';
		$CSSIMAGE_1 .= 'background-image:url('.$COVERIMAGE.');';
		$CSSIMAGE_1 .= "background-repeat:no-repeat;";
		$CSSIMAGE_1 .= "background-position:center center;";
		$CSSIMAGE_1 .= "background-size:100% 100%;";

		$CSSIMAGE_2 .= 'background-image:url('.$COVERPLAYS.');';
		$CSSIMAGE_2 .= "background-repeat:no-repeat;";
		$CSSIMAGE_2 .= "background-position:center center;";
		$CSSIMAGE_2 .= "background-size:20% auto";

		$ONCLICK     = ' onclick="javascript:onYouTubePlayerAPIReady_'.$unique.'();"';

		$AUTOPLAY = SZ_PLUGIN_GOOGLE_VALUE_YES; 
		$disableiframe = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	}

	// SE ATTIVATA FUNZIONE PER STATISTICHE ANALYTICS DEVO FORZARE 
	// ESECUZIONE DEL CODICE EMBED TRAMITE YOUTUBE API 

	if ($analytics == SZ_PLUGIN_GOOGLE_VALUE_YES) {
		$disableiframe = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	}

	// Creazione variabile da usare per lo schema.org in caso di attivazione
	// opzione, vengono usate le specifiche di http://schema.org/VideoObject 

	$EMBEDURL = $datas['scheme'].'://www.youtube.com/embed/'.$vidID.'?v='.$vidID;
	$THUMBNAILURL = $datas['scheme'].'://img.youtube.com/vi/'.$vidID.'/hqdefault.jpg';

	if ($name == SZ_PLUGIN_GOOGLE_VALUE_NULL) $NAME = esc_html(ucfirst(SZGoogleCommon::getTranslate('youtube video')));
		else $NAME = esc_html($name);	

	if ($description != SZ_PLUGIN_GOOGLE_VALUE_NULL) $DESCRIPTION = esc_html($description);
		else $DESCRIPTION = esc_html($title);	

	if ($disablerelated == SZ_PLUGIN_GOOGLE_VALUE_YES) $DISABLERELATED = '0';
		else $DISABLERELATED = '1';

	// Creazione codice HTML per inserimento nella pagina, la tecnica usata
	// può essere la definizione di un IFRAME e la chiamata ad una funzione API 

	$HTML = '';

	// Creazione codice HTML con controllo inserimento schema.org, se il sistema
	// è abilitato vengono usate le specifiche di http://schema.org/VideoObject 

	if ($schemaorg == SZ_PLUGIN_GOOGLE_VALUE_YES) 
	{
		$HTML .= '<div class="sz-youtube-main" style="'.$CSS.'" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">';

		if ($NAME        != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '<meta itemprop="name" content="'.$NAME.'">';
		if ($DESCRIPTION != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '<meta itemprop="description" content="'.$DESCRIPTION.'">';
		if ($duration    != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '<meta itemprop="duration" content="'.$duration.'">';

		$HTML .= '<meta itemprop="embedURL" content="'.$EMBEDURL.'">';
		$HTML .= '<meta itemprop="thumbnailUrl" content="'.$THUMBNAILURL.'">';

	} else {

		$HTML .= '<div class="sz-youtube-main" style="'.$CSS.'">';
	}

	// Creazione codice HTML per inserimento nella pagina, la tecnica usata
	// può essere la definizione di un IFRAME e la chiamata ad una funzione API 

	$HTML .= '<div class="sz-youtube-play" style="'.$CSSIMAGE_1.'"'.$ONCLICK.'>';

	if ($responsive == SZ_PLUGIN_GOOGLE_VALUE_YES)
	{
		$HTML .= '<div class="sz-youtube-cont" ';
		$HTML .= 'style="';
		$HTML .= 'position:relative;';
		$HTML .= 'padding-bottom:56.25%;';
		$HTML .= 'height:0;';
		$HTML .= 'overflow:hidden;';
		$HTML .= $CSSIMAGE_2;
		$HTML .= '">';

	} else {

		$HTML .= '<div class="sz-youtube-cont" ';
		$HTML .= 'style="';
		$HTML .= 'position:relative;';
		$HTML .= 'height:'.$height.'px;';
		$HTML .= $CSSIMAGE_2;
		$HTML .= '">';
	}

	// Creazione codice HTML per embed code, normalmente utilizzo IFRAME
	// ma se questo è stato disattivato specificatamente utilizzo javascript API 

	if ($disableiframe == SZ_PLUGIN_GOOGLE_VALUE_YES) 
	{
		$HTML .= '<div class="sz-youtube-wrap" style="display:block;">';
		$HTML .= '<div class="sz-youtube-japi" id="'.$keyID.'" style="position:absolute;top:0;left:0;display:block;"></div>';
		$HTML .= '</div>';

		sz_google_module_youtube_add_video_API(
			array(
				'unique'          => $unique,
				'keyID'           => $keyID,
				'video'           => $vidID,
				'autoplay'        => $AUTOPLAY,
				'loop'            => $LOOP,
				'fullscreen'      => $FULLSCREEN,
				'disablekeyboard' => $DISABLEKEYBOARD,
				'theme'           => $theme,
				'cover'           => $cover,
				'analytics'       => $analytics,
				'delayed'         => $delayed,
				'start'           => $start,
				'end'             => $end,
				'schemaorg'       => $schemaorg,
				'name'            => $name,
				'description'     => $description,
				'disablerelated'  => $DISABLERELATED,
			)
		);

	} else { 

		$HTML .= '<div class="sz-youtube-wrap" id="'.$keyID.'" style="display:block;">';
		$HTML .= '<iframe ';
		$HTML .= 'src="'.$EMBEDURL;
		$HTML .= '&amp;wmode=opaque';
		$HTML .= '&amp;controls=1';
		$HTML .= '&amp;iv_load_policy=3';
		$HTML .= '&amp;autoplay='.$AUTOPLAY;
		$HTML .= '&amp;loop='.$LOOP;
		$HTML .= '&amp;fs='.$FULLSCREEN;
		$HTML .= '&amp;rel='.$DISABLERELATED;
		$HTML .= '&amp;disablekb='.$DISABLEKEYBOARD;
		$HTML .= '&amp;theme='.$theme;

		if ($start != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&amp;start='.$start;
		if ($end   != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&amp;end='.$end;

		$HTML .= '" ';
		$HTML .= 'style="position:absolute;top:0;left:0;width:100%;height:100%;"';
		$HTML .= '>';
		$HTML .= '</iframe>';
		$HTML .= '</div>';
	}

	$HTML .= '</div>';
	$HTML .= '</div>';

	// Creazione blocco del titolo sotto il video youtube, la stringa
	// viene passata tramite il paramtero "title" dello shortcode. 

	if ($title != SZ_PLUGIN_GOOGLE_VALUE_NULL) 
	{
		$HTML .= '<div class="sz-youtube-capt" ';
		$HTML .= 'style="background-color:#e8e8e8;padding:0.5em 1em;text-align:center;font-weight:bold;margin-top:5px;"';
		$HTML .= '>';
		$HTML .= $title;
		$HTML .= '</div>';
	}

	$HTML .= '</div>';

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento di un video youtube 

	return $HTML;
}

/* ************************************************************************** */
/* YOUTUBE VIDEO funzione per definizione shortcode                           */
/* ************************************************************************** */

function sz_google_shortcodes_youtube_video($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'url'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'responsive'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'autoplay'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'loop'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'fullscreen'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'disablekeyboard' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'theme'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'cover'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'disableiframe'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'analytics'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'delayed'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'start'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'end'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'schemaorg'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'name'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'description'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'disablerelated'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_module_youtube_get_code_video(array(
		'title'           => trim($title),
		'url'             => trim($url),
		'responsive'      => trim($responsive),
		'width'           => trim($width),
		'height'          => trim($height),
		'margintop'       => trim($margintop),
		'marginright'     => trim($marginright),
		'marginbottom'    => trim($marginbottom),
		'marginleft'      => trim($marginleft),
		'marginunit'      => trim($marginunit),
		'autoplay'        => trim($autoplay),
		'loop'            => trim($loop),
		'fullscreen'      => trim($fullscreen),
		'disablekeyboard' => trim($disablekeyboard),
		'theme'           => trim($theme),
		'cover'           => trim($cover),
		'disableiframe'   => trim($disableiframe),
		'analytics'       => trim($analytics),
		'delayed'         => trim($delayed),
		'start'           => trim($start),
		'end'             => trim($end),
		'schemaorg'       => trim($schemaorg),
		'name'            => trim($name),
		'description'     => trim($description),
		'disablerelated'  => trim($disablerelated),
	));

	return $HTML;
}

/* ************************************************************************** */ 
/* YOUTUBE VIDEO definizione ed elaborazione del widget su sidebar            */ 
/* ************************************************************************** */ 

class sz_google_module_youtube_widget_video extends SZGoogleWidget
{
	function __construct() 
	{
		parent::__construct('SZ-Google-Youtube-Video',__('SZ-Google - Youtube video','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-youtube sz-widget-google-youtube-video', 
			'description' => ucfirst(__('widget for youtube video','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'title'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'url'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'responsive'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'margintop'       => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
			'marginright'     => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
			'marginbottom'    => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
			'marginleft'      => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
			'marginunit'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'analytics'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'delayed'         => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'autoplay'        => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'loop'            => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'fullscreen'      => SZ_PLUGIN_GOOGLE_YOUTUBE_YES,
			'schemaorg'       => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'disableiframe'   => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'disablekeyboard' => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'disablerelated'  => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'name'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'description'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'duration'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'start'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'end'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'theme'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'cover'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Azzeramento variabile title per non confonderla con il title che deve
		// essere usato a livello di shortcode e non nei widgets

		$options['title'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_youtube_get_code_video($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'url'             => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'responsive'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'          => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'delayed'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'autoplay'        => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'loop'            => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'fullscreen'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'schemaorg'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'disableiframe'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'disablekeyboard' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'disablerelated'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'start'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'end'             => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'theme'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'cover'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'url'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'responsive'      => SZ_PLUGIN_GOOGLE_YOUTUBE_YES,
			'width'           => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDGET_WIDTH,
			'height'          => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDGET_HEIGHT,
			'delayed'         => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'autoplay'        => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'loop'            => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'fullscreen'      => SZ_PLUGIN_GOOGLE_YOUTUBE_YES,
			'schemaorg'       => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'disableiframe'   => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'disablekeyboard' => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'disablerelated'  => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
			'start'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'end'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'theme'           => SZ_PLUGIN_GOOGLE_YOUTUBE_THEME,
			'cover'           => SZ_PLUGIN_GOOGLE_YOUTUBE_COVER,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array)$instance,$array);

		$title           = trim(strip_tags($instance['title']));
		$url             = trim(strip_tags($instance['url']));
		$responsive      = trim(strip_tags($instance['responsive']));
		$width           = trim(strip_tags($instance['width']));
		$height          = trim(strip_tags($instance['height']));
		$delayed         = trim(strip_tags($instance['delayed']));
		$autoplay        = trim(strip_tags($instance['autoplay']));
		$loop            = trim(strip_tags($instance['loop']));
		$fullscreen      = trim(strip_tags($instance['fullscreen']));
		$schemaorg       = trim(strip_tags($instance['schemaorg']));
		$disableiframe   = trim(strip_tags($instance['disableiframe']));
		$disablekeyboard = trim(strip_tags($instance['disablekeyboard']));
		$disablerelated  = trim(strip_tags($instance['disablerelated']));
		$start           = trim(strip_tags($instance['start']));
		$end             = trim(strip_tags($instance['end']));
		$theme           = trim(strip_tags($instance['theme']));
		$cover           = trim(strip_tags($instance['cover']));

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.'sz-google-widget-youtube-video.php');
	}
}

/* ************************************************************************** */
/* YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUT */
/* YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUT */
/* YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUT */
/* YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUT */
/* YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUTUBE BADGE YOUT */
/* ************************************************************************** */

function sz_google_module_youtube_get_code_badge($atts=array())
{
	global $SZ_YOUTUBE_OBJECT;
	$options = $SZ_YOUTUBE_OBJECT->getOptions();

	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'channel'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'widthunit'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'heightunit' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$channel    = trim($channel);
	$width      = trim($width);
	$widthunit  = trim($widthunit);
	$height     = trim($height);
	$heightunit = trim($heightunit);

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if ($channel    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $channel    = $options['youtube_channel'];
	if ($width      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width      = '300';
	if ($height     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height     = '100';
	if ($widthunit  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $widthunit  = 'px';
	if ($heightunit == SZ_PLUGIN_GOOGLE_VALUE_NULL) $heightunit = 'px';

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

/* ************************************************************************** */
/* YOUTUBE BADGE funzione per definizione shortcode                           */
/* ************************************************************************** */

function sz_google_shortcodes_youtube_badge($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'channel'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'widthunit'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'heightunit' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_module_youtube_get_code_badge(array(
		'channel'    => trim($channel),
		'width'      => trim($width),
		'widthunit'  => trim($widthunit),
		'height'     => trim($height),
		'heightunit' => trim($heightunit),
	));

	return $HTML;
}

/* ************************************************************************** */
/* YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON */
/* YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON */
/* YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON */
/* YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON */
/* YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON YOUTUBE BUTTON */
/* ************************************************************************** */

function sz_google_module_youtube_get_code_button($atts=array())
{
	global $SZ_YOUTUBE_OBJECT;
	$options = $SZ_YOUTUBE_OBJECT->getOptions();

	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'channel' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'theme'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$channel = trim($channel);
	$layout  = trim($layout);
	$theme   = trim($theme);

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if ($channel == SZ_PLUGIN_GOOGLE_VALUE_NULL) $channel = $options['youtube_channel'];
	if ($layout  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $layout  = 'default';
	if ($theme   == SZ_PLUGIN_GOOGLE_VALUE_NULL) $theme   = 'default';

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if (!in_array($layout,array('default','full'))) $layout = 'default'; 
	if (!in_array($theme, array('default','dark'))) $theme  = 'default'; 

	// Verifico se canale è un nome o identificativo univoco 
	// come ad esempio il canale wordpress italy+ UCJqiM61oRRvhTD5il2n56xg

	$channel_type = sz_google_module_youtube_check_channel($channel);

	// Creazione codice HTML per embed code da inserire nella pagina wordpress

	$HTML  = '<div class="g-ytsubscribe" ';

	if ($channel_type == 'ID') $HTML .= 'data-channelid="'.$channel.'" ';
		else $HTML .= 'data-channel="'.$channel.'" ';

	$HTML .= 'data-layout="'.$layout.'" ';
	$HTML .= 'data-theme="'.$theme.'"';
	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_module_youtube_loading_script');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento di un video youtube 

	return $HTML;
}

/* ************************************************************************** */
/* YOUTUBE BUTTON funzione per definizione shortcode                          */
/* ************************************************************************** */

function sz_google_shortcodes_youtube_button($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'channel' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'theme'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_module_youtube_get_code_button(array(
		'channel' => trim($channel),
		'layout'  => trim($layout),
		'theme'   => trim($theme),
	));

	return $HTML;
}

/* ************************************************************************** */
/* YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE L */
/* YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE L */
/* YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE L */
/* YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE L */
/* YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE LINK YOUTUBE L */
/* ************************************************************************** */

function sz_google_module_youtube_get_code_link($atts=array())
{
	global $SZ_YOUTUBE_OBJECT;
	$options = $SZ_YOUTUBE_OBJECT->getOptions();

	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'channel'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'subscription' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'content'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$channel      = trim($channel);
	$subscription = trim($subscription);
	$text         = trim($text);

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if ($channel      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $channel = $options['youtube_channel'];
	if ($subscription == SZ_PLUGIN_GOOGLE_VALUE_NULL) $subscription  = SZ_PLUGIN_GOOGLE_VALUE_YES;
	if ($text         == SZ_PLUGIN_GOOGLE_VALUE_NULL) $text = SZGoogleCommon::getTranslate('channel youtube');

	// Conversione dei valori specificati direttamete nei parametri con
	// i valori usati per la memorizzazione dei valori di default

	if ($subscription == 'yes' or $subscription == 'y') $subscription = SZ_PLUGIN_GOOGLE_VALUE_YES; 
	if ($subscription == 'no'  or $subscription == 'n') $subscription = SZ_PLUGIN_GOOGLE_VALUE_NO; 

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	$YESNO = array(SZ_PLUGIN_GOOGLE_VALUE_YES,SZ_PLUGIN_GOOGLE_VALUE_NO);

	if (!in_array($subscription,$YESNO)) $subscription = SZ_PLUGIN_GOOGLE_VALUE_YES; 

	// Verifico se canale è un nome o identificativo univoco 
	// come ad esempio il canale wordpress italy+ UCJqiM61oRRvhTD5il2n56xg

	$channel_type = sz_google_module_youtube_check_channel($channel);

	if ($channel_type == 'ID') $ytURL = 'http://www.youtube.com/channel/';
		else $ytURL = 'http://www.youtube.com/user/';

	// Creazione codice HTML per embed code da inserire nella pagina wordpress

	if (empty($content)) 
	{
		$HTML  = '<a href="'.$ytURL.$channel.'?sub_confirmation='.$subscription.'">';
		$HTML .= $text;
		$HTML .= '</a>';

	} else {

		$HTML  = '<a href="'.$ytURL.$channel.'?sub_confirmation='.$subscription.'">';
		$HTML .= $content;
		$HTML .= '</a>';
	}

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento di un video youtube 

	return $HTML;
}

/* ************************************************************************** */
/* YOUTUBE LINK funzione per definizione shortcode                            */
/* ************************************************************************** */

function sz_google_shortcodes_youtube_link($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'channel'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'subscription' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_module_youtube_get_code_link(array(
		'channel'      => trim($channel),
		'subscription' => trim($subscription),
		'text'         => trim($text),
		'content'      => trim($content),
	));

	return $HTML;
}

/* ************************************************************************** */
/* YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUB */
/* YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUB */
/* YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUB */
/* YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUB */
/* YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUBE PLAYLIST YOUTUB */
/* ************************************************************************** */

function sz_google_module_youtube_get_code_playlist($atts=array())
{
	global $SZ_YOUTUBE_OBJECT;
	$options = $SZ_YOUTUBE_OBJECT->getOptions();

	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'id'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$id           = trim($id);
	$width        = strtolower(trim($width));
	$height       = strtolower(trim($height));
	$margintop    = strtolower(trim($margintop));
	$marginright  = strtolower(trim($marginright));
	$marginbottom = strtolower(trim($marginbottom));
	$marginleft   = strtolower(trim($marginleft));
	$marginunit   = strtolower(trim($marginunit));

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
	if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

	if (!is_numeric($width)  and $width  <> SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
	if (!is_numeric($height) and $height <> SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if (!is_numeric($margintop))    $margintop    = $options['youtube_margin_top'];
	if (!is_numeric($marginbottom)) $marginbottom = $options['youtube_margin_bottom'];

	if (!is_numeric($margintop))    $margintop    = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;
	if (!is_numeric($marginbottom)) $marginbottom = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;

	if (!is_numeric($marginright) and $marginright <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO) $marginright = $options['youtube_margin_right'];
	if (!is_numeric($marginleft)  and $marginleft  <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO) $marginleft  = $options['youtube_margin_left'];

	if (!is_numeric($marginright) and $marginright <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO) $marginright = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_RIGHT;
	if (!is_numeric($marginleft)  and $marginleft  <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO) $marginleft  = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_LEFT;

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if (!in_array($marginunit,array('em','px')))    $marginunit = $options['youtube_margin_unit']; 
	if (!in_array($marginunit,array('em','px')))    $marginunit = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT; 

	// Creazione variabile per il calcolo dei margini da applicare
	// se margini destra e sinistra sono uguali a zero diventano "auto" 

	$CSS1 = '';

	if ($margintop == '0') $CSS1 .= 'margin-top:0;';
		else $CSS1 .= 'margin-top:'.trim($margintop).trim($marginunit).';';

	if (in_array($marginright,array('0','auto'))) $CSS1 .= 'margin-right:'.$marginright.';';
		else $CSS1 .= 'margin-right:'.trim($marginright).trim($marginunit).';';

	if ($marginbottom == '0') $CSS1 .= 'margin-bottom:0;';
		else $CSS1 .= 'margin-bottom:'.trim($marginbottom).trim($marginunit).';';

	if (in_array($marginleft,array('0','auto'))) $CSS1 .= 'margin-left:'.$marginleft.';';
		else $CSS1 .= 'margin-left:'.trim($marginleft).trim($marginunit).';';

	// Se non ho trovato nessun video ID durante l'analisi URL
	// preparo codice HTML per indicare errore di elaborazione funzione

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
	{
		$HTML  = '<div class="sz-youtube-main" style="'.$CSS.'">';
		$HTML .= '<div class="sz-youtube-warn" style="display:block;padding:1em 0;text-align:center;background-color:#e1e1e1;border:1px solid #b1b1b1;">';
		$HTML .= ucfirst(SZGoogleCommon::getTranslate('youtube playlist ID is not valid.'));
		$HTML .= '</div>';
		$HTML .= '</div>';

		return $HTML;
	}

	// Controllo se ho specificato una altezza automatica o specifica, solo
	// nel primo caso utilizzo un contenitore con la tecnica usata nel responsive

	$HTML = '';
	$CSS2 = '';
	$CSS3 = '';

	if ($width  == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $CSS2 .= 'width:100%;';
	if ($width  <> SZ_PLUGIN_GOOGLE_VALUE_AUTO) $CSS2 .= 'width:' .$width .'px;';
	if ($height <> SZ_PLUGIN_GOOGLE_VALUE_AUTO) $CSS3 .= 'height:'.$height.'px;';

	// Attivazione contenitore con tecnica per responsive o nel caso siano state
	// specificate delle dimensioni il contenitore sarà a dimensione fissa

	if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO)
	{
		$HTML .= '<div class="sz-youtube-cont" ';
		$HTML .= 'style="';
		$HTML .= 'position:relative;';
		$HTML .= 'padding-bottom:56.25%;';
		$HTML .= 'height:0;';
		$HTML .= 'overflow:hidden;';
		$HTML .= $CSS2;
		$HTML .= '">';

	} else {

		$HTML .= '<div class="sz-youtube-cont" ';
		$HTML .= 'style="';
		$HTML .= 'position:relative;';
		$HTML .= $CSS2.$CSS3;
		$HTML .= '">';
	}

	// Creazione codice HTML per inserimento nella pagina, la tecnica usata
	// può essere la definizione di un IFRAME e la chiamata ad una funzione API 

	$HTML .= '<div class="sz-youtube-wrap" style="'.$CSS1.'">';
	$HTML .= '<div class="sz-youtube-playlist">';
	$HTML .= '<iframe src="https://www.youtube.com/embed/videoseries?';
	$HTML .= 'list='.$id;
	$HTML .= '&amp;wmode=opaque';
	$HTML .= '" ';
	$HTML .= 'style="position:absolute;top:0;left:0;width:100%;height:100%;" ';
	$HTML .= 'frameborder="0">';
	$HTML .= '</iframe>';
	$HTML .= '</div>';
	$HTML .= '</div>';
	$HTML .= '</div>';

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento di un video youtube 

	return $HTML;
}

/* ************************************************************************** */
/* YOUTUBE PLAYLIST funzione per definizione shortcode                        */
/* ************************************************************************** */

function sz_google_shortcodes_youtube_playlist($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'id'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_module_youtube_get_code_playlist(array(
		'id'           => trim($id),
		'width'        => trim($width),
		'height'       => trim($height),
		'margintop'    => trim($margintop),
		'marginright'  => trim($marginright),
		'marginbottom' => trim($marginbottom),
		'marginleft'   => trim($marginleft),
		'marginunit'   => trim($marginunit),
	));

	return $HTML;
}

/* ************************************************************************** */ 
/* YOUTUBE PLAYLIST definizione ed elaborazione del widget su sidebar         */ 
/* ************************************************************************** */ 

class sz_google_module_youtube_widget_playlist extends SZGoogleWidget
{
	function __construct() 
	{
		parent::__construct('SZ-Google-Youtube-Playlist',__('SZ-Google - Youtube playlist','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-youtube sz-widget-google-youtube-playlist', 
			'description' => ucfirst(__('widget for youtube playlist','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'id'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
			'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
			'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
			'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
			'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($controls['width_auto']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width']  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
		if ($controls['height_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['height'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_youtube_get_code_playlist($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'id'          => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'id'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'       => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDGET_WIDTH,
			'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'      => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDGET_HEIGHT,
			'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array)$instance,$array);

		$title           = trim(strip_tags($instance['title']));
		$id              = trim(strip_tags($instance['id']));
		$width           = trim(strip_tags($instance['width']));
		$width_auto      = trim(strip_tags($instance['width_auto']));
		$height          = trim(strip_tags($instance['height']));
		$height_auto     = trim(strip_tags($instance['height_auto']));

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.'sz-google-widget-youtube-playlist.php');
	}
}

/* ************************************************************************** */
/* YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON */
/* YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON */
/* YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON */
/* YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON */
/* YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON YOUTUBE COMMON */
/* ************************************************************************** */

function sz_google_module_youtube_add_video_API($opts=array())
{
	global $SZ_GOOGLE_YOUTUBE_API;

	if (is_array($opts)) {
		$SZ_GOOGLE_YOUTUBE_API[] = $opts;
		add_action('wp_footer','sz_google_module_youtube_add_script_footer');
	}
}

/* ************************************************************************** */
/* YOUTUBE Funzione per aggiungere un video al caricamento tramite API        */
/* ************************************************************************** */

function sz_google_module_youtube_add_script_footer()
{
	global $SZ_GOOGLE_YOUTUBE_API;

	if (isset($SZ_GOOGLE_YOUTUBE_API) and is_array($SZ_GOOGLE_YOUTUBE_API)) 
	{
		// Codice javascript per il rendering iframe tramite API
	
		$HTML  = '<script type="text/javascript">';

		$HTML .= "var element = document.createElement('script');";
		$HTML .= 'element.src = "https://www.youtube.com/player_api";';
		$HTML .= "var myscript = document.getElementsByTagName('script')[0];";
		$HTML .= 'myscript.parentNode.insertBefore(element,myscript);';

		// Creazione variabile per ogni player inserito nella pagina web
		// utilizzo l'identificativo univoco per il nome variabile
 
		foreach ($SZ_GOOGLE_YOUTUBE_API as $value) {
			if (is_array($value) and isset($value['video'])) { 
				$HTML .= 'var myplayer_'.$value['unique'].';';
			}
		}

		// Creazione funzione per caricamento dei player inseriti nella
		// pagina web. creazione del codice javascript per ogni player univoco

		$HTML .= 'function onYouTubePlayerAPIReady() {';

		foreach ($SZ_GOOGLE_YOUTUBE_API as $value) {
			if (is_array($value) and isset($value['video'])) { 
				if (!isset($value['delayed']) or $value['delayed'] == SZ_PLUGIN_GOOGLE_VALUE_NO) { 
					$HTML .= 'onYouTubePlayerAPIReady_'.$value['unique'].'();';
				}
			}
		}

		$HTML .= '}';

		// Creazione funzione per caricamento dei player inseriti nella
		// pagina web. creazione del codice javascript per ogni player univoco

		foreach ($SZ_GOOGLE_YOUTUBE_API as $value) {
			if (is_array($value) and isset($value['video'])) 
			{ 
				$HTML .= 'function onYouTubePlayerAPIReady_'.$value['unique'].'() {';
				$HTML .=		"myplayer_".$value['unique']." = new YT.Player('".$value['keyID']."', {";
				$HTML .=			"width:'100%',";
				$HTML .=			"height:'100%',";
				$HTML .=			"videoId:'".$value['video']."',";

//				if ($value['start'] != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= "'startSeconds':".$value['start'].",";
//				if ($value['end']   != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= "'endSeconds':".$value['end'].",";//

				$HTML .=			'playerVars: {';
				$HTML .= 			"'controls':1,";
				$HTML .= 			"'iv_load_policy':3,";
				$HTML .= 			"'autoplay':".$value['autoplay'].",";
				$HTML .= 			"'loop':".$value['loop'].",";
				$HTML .= 			"'rel':".$value['disablerelated'].",";
				$HTML .= 			"'fs':".$value['fullscreen'].",";
				$HTML .= 			"'disablekb':".$value['disablekeyboard'].",";
				$HTML .= 			"'theme':'".$value['theme']."',";
				$HTML .= 			"'wmode':'opaque'";
				$HTML .=			'},';     			
				$HTML .=			'events: {';
				$HTML .= 			"'onStateChange':callbackPlayerStatus_".$value['unique'];
				$HTML .=			'}';     			
				$HTML .= 	'});';
				$HTML .= '}';
			}
		}

		// Creazione funzione per caricamento codice google analytics da
		// collegare ad ogni singolo player presente sulla pagina web

		foreach ($SZ_GOOGLE_YOUTUBE_API as $value) {
			if (is_array($value) and isset($value['video'])) 
			{ 
				$HTML .= 'function callbackPlayerStatus_'.$value['unique'].'(event) {';

				if (isset($value['analytics']) and $value['analytics'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
				{
					$HTML .=		'switch (event.data){';
					$HTML .=			'case YT.PlayerState.PLAYING:';
					$HTML .=				"_gaq.push(['_trackEvent','Video','Playing',myplayer_".$value['unique'].".getVideoUrl()]);";
					$HTML .=				'break;';
					$HTML .= 		'case YT.PlayerState.ENDED:';
					$HTML .=				"_gaq.push(['_trackEvent','Video','Ended',myplayer_".$value['unique'].".getVideoUrl()]);";
					$HTML .=				'break;';
					$HTML .=			'case YT.PlayerState.PAUSED:';
					$HTML .=				"_gaq.push(['_trackEvent','Video','Paused',myplayer_".$value['unique'].".getVideoUrl()]);";
					$HTML .=			"break;";
					$HTML .=		'}';
				}

				$HTML .= '}';
			}
		}

		$HTML .= '</script>'."\n";
	
		// Scrittura codice javascript creato per youtube API
		echo $HTML;
	}
}

/* ************************************************************************** */
/* YOUTUBE Funzione per aggiungere il codice javascript plusone per i bottoni */
/* ************************************************************************** */

function sz_google_module_youtube_loading_script()
{
	// Se sono già entrato in questa funzione non eseguo niente

	if (defined('SZ_GOOGLE_MODULE_PLUS_ADD_SCRIPT_FOOTER')) return;
	
	// Se esiste la funzione del modulo google plus eseguo quella in quanto è
	// più completa ed esegue anche il controllo sulla lingua dei bottoni

	if (function_exists('sz_google_module_plus_add_script_footer')) {
		return sz_google_module_plus_add_script_footer();
	}

	define('SZ_GOOGLE_MODULE_PLUS_ADD_SCRIPT_FOOTER',true);

	// Codice javascript per il rendering dei componenti google plus
	
	$javascript  = '<script type="text/javascript">';
	$javascript .= "(function() {";
	$javascript .= "var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;";
	$javascript .= "po.src = 'https://apis.google.com/js/plusone.js';";
	$javascript .=  "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);";
	$javascript .=  "})();";
	$javascript .=	"</script>"."\n";
	
	echo $javascript;
}

/* ************************************************************************** */
/* YOUTUBE Funzione per controllare se canale è un nome o un codice ID        */
/* ************************************************************************** */

function sz_google_module_youtube_check_channel($channel) 
{
	if (strlen($channel) == 24 and substr($channel,0,2) == 'UC') return "ID";
		else return "NAME";
}
