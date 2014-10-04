<?php
/*
Plugin Name: SZ - Google
Plugin URI: https://otherplus.com/tech/sz-google/
Description: Plugin to integrate <a href="http://google.com" target="_blank">Google's</a> products in <a href="http://wordpress.org" target="_blank">WordPress</a> with particular attention to the widgets provided by the social network Google+. Before using the plug-in <em>sz-google</em> pay attention to the options to be specified in the admin panel and enter all the parameters necessary for the proper functioning of the plugin. If you want to know the latest news and releases from the plug-in <a href="http://wordpress.org/plugins/sz-google/">sz-google</a> follow the <a href="https://plus.google.com/+wpitalyplus" target="_blank">official page</a> present in Google+ or subscribe to our community <a href="https://plus.google.com/communities/109254048492234113886" target="_blank">WP Italyplus</a> always present on Google+.
Author: Massimo Della Rovere
Version: 1.8.0
Author URI: https://plus.google.com/+MassimoDellaRovere
License: GPLv2 or later
Copyright 2012-2014 otherplus (email: wordpress@otherplus.com)

Text Domain:szgoogleplugin
Domain Path:/admin/languages
*/

/**
 * Questo plugin è stato scritto con il supporto della nostra community
 * WP Italyplus presente sul social network di google+, colgo l'occasione
 * per ringraziare tutte le persone che ci hanno aiutato e supportato nello
 * sviluppo di questo plugin per wordpress, i moduli da sviluppare sono 
 * ancora tantissimi, quindi qualsiasi idea o consiglio che può interessare
 * sviluppi futuri possono essere postati direttamente nella community.
 * 
 * @Website..: https://otherplus.com/tech/
 * @Community: https://plus.google.com/communities/109254048492234113886
 *
 * Thanks to Eugenio Petullà for support and developer code.
 * Thanks to Patrizio Dell'Anna for plugin translate in english.
 * Thanks to AJ Clarke for article about tinymce tweaks.
 * Thanks to Henrik Schack for inspiration in authenticator found in repository.
 * Thanks to Michael Kliewe for PHP part of code found in @PHPGangsta.
 *
 */
if (!defined('ABSPATH')) die("Accesso diretto al file non permesso");

// Definizione delle costanti da usare nel plugin per uso generale,
// qui vanno definite le costanti per URL, basename, versione, ect.

define('SZ_PLUGIN_GOOGLE',true);
define('SZ_PLUGIN_GOOGLE_MAIN',__FILE__);
define('SZ_PLUGIN_GOOGLE_VERSION','1.8.0');

// Il plugin necessita di alcuni controllo sugli utenti collegati prima che questi
// vengano caricati dal core. Quindi in assensa si anticipa il caricamento.

if (!function_exists('is_user_logged_in()')) {
	if (is_readable(ABSPATH.WPINC.'/pluggable.php')) {
	   require_once(ABSPATH.WPINC.'/pluggable.php');
	}
}

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome.

