<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */ 
/* Definizione variabili globali per controlli e memorizzazioni comnuni       */ 
/* ************************************************************************** */ 
global $SZ_GOOGLE_YOUTUBE; 
global $SZ_GOOGLE_YOUTUBE_API; 

$SZ_GOOGLE_YOUTUBE = true;
$SZ_GOOGLE_YOUTUBE_API = array();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali componenti risultano attivati        */ 
/* ************************************************************************** */ 

$options = sz_google_modules_youtube_options();

if ($options['youtube_shortcode'] == '1') { 
	add_shortcode('sz-ytvideo','sz_google_shortcodes_youtube_video');
}

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_youtube_options()
{
	// Caricamento delle opzioni per modulo google youtube

	$options = get_option('sz_google_options_youtube');

	// Controllo delle opzioni in caso di valori non validi

	if (!isset($options['youtube_widget']))             $options['youtube_widget']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_shortcode']))          $options['youtube_shortcode']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_responsive']))         $options['youtube_responsive']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_width']))              $options['youtube_width']            = SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH;
	if (!isset($options['youtube_height']))             $options['youtube_height']           = SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT;
	if (!isset($options['youtube_margin_top']))         $options['youtube_margin_top']       = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;
	if (!isset($options['youtube_margin_right']))       $options['youtube_margin_right']     = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO;
	if (!isset($options['youtube_margin_bottom']))      $options['youtube_margin_bottom']    = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;
	if (!isset($options['youtube_margin_left']))        $options['youtube_margin_left']      = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO;
	if (!isset($options['youtube_margin_unit']))        $options['youtube_margin_unit']      = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT;
	if (!isset($options['youtube_force_ssl']))          $options['youtube_force_ssl']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_autoplay']))           $options['youtube_autoplay']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_loop']))               $options['youtube_loop']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_fullscreen']))         $options['youtube_fullscreen']       = SZ_PLUGIN_GOOGLE_VALUE_YES;
	if (!isset($options['youtube_disablekeyboard']))    $options['youtube_disablekeyboard']  = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_theme']))              $options['youtube_theme']            = SZ_PLUGIN_GOOGLE_YOUTUBE_THEME;
	if (!isset($options['youtube_disableiframe']))      $options['youtube_disableiframe']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_analytics']))          $options['youtube_analytics']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube_delayed']))            $options['youtube_delayed']          = SZ_PLUGIN_GOOGLE_VALUE_NO;

	// Se i valori numerici non sono coerenti imposto il valore di default

	if (trim($options['youtube_width'])           == '') $options['youtube_width']           = SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH;
	if (trim($options['youtube_height'])          == '') $options['youtube_height']          = SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT;
	if (trim($options['youtube_margin_top'])      == '') $options['youtube_margin_top']      = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;
	if (trim($options['youtube_margin_right'])    == '') $options['youtube_margin_right']    = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO;
	if (trim($options['youtube_margin_bottom'])   == '') $options['youtube_margin_bottom']   = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;
	if (trim($options['youtube_margin_left'])     == '') $options['youtube_margin_left']     = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO;
	if (trim($options['youtube_margin_unit'])     == '') $options['youtube_margin_unit']     = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT;
	if (trim($options['youtube_force_ssl'])       == '') $options['youtube_force_ssl']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (trim($options['youtube_autoplay'])        == '') $options['youtube_autoplay']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (trim($options['youtube_loop'])            == '') $options['youtube_loop']            = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (trim($options['youtube_fullscreen'])      == '') $options['youtube_fullscreen']      = SZ_PLUGIN_GOOGLE_VALUE_YES;
	if (trim($options['youtube_disablekeyboard']) == '') $options['youtube_disablekeyboard'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (trim($options['youtube_theme'])           == '') $options['youtube_theme']           = SZ_PLUGIN_GOOGLE_YOUTUBE_THEME;
	if (trim($options['youtube_disableiframe'])   == '') $options['youtube_disableiframe']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (trim($options['youtube_analytics'])       == '') $options['youtube_analytics']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (trim($options['youtube_delayed'])         == '') $options['youtube_delayed']         = SZ_PLUGIN_GOOGLE_VALUE_NO;

	// Se opzioni contengono valori non supportati imposto i parametri di default

	if (!is_numeric($options['youtube_width']))         $options['youtube_width']         = SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH;
	if (!is_numeric($options['youtube_height']))        $options['youtube_height']        = SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT;
	if (!is_numeric($options['youtube_margin_top']))    $options['youtube_margin_top']    = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;
	if (!is_numeric($options['youtube_margin_bottom'])) $options['youtube_margin_bottom'] = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO;

	// Controllo opzioni per margini destro e sinistro con valore speciale "auto"

	if (!is_numeric($options['youtube_margin_right']) and strtolower(trim($options['youtube_margin_right'])) <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO)
		$options['youtube_margin_right']  = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_RIGHT;

	if (!is_numeric($options['youtube_margin_left']) and strtolower(trim($options['youtube_margin_left'])) <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO)
		$options['youtube_margin_left']   = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_LEFT;

	// Controllo opzioni con caratteristiche particolari e impostazioni predefinite

	if (!in_array(strtolower(trim($options['youtube_margin_unit'])),array('em','px'))) 
		$options['youtube_margin_unit'] = SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT; 

	if (!in_array(strtolower(trim($options['youtube_theme'])),array('dark','light'))) 
		$options['youtube_theme'] = SZ_PLUGIN_GOOGLE_YOUTUBE_THEME; 

	// Se trovo un valore non riconosciuto imposto dei valori predefiniti validi

	$selects = array(SZ_PLUGIN_GOOGLE_VALUE_NO,SZ_PLUGIN_GOOGLE_VALUE_YES);

	if (!in_array($options['youtube_widget'],$selects))          $options['youtube_widget']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_shortcode'],$selects))       $options['youtube_shortcode']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_responsive'],$selects))      $options['youtube_responsive']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_force_ssl'],$selects))       $options['youtube_force_ssl']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_autoplay'],$selects))        $options['youtube_autoplay']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_loop'],$selects))            $options['youtube_loop']            = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_fullscreen'],$selects))      $options['youtube_fullscreen']      = SZ_PLUGIN_GOOGLE_VALUE_YES;
	if (!in_array($options['youtube_disablekeyboard'],$selects)) $options['youtube_disablekeyboard'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_disableiframe'],$selects))   $options['youtube_disableiframe']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_analytics'],$selects))       $options['youtube_analytics']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube_delayed'],$selects))         $options['youtube_delayed']         = SZ_PLUGIN_GOOGLE_VALUE_NO;

	// Ritorno array con elenco delle opzioni controllate e corrette

	return $options;
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google youtube              */
/* ************************************************************************** */ 

