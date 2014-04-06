<?php
/**
 * Modulo GOOGLE FONTS per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleModuleFonts'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleFonts extends SZGoogleModule
	{
		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			parent::__construct('SZGoogleModuleFonts');

			// Esecuzione dei componenti esistenti legati al modulo come
			// le azioni generali e la generazione di shortcode e widget.

			$this->moduleAddActions();		
		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptions()
		{
			$options = get_option('sz_google_options_fonts');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'fonts_family_L1_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_L2_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_L3_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_L4_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_L5_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_L6_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_B1_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_P1_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_B2_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_H1_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_H2_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_H3_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_H4_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_H5_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'fonts_family_H6_name'              => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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

			// Controllo se devo attivare il sistema di caricamento per i fonts
			// indicati nel pannello di amministrazione (attivi e con nome)

			$testvalue = array(SZ_PLUGIN_GOOGLE_VALUE_NULL,SZ_PLUGIN_GOOGLE_FONTS_NULL);

			if (!in_array($options['fonts_family_L1_name'],$testvalue) or
		    	!in_array($options['fonts_family_L2_name'],$testvalue) or
		    	!in_array($options['fonts_family_L3_name'],$testvalue) or
		    	!in_array($options['fonts_family_L4_name'],$testvalue) or
		    	!in_array($options['fonts_family_L5_name'],$testvalue) or
		    	!in_array($options['fonts_family_L6_name'],$testvalue) or
		    	!in_array($options['fonts_family_B1_name'],$testvalue) or
		    	!in_array($options['fonts_family_P1_name'],$testvalue) or
		    	!in_array($options['fonts_family_B2_name'],$testvalue) or
		    	!in_array($options['fonts_family_H1_name'],$testvalue) or
		    	!in_array($options['fonts_family_H2_name'],$testvalue) or
		    	!in_array($options['fonts_family_H3_name'],$testvalue) or
		    	!in_array($options['fonts_family_H4_name'],$testvalue) or
		    	!in_array($options['fonts_family_H5_name'],$testvalue) or
		    	!in_array($options['fonts_family_H6_name'],$testvalue))
			{
				add_action('szgoogle_head',array($this,'moduleAddFonts'),20);
			}

			// Controllo se è stato specificato un livello che necessita il
			// codice CSS automatico per essere applicato all'elemento selezionato

			if (!in_array($options['fonts_family_B1_name'],$testvalue) or
			    !in_array($options['fonts_family_P1_name'],$testvalue) or
			    !in_array($options['fonts_family_B2_name'],$testvalue) or
			    !in_array($options['fonts_family_H1_name'],$testvalue) or
			    !in_array($options['fonts_family_H2_name'],$testvalue) or
		    	!in_array($options['fonts_family_H3_name'],$testvalue) or
			    !in_array($options['fonts_family_H4_name'],$testvalue) or
			    !in_array($options['fonts_family_H5_name'],$testvalue) or
			    !in_array($options['fonts_family_H6_name'],$testvalue))
			{
				add_action('szgoogle_css_inline',array($this,'moduleAddCSS'),20);
			}
		}

		/**
		 * Aggiungo informazione in <head> per il caricamento dei fonts
		 * necessari all'assegnazione in body manuale o automatica
		 *
		 * @return void
		 */
		function moduleAddFonts()
		{
			$options = $this->getOptions();

			// Preparazione array di lavoro e controllo i livelli disponibili
			// per poter indicare il font da caricare che è stato specificato

			$fontslist = array();
			$fontsload = array();
			$testvalue = array(SZ_PLUGIN_GOOGLE_VALUE_NULL,SZ_PLUGIN_GOOGLE_FONTS_NULL);

			if (!in_array($options['fonts_family_L1_name'],$testvalue)) $fontslist[] = $options['fonts_family_L1_name'];
			if (!in_array($options['fonts_family_L2_name'],$testvalue)) $fontslist[] = $options['fonts_family_L2_name'];
			if (!in_array($options['fonts_family_L3_name'],$testvalue)) $fontslist[] = $options['fonts_family_L3_name'];
			if (!in_array($options['fonts_family_L4_name'],$testvalue)) $fontslist[] = $options['fonts_family_L4_name'];
			if (!in_array($options['fonts_family_L5_name'],$testvalue)) $fontslist[] = $options['fonts_family_L5_name'];
			if (!in_array($options['fonts_family_L6_name'],$testvalue)) $fontslist[] = $options['fonts_family_L6_name'];
			if (!in_array($options['fonts_family_B1_name'],$testvalue)) $fontslist[] = $options['fonts_family_B1_name'];
			if (!in_array($options['fonts_family_P1_name'],$testvalue)) $fontslist[] = $options['fonts_family_P1_name'];
			if (!in_array($options['fonts_family_B2_name'],$testvalue)) $fontslist[] = $options['fonts_family_B2_name'];
			if (!in_array($options['fonts_family_H1_name'],$testvalue)) $fontslist[] = $options['fonts_family_H1_name'];
			if (!in_array($options['fonts_family_H2_name'],$testvalue)) $fontslist[] = $options['fonts_family_H2_name'];
			if (!in_array($options['fonts_family_H3_name'],$testvalue)) $fontslist[] = $options['fonts_family_H3_name'];
			if (!in_array($options['fonts_family_H4_name'],$testvalue)) $fontslist[] = $options['fonts_family_H4_name'];
			if (!in_array($options['fonts_family_H5_name'],$testvalue)) $fontslist[] = $options['fonts_family_H5_name'];
			if (!in_array($options['fonts_family_H6_name'],$testvalue)) $fontslist[] = $options['fonts_family_H6_name'];

			// Leggo tutti i font elencati e preparo un array senza ulteriori doppioni
			// in quanto è possibile indicare lo stesso font su diversi livelli

			foreach ($fontslist as $key=>$value) {
				if (!isset($fontsload[$value])) $fontsload[$value] = $value;
			}

			// Se array dei fonts da caricare contiene qualche elemento provvedo al caricamento
			// multiplo usando però una sola istruzione di stylesheet come da sintassi google

			if (!empty($fontsload)) 
			{
				$fontstring = urlencode(implode('|',$fontsload));
				echo '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family='.$fontstring.'">'."\n";
			}
		}

		/**
		 * Aggiungo informazione in <head> per il caricamento dei fonts
		 * necessari all'assegnazione in body manuale o automatica
		 *
		 * @return void
		 */
		function moduleAddCSS()
		{
			$options = $this->getOptions();
			$testvalue = array(SZ_PLUGIN_GOOGLE_VALUE_NULL,SZ_PLUGIN_GOOGLE_FONTS_NULL);

			echo "<style>\n";

			if (!in_array($options['fonts_family_B1_name'],$testvalue)) echo "  body { font-family:'".$options['fonts_family_B1_name']."' }\n";
			if (!in_array($options['fonts_family_P1_name'],$testvalue)) echo "  p { font-family:'".$options['fonts_family_P1_name']."' }\n";
			if (!in_array($options['fonts_family_B2_name'],$testvalue)) echo "  blockquote { font-family:'".$options['fonts_family_B2_name']."' }\n";
			if (!in_array($options['fonts_family_H1_name'],$testvalue)) echo "  h1 { font-family:'".$options['fonts_family_H1_name']."' }\n";
			if (!in_array($options['fonts_family_H2_name'],$testvalue)) echo "  h2 { font-family:'".$options['fonts_family_H2_name']."' }\n";
			if (!in_array($options['fonts_family_H3_name'],$testvalue)) echo "  h3 { font-family:'".$options['fonts_family_H3_name']."' }\n";
			if (!in_array($options['fonts_family_H4_name'],$testvalue)) echo "  h4 { font-family:'".$options['fonts_family_H4_name']."' }\n";
			if (!in_array($options['fonts_family_H5_name'],$testvalue)) echo "  h5 { font-family:'".$options['fonts_family_H5_name']."' }\n";
			if (!in_array($options['fonts_family_H6_name'],$testvalue)) echo "  h6 { font-family:'".$options['fonts_family_H6_name']."' }\n";

			echo "</style>\n";
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */
	if (!function_exists('szgoogle_fonts_get_object')) {
		function szgoogle_fonts_get_object() { 
			if (!is_a(SZGoogleModule::$SZGoogleModuleFonts,'SZGoogleModuleFonts')) return false;
				else return SZGoogleModule::$SZGoogleModuleFonts;
		}
	}
}