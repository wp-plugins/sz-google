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

if (!class_exists('SZGoogleActionAnalytics'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionAnalytics extends SZGoogleAction
	{
		/**
		 * Definizione della funzione che viene normalmente richiamata
		 * dagli hook presenti in add_action e add_filter di wordpress
		 */
		function action() {
			echo $this->getMonitorCode(array());
		}

		/**
		 * Definizione della funzione che viene normalmente richiamata
		 * dagli hook presenti in add_action e add_filter di wordpress
		 */
		function getMonitorCode($atts=array())
		{
			// Calcolo per opzioni di configurazione collegate al modulo
			// richiesto e specificate nel pannello di amministrazione
			
			$options = (object) $this->getModuleOptions('SZGoogleModuleAnalytics');

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'ga_type'                 => $options->ga_type,
				'ga_uacode'               => $options->ga_uacode,
				'ga_position'             => $options->ga_position,
				'ga_enable_front'         => $options->ga_enable_front,
				'ga_enable_admin'         => $options->ga_enable_admin,
				'ga_enable_administrator' => $options->ga_enable_administrator,
				'ga_enable_logged'        => $options->ga_enable_logged,
				'ga_enable_subdomain'     => $options->ga_enable_subdomain,
				'ga_enable_multiple'      => $options->ga_enable_multiple,
				'ga_enable_advertiser'    => $options->ga_enable_advertiser,
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$ga_uacode               = trim($ga_uacode);
			$ga_type                 = strtolower(trim($ga_type));
			$ga_position             = strtoupper(trim($ga_position));
			$ga_enable_front         = strtolower(trim($ga_enable_front));
			$ga_enable_admin         = strtolower(trim($ga_enable_admin));
			$ga_enable_administrator = strtolower(trim($ga_enable_administrator));
			$ga_enable_logged        = strtolower(trim($ga_enable_logged));
			$ga_enable_subdomain     = strtolower(trim($ga_enable_subdomain));
			$ga_enable_multiple      = strtolower(trim($ga_enable_multiple));
			$ga_enable_advertiser    = strtolower(trim($ga_enable_advertiser));

			// Conversione dei valori specificati direttamete nei parametri con
			// i valori usati per la memorizzazione dei valori di default

			if ($ga_enable_front         == 'yes' or $ga_enable_front         == 'y') $ga_enable_front         = '1'; 
			if ($ga_enable_admin         == 'yes' or $ga_enable_admin         == 'y') $ga_enable_admin         = '1'; 
			if ($ga_enable_administrator == 'yes' or $ga_enable_administrator == 'y') $ga_enable_administrator = '1'; 
			if ($ga_enable_logged        == 'yes' or $ga_enable_logged        == 'y') $ga_enable_logged        = '1'; 
			if ($ga_enable_subdomain     == 'yes' or $ga_enable_subdomain     == 'y') $ga_enable_subdomain     = '1'; 
			if ($ga_enable_multiple      == 'yes' or $ga_enable_multiple      == 'y') $ga_enable_multiple      = '1'; 
			if ($ga_enable_advertiser    == 'yes' or $ga_enable_advertiser    == 'y') $ga_enable_advertiser    = '1'; 

			if ($ga_enable_front         == 'no'  or $ga_enable_front         == 'n') $ga_enable_front         = '1'; 
			if ($ga_enable_admin         == 'no'  or $ga_enable_admin         == 'n') $ga_enable_admin         = '1'; 
			if ($ga_enable_administrator == 'no'  or $ga_enable_administrator == 'n') $ga_enable_administrator = '1'; 
			if ($ga_enable_logged        == 'no'  or $ga_enable_logged        == 'n') $ga_enable_logged        = '1'; 
			if ($ga_enable_subdomain     == 'no'  or $ga_enable_subdomain     == 'n') $ga_enable_subdomain     = '1'; 
			if ($ga_enable_multiple      == 'no'  or $ga_enable_multiple      == 'n') $ga_enable_multiple      = '1'; 
			if ($ga_enable_advertiser    == 'no'  or $ga_enable_advertiser    == 'n') $ga_enable_advertiser    = '1'; 

			// Controllo se sono loggato come amministratore o utente registrato
			// e disattivo il caricamento del codice se le opzioni sono disattivate 

			$useract = true;

			if (current_user_can('manage_options')) {
				if ($ga_enable_administrator == '0') $useract = false;
			} else {
				if (is_user_logged_in() and $ga_enable_logged == '0') $useract = false;   
			}

			// Controllo se sono in backend o frontend e abilito l'esecuzione del codice
			// solo se le opzioni corrispondenti sono state attivate in configurazione

			if ( is_admin() and $ga_enable_admin == '0') $useract = false;
			if (!is_admin() and $ga_enable_front == '0') $useract = false;

			// Se il codice non deve essere attivato in base alle opzioni passate
			// ritorno un valore di false e non elaboro la creazione del monitoraggio

			if (!$useract or strlen($ga_uacode) <= 0) {
				return false;
			}

			// Conversione dei valori specificati direttamete nei parametri con
			// i valori usati per la memorizzazione dei valori di default

			if ($ga_position == '') $ga_position = 'H';
			if ($ga_uacode   == '') $ga_uacode   = $this->getGAId();   

			if (!in_array($ga_type,array('classic','universal'))) $ga_type = 'classic';

			// Creazione codice per i commenti di blocco nel caso
			// risultasse attiva la generazione del codice GA

			$HTML = '';

			if ($ga_position != 'F' and ($ga_type == 'universal' or $ga_type == 'classic')) {
				$HTML .= "\n";
				$HTML .= "<!-- GA tracking code with SZ-Google ".SZ_PLUGIN_GOOGLE_VERSION." : activated mode ".strtoupper($ga_type)."      -->\n";
				$HTML .= "<!-- ===================================================================== -->\n";
			}

			// Creazione codice di google analytics UNIVERSAL da inserire su pagina HTML
			// che può essere differente in base a google classic o universal analytics

			if ($ga_type == 'universal') 
			{
				$HTML .= '<script type="text/javascript">//<![CDATA['."\n";
				$HTML .= "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){"."\n";
				$HTML .= "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),"."\n";
				$HTML .= "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)"."\n";
				$HTML .= "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');"."\n";
				$HTML .= "ga('create','".trim($ga_uacode)."','".trim(SZGoogleCommon::getCurrentDomain())."');"."\n";
				$HTML .= "ga('send','pageview');"."\n";
				$HTML .= "//]]></script>"."\n";
			}

			// Creazione codice di google analytics CLASSIC da inserire su pagina HTML
			// che può essere differente in base a google classic o universal analytics

			if ($ga_type == 'classic') 
			{
				$HTML .= '<script type="text/javascript">//<![CDATA['."\n";
				$HTML .= "var _gaq = _gaq || [];"."\n";
				$HTML .= "_gaq.push(['_setAccount','".$ga_uacode."']);"."\n";

				// Se opzione subdomains o multiple risulta attivata aggiungo una nuova riga
				// di codice contenente il _setDomainName del domino corrente visualizzato

				if ($ga_enable_subdomain == '1' or $ga_enable_multiple  == '1') {
					$HTML .= "_gaq.push(['_setDomainName','".trim(SZGoogleCommon::getCurrentDomain())."']);"."\n";
				}

				// Se opzione multiple risulta attivata aggiungo una nuova riga con il codice
				// javascript di google analytics con l'impostazione di _setAllowLinker

				if ($ga_enable_multiple == '1') {
					$HTML .= "_gaq.push(['_setAllowLinker',true]);"."\n";
				}

				$HTML .= "_gaq.push(['_trackPageview']);"."\n";

				$HTML .= "(function () {"."\n";
				$HTML .= "var ga = document.createElement('script');"."\n";
				$HTML .= "ga.type = 'text/javascript';"."\n";
				$HTML .= "ga.async = true;"."\n";

				if ($ga_enable_advertiser == '1') $HTML .= "ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';"."\n";
					else $HTML .= "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';"."\n";

				$HTML .= "var s = document.getElementsByTagName('script')[0];"."\n";
				$HTML .= "s.parentNode.insertBefore(ga, s);"."\n";
				$HTML .= "})();"."\n";
				$HTML .= "//]]></script>"."\n";
			}

			// Creazione codice per i commenti di blocco nel caso
			// risultasse attiva la generazione del codice GA

			if ($ga_position != 'F' and ($ga_type == 'universal' or $ga_type == 'classic')) {
				$HTML .= "<!-- ===================================================================== -->\n\n";
			}

			return $HTML;
		}
	}
}