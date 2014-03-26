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
		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			parent::__construct('SZGoogleModuleDrive');

			$this->moduleShortcodes = array(
				'drive_savebutton_shortcode' => array('sz-drive-save','sz_google_module_drive_shortcodes_savebutton'),
			);

			$this->moduleWidgets = array(
				'drive_savebutton_widget'    => 'SZGoogleWidgetDriveSaveButton',
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
			$options = get_option('sz_google_options_drive');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'drive_sitename'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'drive_savebutton_widget'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive_savebutton_shortcode' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Controllo delle opzioni in caso di valori non conformi
			// richiamo della funzione per il controllo Yes o No

			$options = $this->checkOptionIsYesNo($options,array(
				'drive_savebutton_widget'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive_savebutton_shortcode' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali della funzione di reperimento opzioni

			return $options;
		}
	}
}

global $SZ_DRIVE_OBJECT;

/**
 * Creazione oggetto principale per creazione ed elaborazione del
 * modulo richiesto, controllare il costruttore per azioni iniziali
 */
$SZ_DRIVE_OBJECT = new SZGoogleModuleDrive();
$SZ_DRIVE_OBJECT->moduleAddWidgets();
$SZ_DRIVE_OBJECT->moduleAddShortcodes();

/* ************************************************************************** */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* ************************************************************************** */

function sz_google_module_drive_get_code_savebutton($atts=array(),$content=null)
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

	$HTML = SZGooglePluginCommon::getCodeButtonWrap(array(
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

	add_action('SZGoogleFooter','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* DRIVE SAVE BUTTON funzione per elaborazione shortcode (sz-drive-save)      */
/* ************************************************************************** */

function sz_google_module_drive_shortcodes_savebutton($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_drive_get_code_savebutton(shortcode_atts(array(
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