if (!class_exists('SZGoogleCheck'))
{
	class SZGoogleCheck
	{
		private $PHP       = '5.2.0'; // Requisito minimo PHP
		private $WORDPRESS = '3.5.0'; // Requisito minimo WORDPRESS

		// Funzione costruttore per controlli e operazioni iniziali.
		// Il controllo principale di questa classe è legato ai controlli di versione.

		function __construct()
		{
			if ($this->is_compatible_version()) $this->load_plugin_framework();
				else if (is_admin()) add_action('admin_notices',array($this,'load_plugin_admin_notices'));

			register_activation_hook(__FILE__,array($this,'activate'));
		}

		// Funzione di hook per attivazione plugin da eseguire per il
		// controllo di versione e prerequisiti minimi necessari.

		function activate()
		{
			if (!$this->is_compatible_version()) 
			{
				$HTML  = '<div>Activation plugin SZ-Google in not possible:</div>';
				$HTML .= '<ul>';

				if (!$this->is_compatible_PHP())       $HTML .= '<li>'.$this->get_admin_notices_PHP(false).'</li>';
				if (!$this->is_compatible_WORDPRESS()) $HTML .= '<li>'.$this->get_admin_notices_WORDPRESS(false).'</li>';

				$HTML .= '</ul>';

				wp_die($HTML,'Activation (sz-google) is not possible',array('back_link' => true));
			};
		}

		// Se il plugin risulta attivo ma i requisiti minimi non sono soddisfatti
		// viene richiamata questa funzione per aggiungere in bacheca i dettagli di errore.

		function load_plugin_admin_notices() {
			if (!$this->is_compatible_PHP())       echo $this->get_admin_notices_PHP(true);
			if (!$this->is_compatible_WORDPRESS()) echo $this->get_admin_notices_WORDPRESS(true);
		}

		function get_admin_notices_PHP($wrap) {
			return $this->get_admin_notices_TEXT($wrap,'PHP',phpversion(),$this->PHP);
		}

		function get_admin_notices_WORDPRESS($wrap) {
			return $this->get_admin_notices_TEXT($wrap,'WORDPRESS',$GLOBALS['wp_version'],$this->WORDPRESS);
		}

		// Funzione per la creazione di un errore generico da visualizzare durante
		// la funzione di attivazione o nella bacheca di amministrazione.

		function get_admin_notices_TEXT($wrap,$s1,$s2,$s3) 
		{
			$HTML = 'Your server is running %s version %s but this plugin requires at least %s';

			if ($wrap === false) $HTML = "<div>{$HTML}</div>";
				else $HTML = "<div class=\"error\"><p>(<b>sz-google</b>) - {$HTML}</p></div>";

			return sprintf($HTML,$s1,$s2,$s3);
		}

		// Controllo compatibilità del plugin con le versioni installate
		// In caso di incompatibilità fermo il caricamento completo del plugin

		function is_compatible_version() {
			if ($this->is_compatible_PHP() && $this->is_compatible_WORDPRESS()) return true;
				else return false;
		}

		// Controllo compatibilità del plugin con la versione di PHP installata
		// In caso di incompatibilità fermo il caricamento completo del plugin

		function is_compatible_PHP() {
			if (version_compare(phpversion(),$this->PHP,'<')) return false;
				else return true;
		}

		// Controllo compatibilità del plugin con la versione di Wordpress installata
		// In caso di incompatibilità fermo il caricamento completo del plugin

		function is_compatible_WORDPRESS() {
			if (version_compare($GLOBALS['wp_version'],$this->WORDPRESS,'<')) return false;
				else return true;
		}

		// Se il plugin risulta compatibile in base ai requisiti minimi
		// carico i file che contengono il framework principale del plugin.

		function load_plugin_framework() 
		{
			// Attivazione del caricamento dinamico delle classi senza dover
			// utilizzare la funzione di require prima della definizione di classe

			spl_autoload_register(array($this,'auto_loader_classes'));

			// Creazione oggetto da classe che esegue il caricamento
			// completo del plugin con i moduli attivati, i filtri ect, ect

			new SZGooglePlugin();			
		}

		// Attivazione funzione di autoloader per le classi del plugin, se la funzione dovesse
		// essere richiamata per classi diverse da SZGoogle il sistema di autoloading viene ignorato.

		function auto_loader_classes($classname) 
		{
			if (substr($classname,0,8) != 'SZGoogle') return;

			// Caricamento delle classi che interessano la parte di amministrazione
			// queste classi inizieranno con il prefisso "SZGoogleAdmin"

			if (substr($classname,0,13) == 'SZGoogleAdmin') {
				if (is_readable(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/classes/'.$classname.'.php')) {
					   @require(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/classes/'.$classname.'.php'); return;
				}
			}

			// Caricamento delle classi che appartengono al plugin cercando il prefisso
			// dopo il nome "SZGoogle" e usandolo come parte di directory di "classes".

			$prefix = preg_split('#([A-Z][^A-Z]*)#',$classname,null,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

			if (is_readable(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/classes/'.strtolower($prefix[3]).'/'.$classname.'.php')) {
				   @require(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/classes/'.strtolower($prefix[3]).'/'.$classname.'.php'); return;
			}
		}
	}

	// Creazione oggetto principale per il controllo di compatibilità.
	// Se i requisiti necessari sono soddisfatti eseguo il caricamento completo.

	new SZGoogleCheck();
}