function sz_google_modules_youtube_get_code($atts=array())
{
	$options = sz_google_modules_youtube_options();

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
		'title'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'disableiframe'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'analytics'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'delayed'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$url             = trim($url);
	$title           = trim($title);

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
	if ($disableiframe   == SZ_PLUGIN_GOOGLE_VALUE_NULL) $disableiframe   = $options['youtube_disableiframe'];
	if ($analytics       == SZ_PLUGIN_GOOGLE_VALUE_NULL) $analytics       = $options['youtube_analytics'];
	if ($delayed         == SZ_PLUGIN_GOOGLE_VALUE_NULL) $delayed         = $options['youtube_delayed'];

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

	if ($responsive      == 'no'  or $responsive      == 'n') $responsive      = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($autoplay        == 'no'  or $autoplay        == 'n') $autoplay        = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($loop            == 'no'  or $loop            == 'n') $loop            = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($fullscreen      == 'no'  or $fullscreen      == 'n') $fullscreen      = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($disablekeyboard == 'no'  or $disablekeyboard == 'n') $disablekeyboard = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($disableiframe   == 'no'  or $disableiframe   == 'n') $disableiframe   = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($analytics       == 'no'  or $analytics       == 'n') $analytics       = SZ_PLUGIN_GOOGLE_VALUE_NO; 
	if ($delayed         == 'no'  or $delayed         == 'n') $delayed         = SZ_PLUGIN_GOOGLE_VALUE_NO; 

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
	if (!in_array($delayed,$YESNO))         $analytics       = $options['youtube_analytics']; 

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if (!is_numeric($width))        $width        = $options['youtube_width'];
	if (!is_numeric($height))       $height       = $options['youtube_height'];
	if (!is_numeric($margintop))    $margintop    = $options['youtube_margin_top'];
	if (!is_numeric($marginbottom)) $marginbottom = $options['youtube_margin_bottom'];

	if (!is_numeric($marginright) and strtolower(trim($marginright)) <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO)
		$marginright = $options['youtube_margin_right'];

	if (!is_numeric($marginleft) and strtolower(trim($marginleft)) <> SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO)
		$marginleft = $options['youtube_margin_left'];

	if (!in_array($marginunit,array('em','px'))) 
		$marginunit = $options['youtube_margin_unit']; 

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
		$HTML .= ucfirst(__('youtube URL string specified is not valid.','szgoogleadmin'));
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

	$ONCLICK      = '';
	$CSSIMAGE_1   = 'display:block;';
	$CSSIMAGE_2   = 'display:block;';

	$COVERIMAGE = plugin_dir_url(dirname(__FILE__)).'images/youtube-cover.jpg';
	$COVERPLAYS = plugin_dir_url(dirname(__FILE__)).'images/youtube-play.png';

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

	// Creazione codice HTML per inserimento codice nella pagina 

	$HTML  = '<div class="sz-youtube-main" style="'.$CSS.'">';
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

		sz_google_modules_youtube_add_video_API(
			array(
				'unique'          => $unique,
				'keyID'           => $keyID,
				'video'           => $vidID,
				'autoplay'        => $AUTOPLAY,
				'loop'            => $LOOP,
				'fullscreen'      => $FULLSCREEN,
				'disablekeyboard' => $DISABLEKEYBOARD,
				'theme'           => $theme,
				'analytics'       => $analytics,
				'delayed'         => $delayed,
			)
		);

	} else { 

		$HTML .= '<div class="sz-youtube-wrap" id="'.$keyID.'" style="display:block;">';
		$HTML .= '<iframe ';
		$HTML .= 'src="'.$datas['scheme'].'://www.youtube.com/embed/'.$vidID.'?v='.$vidID;
		$HTML .= '&amp;wmode=opaque';
		$HTML .= '&amp;controls=1';
		$HTML .= '&amp;iv_load_policy=3';
		$HTML .= '&amp;autoplay='.$AUTOPLAY;
		$HTML .= '&amp;loop='.$LOOP;
		$HTML .= '&amp;fs='.$FULLSCREEN;
		$HTML .= '&amp;disablekb='.$DISABLEKEYBOARD;
		$HTML .= '&amp;theme='.$theme;
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

//end
//showinfo
//start

	return $HTML;
}

/* ************************************************************************** */
/* Funzione per aggiungere un video al caricamento tramite API su footer      */
/* ************************************************************************** */

function sz_google_modules_youtube_add_video_API($opts=array())
{
	global $SZ_GOOGLE_YOUTUBE_API;

	if (is_array($opts)) {
		$SZ_GOOGLE_YOUTUBE_API[] = $opts;
		add_action('wp_footer','sz_google_modules_youtube_add_script_footer');
	}
}

/* ************************************************************************** */
/* Funzione per aggiungere un video al caricamento tramite API su footer      */
/* ************************************************************************** */

function sz_google_modules_youtube_add_script_footer()
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
				$HTML .=			'playerVars: {';
				$HTML .= 			"'controls':1,";
				$HTML .= 			"'iv_load_policy':3,";
				$HTML .= 			"'autoplay':".$value['autoplay'].",";
				$HTML .= 			"'loop':".$value['loop'].",";
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
/* Funzione shortcode per inserimento GOOGLE YOUTUBE VIDEO                    */
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
		'title'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'disableiframe'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'analytics'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'delayed'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_modules_youtube_get_code(array(
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
		'title'           => trim($title),
		'disableiframe'   => trim($disableiframe),
		'analytics'       => trim($analytics),
		'delayed'         => trim($delayed),
	));

	return $HTML;
}